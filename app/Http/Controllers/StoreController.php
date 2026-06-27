<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $store = SellerProfile::where('store_slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $store->products()
            ->active()
            ->with('category')
            ->when($request->sort, function ($q, $sort) {
                match ($sort) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'popular' => $q->orderBy('total_sold', 'desc'),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        return view('stores.show', compact('store', 'products'));
    }
}
