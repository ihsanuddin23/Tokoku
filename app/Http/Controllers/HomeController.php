<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Cache::remember('home:banners', now()->addHours(1), function () {
            return Banner::where('is_active', true)->orderBy('order')->get();
        });

        $categories = Cache::remember('home:categories', now()->addHours(6), function () {
            return Category::where('is_active', true)->orderBy('name')->take(6)->get();
        });

        $products = Cache::remember('home:popular', now()->addHours(2), function () {
            return Product::active()
                ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
                ->with(['sellerProfile', 'category'])
                ->orderBy('total_sold', 'desc')
                ->take(10)
                ->get();
        });

        $newProducts = Cache::remember('home:new', now()->addHours(1), function () {
            return Product::active()
                ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
                ->with(['sellerProfile', 'category'])
                ->latest()
                ->take(10)
                ->get();
        });

        $popularStores = Cache::remember('home:stores', now()->addHours(3), function () {
            return SellerProfile::where('is_active', true)
                ->where('is_verified', true)
                ->whereHas('products', fn ($q) => $q->where('status', 'active'))
                ->withCount(['products as active_products' => fn ($q) => $q->where('status', 'active')])
                ->orderByDesc('active_products')
                ->take(6)
                ->get();
        });

        return view('welcome', compact('banners', 'categories', 'products', 'newProducts', 'popularStores'));
    }
}
