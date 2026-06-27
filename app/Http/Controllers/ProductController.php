<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

    public function show(Product $product): View
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        if (! $product->sellerProfile || ! $product->sellerProfile->is_active) {
            abort(404);
        }

        $product->load(['sellerProfile', 'category']);

        $related = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
