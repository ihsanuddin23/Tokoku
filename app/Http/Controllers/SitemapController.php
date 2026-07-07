<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $content = view('sitemap.index', [
            'staticPages' => [
                ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['url' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
                ['url' => route('categories.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ],
            'categories' => Category::where('is_active', true)->get(),
            'products'   => Product::active()
                ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
                ->latest()
                ->limit(5000)
                ->get(),
        ])->render();

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        $content = view('sitemap.robots')->render();

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
