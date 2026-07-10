<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::cachedActive();

        $products = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->with(['sellerProfile', 'category'])
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->when($request->min_price, fn ($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn ($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->condition, fn ($q) => $q->where('condition', $request->condition))
            ->when($request->min_rating, fn ($q) => $q->where('rating', '>=', $request->min_rating))
            ->when($request->sort, function ($q, $sort) {
                match ($sort) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest' => $q->latest(),
                    'popular' => $q->orderBy('total_sold', 'desc'),
                    'rating' => $q->orderBy('rating', 'desc')->orderBy('review_count', 'desc'),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Request $request, Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        // Eager load everything upfront
        $product->load(['sellerProfile', 'category', 'activeVariants']);

        if (! $product->sellerProfile || ! $product->sellerProfile->is_active) {
            abort(404);
        }

        // Track recently viewed products via cookie
        $viewed = json_decode($request->cookie('recently_viewed', '[]'), true);
        $viewed = array_filter($viewed, fn ($id) => $id !== $product->id);
        array_unshift($viewed, $product->id);
        $viewed = array_slice($viewed, 0, 10);

        // Reviews — simple paginate (1 query instead of 2)
        $reviews = $product->reviews()->with('user:id,name')->latest()->simplePaginate(5);

        // Single wishlist query for product + related + recently viewed
        $isWishlisted = false;
        $wishlistedIds = [];

        // Related products — select only needed columns, use join instead of whereHas
        $related = Product::active()
            ->join('seller_profiles', 'products.seller_profile_id', '=', 'seller_profiles.id')
            ->where('seller_profiles.is_active', true)
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $product->id)
            ->select('products.id', 'products.name', 'products.slug', 'products.price', 'products.images', 'products.condition', 'products.rating', 'products.review_count', 'products.total_sold', 'products.seller_profile_id')
            ->with(['sellerProfile:id,store_name,store_slug'])
            ->orderByDesc('products.total_sold')
            ->take(8)
            ->get();

        // Recently viewed — same join approach, select only needed columns
        $recentlyViewed = collect();
        $recentlyIds = array_slice($viewed, 1);
        if (! empty($recentlyIds)) {
            $recentlyViewed = Product::active()
                ->join('seller_profiles', 'products.seller_profile_id', '=', 'seller_profiles.id')
                ->where('seller_profiles.is_active', true)
                ->whereIn('products.id', $recentlyIds)
                ->select('products.id', 'products.name', 'products.slug', 'products.price', 'products.images', 'products.condition', 'products.seller_profile_id')
                ->with(['sellerProfile:id,store_name,store_slug'])
                ->take(5)
                ->get();
        }

        if ($request->user()) {
            $allProductIds = array_merge([$product->id], $related->pluck('id')->toArray(), $recentlyViewed->pluck('id')->toArray());
            $wishlistedIds = \App\Models\Wishlist::where('user_id', $request->user()->id)
                ->whereIn('product_id', $allProductIds)
                ->pluck('product_id')
                ->toArray();
            $isWishlisted = in_array($product->id, $wishlistedIds);
        }

        return response()->view('products.show', compact('product', 'related', 'reviews', 'isWishlisted', 'wishlistedIds', 'recentlyViewed'))
            ->cookie(cookie('recently_viewed', json_encode($viewed), 60 * 24 * 30));
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $products = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->with(['sellerProfile', 'category'])
            ->search($request->q)
            ->select('id', 'name', 'slug', 'price', 'images', 'category_id', 'seller_profile_id', 'condition', 'rating', 'review_count', 'total_sold')
            ->limit(8)
            ->get();

        return response()->json([
            'products' => $products->map(fn ($p) => [
                'id'           => $p->id,
                'name'         => $p->name,
                'slug'         => $p->slug,
                'price'        => $p->formatted_price,
                'image'        => $p->first_image ? asset('storage/' . $p->first_image) : null,
                'store'        => $p->sellerProfile?->store_name,
                'category'     => $p->category?->name,
                'condition'    => $p->condition_label,
                'rating'       => $p->review_count > 0 ? number_format($p->rating, 1) : null,
                'review_count' => $p->review_count,
                'url'          => route('products.show', $p),
            ]),
        ]);
    }

    public function subscribeStock(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        $validated = $request->validate([
            'product_variant_id' => ['nullable', 'exists:product_variants,id'],
        ]);

        $variantId = $validated['product_variant_id'] ?? null;

        $existing = StockSubscription::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existing) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Anda sudah berlangganan notifikasi stok ini.'])
                : back()->with('info', 'Anda sudah berlangganan notifikasi stok ini.');
        }

        StockSubscription::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'product_variant_id' => $variantId,
        ]);

        return $request->expectsJson()
            ? response()->json(['message' => 'Anda akan diberi tahu saat stok tersedia.'])
            : back()->with('status', 'Anda akan diberi tahu saat stok tersedia.');
    }
}
