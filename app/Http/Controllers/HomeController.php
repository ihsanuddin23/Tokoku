<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Banner::where('is_active', true)->orderBy('order')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->take(6)->get();
        $products = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->with(['sellerProfile', 'category'])
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();
        $newProducts = Product::active()
            ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
            ->with(['sellerProfile', 'category'])
            ->latest()
            ->take(10)
            ->get();
        $popularStores = SellerProfile::where('is_active', true)
            ->where('is_verified', true)
            ->whereHas('products', fn ($q) => $q->where('status', 'active'))
            ->withCount(['products as active_products' => fn ($q) => $q->where('status', 'active')])
            ->orderByDesc('active_products')
            ->take(6)
            ->get();

        return view('welcome', compact('banners', 'categories', 'products', 'newProducts', 'popularStores'));
    }
}
