<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Payout;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerPayoutController extends Controller
{
    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $payouts = $sellerProfile->payouts()
            ->latest()
            ->paginate(10);

        $pendingEarnings = $this->calculatePendingEarnings($sellerProfile->id);
        $totalEarnings = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->where('status', 'completed')
            ->sum('subtotal');
        $totalPaidOut = $sellerProfile->payouts()
            ->where('status', 'completed')
            ->sum('amount');

        return view('seller.payouts.index', compact('payouts', 'pendingEarnings', 'totalEarnings', 'totalPaidOut'));
    }

    public function request(Request $request): RedirectResponse
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $request->validate([
            'bank_name'           => ['required', 'string', 'max:100'],
            'bank_account_name'   => ['required', 'string', 'max:100'],
            'bank_account_number' => ['required', 'string', 'max:50'],
        ]);

        $pendingEarnings = $this->calculatePendingEarnings($sellerProfile->id);

        $minPayout = (float) Setting::get('min_payout_amount', 100000);

        if ($pendingEarnings < $minPayout) {
            return back()->with('info', 'Minimum penarikan adalah Rp ' . number_format($minPayout, 0, ',', '.'));
        }

        $existingPending = Payout::where('seller_profile_id', $sellerProfile->id)
            ->whereIn('status', ['pending', 'processing'])
            ->exists();

        if ($existingPending) {
            return back()->with('info', 'Anda masih memiliki pengajuan penarikan yang sedang diproses.');
        }

        $fee = (float) Setting::get('payout_fee', 0);
        $netAmount = $pendingEarnings - $fee;

        $eligibleItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->where('status', 'completed')
            ->whereNull('payout_id')
            ->pluck('id')
            ->toArray();

        $payoutNumber = 'PAY-' . str_pad((string) Payout::max('id') + 1, 6, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($sellerProfile, $request, $pendingEarnings, $fee, $netAmount, $eligibleItems, $payoutNumber) {
            $payout = Payout::create([
                'seller_profile_id'   => $sellerProfile->id,
                'payout_number'       => $payoutNumber,
                'amount'              => $pendingEarnings,
                'fee'                 => $fee,
                'net_amount'          => $netAmount,
                'status'              => 'pending',
                'bank_name'           => $request->bank_name,
                'bank_account_name'   => $request->bank_account_name,
                'bank_account_number' => $request->bank_account_number,
            ]);

            OrderItem::whereIn('id', $eligibleItems)->update(['payout_id' => $payout->id]);
        });

        return redirect()->route('seller.payouts.index')
            ->with('status', 'payout-requested');
    }

    private function calculatePendingEarnings(int $sellerProfileId): float
    {
        return (float) OrderItem::where('seller_profile_id', $sellerProfileId)
            ->where('status', 'completed')
            ->whereNull('payout_id')
            ->sum('subtotal');
    }
}
