<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPayoutController extends Controller
{
    public function index(Request $request): View
    {
        $payouts = Payout::with('sellerProfile.user')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('admin.payouts.index', compact('payouts'));
    }

    public function show(Payout $payout): View
    {
        $payout->load('sellerProfile.user');

        return view('admin.payouts.show', compact('payout'));
    }

    public function process(Request $request, Payout $payout): RedirectResponse
    {
        if ($payout->status !== 'pending') {
            return back()->with('info', 'Penarikan ini sudah diproses.');
        }

        $payout->forceFill([
            'status'       => 'processing',
            'processed_at' => now(),
        ])->save();

        return redirect()->route('admin.payouts.index')
            ->with('status', 'payout-processing');
    }

    public function complete(Request $request, Payout $payout): RedirectResponse
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        if ($payout->status !== 'processing') {
            return back()->with('info', 'Hanya penarikan yang sedang diproses yang dapat diselesaikan.');
        }

        $payout->forceFill([
            'status'       => 'completed',
            'completed_at' => now(),
            'admin_note'   => $request->input('admin_note'),
        ])->save();

        return redirect()->route('admin.payouts.index')
            ->with('status', 'payout-completed');
    }

    public function reject(Request $request, Payout $payout): RedirectResponse
    {
        $request->validate([
            'admin_note' => ['required', 'string', 'max:500'],
        ]);

        if (! in_array($payout->status, ['pending', 'processing'])) {
            return back()->with('info', 'Penarikan ini sudah selesai.');
        }

        $payout->forceFill([
            'status'     => 'rejected',
            'admin_note' => $request->input('admin_note'),
        ])->save();

        \App\Models\OrderItem::where('payout_id', $payout->id)->update(['payout_id' => null]);

        return redirect()->route('admin.payouts.index')
            ->with('status', 'payout-rejected');
    }
}
