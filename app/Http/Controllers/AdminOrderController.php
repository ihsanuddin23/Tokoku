<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', "%{$request->search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$request->search}%")
                            ->orWhere('email', 'like', "%{$request->search}%"));
                });
            })
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product.sellerProfile', 'items.variant', 'address', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $order->status;

        if ($newStatus === $oldStatus) {
            return back()->with('info', 'Status pesanan tidak berubah.');
        }

        $updates = ['status' => $newStatus];

        if ($newStatus === 'paid' && ! $order->paid_at) {
            $updates['paid_at'] = now();
            $updates['payment_status'] = 'paid';
        }
        if ($newStatus === 'shipped') {
            $updates['shipped_at'] = now();
            $updates['paid_at'] = $order->paid_at ?? now();
        }
        if ($newStatus === 'completed') {
            $updates['completed_at'] = now();
            $updates['paid_at'] = $order->paid_at ?? now();
            $updates['shipped_at'] = $order->shipped_at ?? now();
            $order->items()->where('status', '!=', 'completed')->update(['status' => 'completed']);
        }
        if ($newStatus === 'cancelled') {
            $updates['cancelled_at'] = now();
        }

        DB::transaction(function () use ($order, $newStatus, $oldStatus, $updates) {
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                $order->load('items.variant');
                $productIds = $order->items->pluck('product_id');
                $products = \App\Models\Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');
                $variantIds = $order->items->pluck('product_variant_id')->filter()->values();
                $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');
                foreach ($order->items as $item) {
                    $product = $products[$item->product_id] ?? null;
                    if ($product) {
                        if ($item->product_variant_id && isset($variants[$item->product_variant_id])) {
                            $variants[$item->product_variant_id]->increment('stock', $item->quantity);
                        } else {
                            $product->increment('stock', $item->quantity);
                        }
                        $product->decrement('total_sold', $item->quantity);
                    }
                }
            }

            $order->forceFill($updates)->save();
        });

        ActivityLog::log('update_order_status', 'orders', "Updated order {$order->order_number} status from {$oldStatus} to {$newStatus}");

        return back()->with('status', 'order-status-updated');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=orders-' . date('Y-m-d') . '.csv',
        ];

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['No. Pesanan', 'Pembeli', 'Email', 'Total', 'Status', 'Status Pembayaran', 'Metode Pembayaran', 'Tanggal']);

            Order::with('user')
                ->when($request->search, function ($q) use ($request) {
                    $q->where(function ($q) use ($request) {
                        $q->where('order_number', 'like', "%{$request->search}%")
                            ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$request->search}%"));
                    });
                })
                ->when($request->status, fn ($q) => $q->where('status', $request->status))
                ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
                ->latest()
                ->chunk(200, function ($orders) use ($handle) {
                    foreach ($orders as $order) {
                        fputcsv($handle, [
                            $order->order_number,
                            $order->user?->name ?? 'N/A',
                            $order->user?->email ?? 'N/A',
                            $order->grand_total,
                            $order->status,
                            $order->payment_status,
                            $order->payment_method,
                            $order->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
