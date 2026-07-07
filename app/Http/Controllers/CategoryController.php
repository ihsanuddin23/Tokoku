<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('status', 'active')])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->where('category_id', $category->id)
            ->with(['sellerProfile', 'category'])
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->min_price, fn ($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn ($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->condition, fn ($q) => $q->where('condition', $request->condition))
            ->when($request->min_rating, fn ($q) => $q->where('rating', '>=', $request->min_rating))
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

        $relatedCategories = Category::where('is_active', true)
            ->where('id', '!=', $category->id)
            ->withCount(['products' => fn ($q) => $q->where('status', 'active')])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->limit(6)
            ->get();

        return view('categories.show', compact('category', 'products', 'relatedCategories'));
    }
}
