<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerStoreController extends Controller
{
    public function edit(Request $request): View
    {
        $store = $request->user()->sellerProfile;

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request): RedirectResponse
    {
        $store = $request->user()->sellerProfile;

        $validated = $request->validate([
            'store_name'  => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'city'        => ['required', 'string', 'max:100'],
            'logo'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'banner'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $validated['logo'] = $request->file('logo')->store('stores', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('public')->delete($store->banner);
            }
            $validated['banner'] = $request->file('banner')->store('stores', 'public');
        }

        if ($store->store_name !== $validated['store_name']) {
            $slug = Str::slug($validated['store_name']);
            $original = $slug;
            $counter = 1;
            while (SellerProfile::where('store_slug', $slug)->where('id', '!=', $store->id)->exists()) {
                $slug = $original . '-' . $counter++;
            }
            $validated['store_slug'] = $slug;
        }

        $store->update($validated);

        return redirect()->route('seller.store.edit')
            ->with('status', 'store-updated');
    }
}
