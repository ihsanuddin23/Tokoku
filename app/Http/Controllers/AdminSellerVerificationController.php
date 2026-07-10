<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use App\Models\SellerVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminSellerVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $verifications = SellerVerification::query()
            ->with('user')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.verifications.index', compact('verifications'));
    }

    public function approve(Request $request, SellerVerification $verification): RedirectResponse
    {
        if ($verification->status !== 'pending') {
            return back()->with('info', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($verification) {
            $verification->forceFill([
                'status' => 'approved',
                'reviewed_at' => now(),
            ])->save();

            $user = $verification->user;
            $user->forceFill(['role' => 'seller'])->save();

            $storeSlug = \Illuminate\Support\Str::slug($verification->store_name);
            $originalSlug = $storeSlug;
            $counter = 1;
            while (SellerProfile::where('store_slug', $storeSlug)->where('user_id', '!=', $user->id)->exists()) {
                $storeSlug = $originalSlug . '-' . $counter++;
            }

            $profile = $user->sellerProfile;
            if ($profile) {
                $profile->forceFill([
                    'store_name' => $verification->store_name,
                    'store_slug' => $storeSlug,
                    'description' => $verification->description,
                    'city' => $verification->city,
                    'is_verified' => true,
                    'is_active' => true,
                ])->save();
            } else {
                $profile = $user->sellerProfile()->create([
                    'store_name' => $verification->store_name,
                    'store_slug' => $storeSlug,
                    'description' => $verification->description,
                    'city' => $verification->city,
                ]);
                $profile->forceFill([
                    'is_verified' => true,
                    'is_active' => true,
                ])->save();
            }
        });

        return back()->with('status', 'seller-approved');
    }

    public function reject(Request $request, SellerVerification $verification): RedirectResponse
    {
        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:500'],
        ]);

        if ($verification->status !== 'pending') {
            return back()->with('info', 'Pengajuan ini sudah diproses.');
        }

        $verification->forceFill([
            'status' => 'rejected',
            'admin_note' => $validated['admin_note'],
            'reviewed_at' => now(),
        ])->save();

        return back()->with('status', 'seller-rejected');
    }
}
