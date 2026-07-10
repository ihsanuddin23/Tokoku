<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdated;
use App\Notifications\OrderStatusNotification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SellerOrderController extends Controller
{
    private const VALID_TRANSITIONS = [
        'pending' => ['paid', 'cancelled'],
        'paid' => ['shipped'],
        'shipped' => ['completed'],
        'completed' => [],
        'cancelled' => [],
    ];

    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $orderItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->paginate(10);

        $validTransitions = self::VALID_TRANSITIONS;

        return view('seller.orders.index', compact('orderItems', 'validTransitions'));
    }

    public function show(Request $request, Order $order): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $hasItem = $order->items()->where('seller_profile_id', $sellerProfile->id)->exists();
        if (! $hasItem) {
            abort(403);
        }

        $order->load(['items' => function ($q) use ($sellerProfile) {
            $q->where('seller_profile_id', $sellerProfile->id)->with(['product', 'variant']);
        }, 'user', 'address', 'payment']);

        $validTransitions = self::VALID_TRANSITIONS;

        return view('seller.orders.show', compact('order', 'validTransitions'));
    }

    public function updateStatus(Request $request, OrderItem $orderItem): RedirectResponse
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');
        $this->authorize('updateStatus', $orderItem);

        $validated = $request->validate([
            'status'          => ['required', 'in:pending,paid,shipped,completed,cancelled'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $oldStatus = $orderItem->status;
        $oldOrderStatus = $orderItem->order->status;

        $orderItem->load(['product', 'variant']);

        if (! in_array($validated['status'], self::VALID_TRANSITIONS[$oldStatus] ?? [])) {
            return back()->with('info', "Tidak dapat mengubah status dari \"{$oldStatus}\" ke \"{$validated['status']}\".");
        }

        DB::transaction(function () use ($orderItem, $validated, $oldStatus) {
            $orderItem->forceFill([
                'status' => $validated['status'],
            ])->save();

            if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
                if ($orderItem->variant) {
                    $orderItem->variant->increment('stock', $orderItem->quantity);
                } elseif ($orderItem->product) {
                    $orderItem->product->increment('stock', $orderItem->quantity);
                }
                if ($orderItem->product) {
                    $orderItem->product->decrement('total_sold', $orderItem->quantity);
                }
            } elseif ($oldStatus === 'cancelled' && $validated['status'] !== 'cancelled') {
                if ($orderItem->variant) {
                    $orderItem->variant->decrement('stock', $orderItem->quantity);
                } elseif ($orderItem->product) {
                    $orderItem->product->decrement('stock', $orderItem->quantity);
                }
                if ($orderItem->product) {
                    $orderItem->product->increment('total_sold', $orderItem->quantity);
                }
            }

            $order = $orderItem->order;

            $allItems = $order->items()->get();
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
                if (! empty($validated['tracking_number'])) {
                    $orderUpdate['tracking_number'] = $validated['tracking_number'];
                }
            }

            if ($validated['status'] === 'completed') {
                $orderUpdate['paid_at'] = $order->paid_at ?? now();
                $orderUpdate['shipped_at'] = $order->shipped_at ?? now();
                $orderUpdate['completed_at'] = $order->completed_at ?? now();
            }

            $order->forceFill($orderUpdate)->save();
        });

        $freshOrder = Order::with('user')->find($orderItem->order_id);
        $newOrderStatus = $freshOrder->status;

        if ($freshOrder->user) {
            if ($oldOrderStatus !== $newOrderStatus) {
                Mail::to($freshOrder->user->email)
                    ->queue(new OrderStatusUpdated($freshOrder, $oldOrderStatus, $newOrderStatus));
            }
            $freshOrder->user->notify(
                new OrderStatusNotification($freshOrder, $oldStatus, $validated['status'], route('orders.show', $freshOrder->id))
            );
        }

        $referer = request()->headers->get('referer', '');
        if (str_contains($referer, '/seller/orders/' . $orderItem->order_id)) {
            return redirect()->route('seller.orders.show', $orderItem->order_id)
                ->with('status', 'order-status-updated');
        }

        return redirect()->route('seller.orders.index')
            ->with('status', 'order-status-updated');
    }
}
