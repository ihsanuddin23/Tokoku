<?php

namespace App\Http\Controllers;

use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BecomeSellerController extends Controller
{
    public function index(Request $request): View
    {
        $verification = $request->user()->sellerVerification;

        return view('become-seller', compact('verification'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->sellerVerification) {
            if ($user->sellerVerification->status === 'rejected') {
                $user->sellerVerification->delete();
            } else {
                return redirect()->route('become-seller')
                    ->with('info', 'Anda sudah mengajukan pendaftaran seller.');
            }
        }

        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $user->sellerVerification()->create($validated);

        return redirect()->route('become-seller')
            ->with('status', 'seller-application-submitted');
    }
}
