<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use App\Models\StoreFollower;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->when($request->sort, function ($q, $sort) {
                match ($sort) {
                    'price_asc'  => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'popular'    => $q->orderBy('total_sold', 'desc'),
                    'rating'     => $q->orderByDesc('rating'),
                    default      => $q->latest(),
                };
            }, fn ($q) => $q->orderBy('total_sold', 'desc'))
            ->paginate(12)
            ->withQueryString();

        $storeCategories = $store->products()
            ->active()
            ->with('category')
            ->get()
            ->pluck('category')
            ->unique('id')
            ->filter()
            ->sortBy('name');

        $totalSold   = $store->products()->active()->sum('total_sold');
        $reviewCount = \App\Models\ProductReview::whereHas('product', fn ($q) => $q->where('seller_profile_id', $store->id))->count();
        $avgRating   = \App\Models\ProductReview::whereHas('product', fn ($q) => $q->where('seller_profile_id', $store->id))->avg('rating');
        $followerCount = $store->followerCount();
        $isFollowing = $store->isFollowedBy($request->user());

        return view('stores.show', compact('store', 'products', 'storeCategories', 'totalSold', 'reviewCount', 'avgRating', 'followerCount', 'isFollowing'));
    }

    public function follow(Request $request, SellerProfile $sellerProfile): JsonResponse|RedirectResponse
    {
        if (! $sellerProfile->is_active) {
            return response()->json(['error' => 'Toko ini tidak tersedia.'], 404);
        }

        if ($sellerProfile->user_id === $request->user()->id) {
            return response()->json(['error' => 'Tidak bisa mengikuti toko sendiri.'], 400);
        }

        StoreFollower::firstOrCreate([
            'user_id' => $request->user()->id,
            'seller_profile_id' => $sellerProfile->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'followed',
                'followerCount' => $sellerProfile->followerCount(),
            ]);
        }

        return back()->with('status', 'store-followed');
    }

    public function unfollow(Request $request, SellerProfile $sellerProfile): JsonResponse|RedirectResponse
    {
        StoreFollower::where('user_id', $request->user()->id)
            ->where('seller_profile_id', $sellerProfile->id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'unfollowed',
                'followerCount' => $sellerProfile->followerCount(),
            ]);
        }

        return back()->with('status', 'store-unfollowed');
    }

    public function followed(Request $request): View
    {
        $followedStores = $request->user()
            ->followedStores()
            ->with(['sellerProfile' => fn ($q) => $q->withCount(['products as active_products_count' => fn ($q2) => $q2->where('status', 'active')])])
            ->latest('created_at')
            ->paginate(12);

        return view('stores.followed', compact('followedStores'));
    }
}
