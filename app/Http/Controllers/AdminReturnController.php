<?php

namespace App\Http\Controllers;

use App\Models\ReturnRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReturnController extends Controller
{
    public function index(Request $request): View
    {
        $returns = ReturnRequest::with('order', 'user', 'orderItem')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('admin.returns.index', compact('returns'));
    }

    public function show(ReturnRequest $return): View
    {
        $return->load('order.items', 'user', 'orderItem');

        return view('admin.returns.show', compact('return'));
    }

    public function approve(Request $request, ReturnRequest $return): RedirectResponse
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        if ($return->status !== 'pending') {
            return back()->with('info', 'Pengajuan ini sudah diproses.');
        }

        $return->forceFill([
            'status'       => 'approved',
            'admin_note'   => $request->input('admin_note'),
            'processed_at' => now(),
        ])->save();

        ActivityLog::log('approve_return', 'returns', "Approved return request #{$return->id} for order {$return->order->order_number}");

        return redirect()->route('admin.returns.index')
            ->with('status', 'return-approved');
    }

    public function reject(Request $request, ReturnRequest $return): RedirectResponse
    {
        $request->validate([
            'admin_note' => ['required', 'string', 'max:500'],
        ]);

        if ($return->status !== 'pending') {
            return back()->with('info', 'Pengajuan ini sudah diproses.');
        }

        $return->forceFill([
            'status'       => 'rejected',
            'admin_note'   => $request->input('admin_note'),
            'processed_at' => now(),
        ])->save();

        ActivityLog::log('reject_return', 'returns', "Rejected return request #{$return->id} for order {$return->order->order_number}");

        return redirect()->route('admin.returns.index')
            ->with('status', 'return-rejected');
    }

    public function refund(ReturnRequest $return): RedirectResponse
    {
        if ($return->status !== 'approved') {
            return back()->with('info', 'Hanya pengajuan yang disetujui yang dapat dikembalikan dananya.');
        }

        $order = $return->order;

        $return->forceFill([
            'status'       => 'refunded',
            'processed_at' => now(),
        ])->save();

        $order->forceFill([
            'payment_status' => 'refunded',
        ])->save();

        ActivityLog::log('refund_return', 'returns', "Refunded return request #{$return->id} for order {$order->order_number}");

        return redirect()->route('admin.returns.index')
            ->with('status', 'return-refunded');
    }
}
