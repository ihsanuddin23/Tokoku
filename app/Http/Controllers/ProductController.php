<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

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

        if (! $product->sellerProfile || ! $product->sellerProfile->is_active) {
            abort(404);
        }

        // Track recently viewed products via cookie
        $viewed = json_decode($request->cookie('recently_viewed', '[]'), true);
        $viewed = array_filter($viewed, fn ($id) => $id !== $product->id);
        array_unshift($viewed, $product->id);
        $viewed = array_slice($viewed, 0, 10);

        $product->load(['sellerProfile', 'category']);

        $reviews = $product->reviews()->with('user')->latest()->paginate(5);

        $isWishlisted = auth()->check()
            ? $product->wishlists()->where('user_id', auth()->id())->exists()
            : false;

        $related = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('total_sold')
            ->take(8)
            ->get();

        $wishlistedIds = auth()->check()
            ? \App\Models\Wishlist::where('user_id', auth()->id())
                ->whereIn('product_id', $related->pluck('id'))
                ->pluck('product_id')
                ->toArray()
            : [];

        // Recently viewed products (exclude current)
        $recentlyViewed = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->whereIn('id', array_slice($viewed, 1))
            ->take(5)
            ->get();

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
}
