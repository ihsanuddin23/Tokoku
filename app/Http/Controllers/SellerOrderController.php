<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;

        $orderItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->paginate(10);

        $validTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['shipped'],
            'shipped' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        return view('seller.orders.index', compact('orderItems', 'validTransitions'));
    }

    public function updateStatus(Request $request, OrderItem $orderItem): RedirectResponse
    {
        if ($orderItem->seller_profile_id !== $request->user()->sellerProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $oldStatus = $orderItem->status;

        $validTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['shipped'],
            'shipped' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        if (! in_array($validated['status'], $validTransitions[$oldStatus] ?? [])) {
            return back()->with('info', "Tidak dapat mengubah status dari \"{$oldStatus}\" ke \"{$validated['status']}\".");
        }

        DB::transaction(function () use ($orderItem, $validated, $oldStatus) {
            $orderItem->update([
                'status' => $validated['status'],
            ]);

            if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
                if ($orderItem->product) {
                    $orderItem->product->increment('stock', $orderItem->quantity);
                    $orderItem->product->decrement('total_sold', $orderItem->quantity);
                }
            } elseif ($oldStatus === 'cancelled' && $validated['status'] !== 'cancelled') {
                if ($orderItem->product) {
                    $orderItem->product->decrement('stock', $orderItem->quantity);
                    $orderItem->product->increment('total_sold', $orderItem->quantity);
                }
            }

            $order = $orderItem->order;

            $allItems = $order->items;
            $statuses = $allItems->pluck('status')->unique();

            $orderStatus = match (true) {
                $statuses->contains('cancelled') && $statuses->count() === 1 => 'cancelled',
                $statuses->contains('pending') => 'pending',
                $statuses->contains('paid') => 'paid',
                $statuses->contains('shipped') => 'shipped',
                $statuses->count() === 1 && $statuses->first() === 'completed' => 'completed',
                default => $order->status,
            };

            $orderUpdate = ['status' => $orderStatus];

            if ($orderStatus === 'cancelled' && ! $order->cancelled_at) {
                $orderUpdate['cancelled_at'] = now();
            }

            if ($validated['status'] === 'paid' && ! $order->paid_at) {
                $orderUpdate['paid_at'] = now();
            }

            if ($validated['status'] === 'shipped') {
                $orderUpdate['paid_at'] = $order->paid_at ?? now();
                $orderUpdate['shipped_at'] = $order->shipped_at ?? now();
            }

            if ($validated['status'] === 'completed') {
                $orderUpdate['paid_at'] = $order->paid_at ?? now();
                $orderUpdate['shipped_at'] = $order->shipped_at ?? now();
                $orderUpdate['completed_at'] = $order->completed_at ?? now();
            }

            $order->update($orderUpdate);
        });

        return redirect()->route('seller.orders.index')
            ->with('status', 'order-status-updated');
    }
}
