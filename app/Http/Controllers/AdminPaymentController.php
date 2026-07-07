<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with('user', 'items')
            ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->payment_method, fn ($q) => $q->where('payment_method', $request->payment_method))
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total'      => Order::count(),
            'paid'       => Order::where('payment_status', 'paid')->count(),
            'unpaid'     => Order::where('payment_status', 'unpaid')->count(),
            'refunded'   => Order::where('payment_status', 'refunded')->count(),
            'midtrans'   => Order::where('payment_method', 'midtrans')->count(),
            'cod'        => Order::where('payment_method', 'cod')->count(),
            'revenue'    => Order::where('payment_status', 'paid')->sum('grand_total'),
        ];

        return view('admin.payments.index', compact('orders', 'stats'));
    }

    public function show(Order $order): View
    {
        $order->load('user', 'items.product', 'address');

        return view('admin.payments.show', compact('order'));
    }

    public function markPaid(Order $order): RedirectResponse
    {
        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Pembayaran sudah ditandai sebagai lunas.');
        }

        $order->forceFill([
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ])->save();

        if ($order->status === 'pending') {
            $order->forceFill(['status' => 'paid'])->save();
        }

        ActivityLog::log('mark_paid', 'payments', "Marked order {$order->order_number} as paid");

        return redirect()->route('admin.payments.index')
            ->with('status', 'payment-marked-paid');
    }

    public function markRefunded(Order $order): RedirectResponse
    {
        if (! in_array($order->payment_status, ['paid'])) {
            return back()->with('info', 'Hanya pesanan yang sudah dibayar yang dapat di-refund.');
        }

        $order->forceFill([
            'payment_status' => 'refunded',
        ])->save();

        ActivityLog::log('mark_refunded', 'payments', "Marked order {$order->order_number} as refunded");

        return redirect()->route('admin.payments.index')
            ->with('status', 'payment-marked-refunded');
    }
}
