<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;

        $products = $sellerProfile->products()
            ->with('category')
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->sort, function ($q, $sort) {
                match ($sort) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'stock_asc' => $q->orderBy('stock', 'asc'),
                    'stock_desc' => $q->orderBy('stock', 'desc'),
                    'oldest' => $q->oldest(),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest())
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('seller.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'weight' => ['nullable', 'integer', 'min:0'],
            'condition' => ['required', 'in:new,used'],
            'status' => ['required', 'in:active,inactive,draft'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }
        $validated['images'] = $images;

        $request->user()->sellerProfile->products()->create($validated);

        return redirect()->route('seller.products.index')
            ->with('status', 'product-created');
    }

    public function edit(Request $request, Product $product): View
    {
        if ($product->seller_profile_id !== $request->user()->sellerProfile->id) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        if ($product->seller_profile_id !== $request->user()->sellerProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'weight' => ['nullable', 'integer', 'min:0'],
            'condition' => ['required', 'in:new,used'],
            'status' => ['required', 'in:active,inactive,draft'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string'],
        ]);

        $currentImages = $product->images ?? [];

        if (! empty($validated['remove_images'])) {
            foreach ($validated['remove_images'] as $removePath) {
                if (($key = array_search($removePath, $currentImages)) !== false) {
                    Storage::disk('public')->delete($removePath);
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages);
        }

        if ($request->hasFile('images')) {
            $newCount = count($request->file('images'));
            if (count($currentImages) + $newCount > 5) {
                return back()->with('info', 'Maksimal 5 gambar per produk. Hapus beberapa gambar lama terlebih dahulu.');
            }
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('products', 'public');
            }
        }

        $validated['images'] = $currentImages;
        unset($validated['remove_images']);

        $product->update($validated);

        return redirect()->route('seller.products.index')
            ->with('status', 'product-updated');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        if ($product->seller_profile_id !== $request->user()->sellerProfile->id) {
            abort(403);
        }

        if ($product->orderItems()->exists()) {
            return back()->with('info', 'Produk tidak dapat dihapus karena sudah ada dalam pesanan. Nonaktifkan produk sebagai gantinya.');
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('status', 'product-deleted');
    }

    public function bulkUpdateStock(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'stocks' => ['required', 'array'],
            'stocks.*' => ['required', 'integer', 'min:0'],
        ]);

        $sellerProfile = $request->user()->sellerProfile;
        $updated = 0;

        foreach ($validated['stocks'] as $productId => $stock) {
            $product = Product::find($productId);

            if ($product && $product->seller_profile_id === $sellerProfile->id) {
                $product->update(['stock' => $stock]);
                $updated++;
            }
        }

        return redirect()->route('seller.products.index')
            ->with('status', 'bulk-stock-updated')
            ->with('bulk_count', $updated);
    }
}
