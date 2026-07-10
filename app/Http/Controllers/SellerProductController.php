<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    public function index(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $products = $sellerProfile->products()
            ->with('category', 'variants')
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

        $categories = Category::cachedActive();

        return view('seller.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::cachedActive();

        return view('seller.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $validated = $request->validated();

        $imageService = app(ImageService::class);
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $imageService->uploadProductImage($image);
            }
        }
        $validated['images'] = $images;

        $product = $sellerProfile->products()->create($validated);

        if (! empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                $product->variants()->create([
                    'name' => $variantData['name'],
                    'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                    'stock' => $variantData['stock'],
                    'sku' => $variantData['sku'] ?? null,
                    'is_active' => true,
                ]);
            }
        }

        // Notify followers about new product
        $followers = $sellerProfile->followers()->with('user')->get();
        foreach ($followers as $follower) {
            $follower->user->notify(new \App\Notifications\NewProductFromFollowedStore($product, $sellerProfile));
        }

        return redirect()->route('seller.products.index')
            ->with('status', 'product-created');
    }

    public function edit(Request $request, Product $product): View
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');
        $this->authorize('update', $product);

        $categories = Category::cachedActive();
        $product->load('variants');

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');
        $this->authorize('update', $product);

        $validated = $request->validated();

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
            $imageService = app(ImageService::class);
            foreach ($request->file('images') as $image) {
                $currentImages[] = $imageService->uploadProductImage($image);
            }
        }

        $validated['images'] = $currentImages;
        unset($validated['remove_images']);

        $variantsData = $validated['variants'] ?? [];
        $removedVariantIds = $validated['removed_variant_ids'] ?? [];
        unset($validated['variants'], $validated['removed_variant_ids']);

        $oldStock = $product->stock;
        $product->update($validated);

        if ($product->stock != $oldStock) {
            event(new \App\Events\StockUpdated($product, $oldStock, (int) $product->stock));
        }

        foreach ($variantsData as $variantData) {
            if (! empty($variantData['id'])) {
                $variant = $product->variants()->find($variantData['id']);
                if ($variant) {
                    $oldVariantStock = $variant->stock;
                    $variant->update([
                        'name' => $variantData['name'],
                        'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                        'stock' => $variantData['stock'],
                        'sku' => $variantData['sku'] ?? null,
                        'is_active' => $variantData['is_active'] ?? true,
                    ]);
                    if ($variant->stock != $oldVariantStock) {
                        event(new \App\Events\StockUpdated($product, (int) $oldVariantStock, (int) $variant->stock, $variant));
                    }
                }
            } else {
                $product->variants()->create([
                    'name' => $variantData['name'],
                    'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                    'stock' => $variantData['stock'],
                    'sku' => $variantData['sku'] ?? null,
                    'is_active' => $variantData['is_active'] ?? true,
                ]);
            }
        }

        if (! empty($removedVariantIds)) {
            $product->variants()->whereIn('id', $removedVariantIds)->delete();
        }

        return redirect()->route('seller.products.index')
            ->with('status', 'product-updated');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');
        $this->authorize('delete', $product);

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
            'stocks' => ['nullable', 'array'],
            'stocks.*' => ['required', 'integer', 'min:0'],
            'variant_stocks' => ['nullable', 'array'],
            'variant_stocks.*' => ['required', 'integer', 'min:0'],
        ]);

        $sellerProfile = $request->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');
        $updated = 0;

        if (! empty($validated['stocks'])) {
            $products = Product::whereIn('id', array_keys($validated['stocks']))
                ->where('seller_profile_id', $sellerProfile->id)
                ->get()->keyBy('id');

            foreach ($validated['stocks'] as $productId => $stock) {
                $product = $products->get($productId);

                if ($product) {
                    $product->update(['stock' => $stock]);
                    $updated++;
                }
            }
        }

        if (! empty($validated['variant_stocks'])) {
            $variantIds = array_keys($validated['variant_stocks']);
            $variants = ProductVariant::whereIn('id', $variantIds)
                ->whereHas('product', fn ($q) => $q->where('seller_profile_id', $sellerProfile->id))
                ->get()->keyBy('id');

            foreach ($validated['variant_stocks'] as $variantId => $stock) {
                $variant = $variants->get($variantId);

                if ($variant) {
                    $variant->update(['stock' => $stock]);
                    $updated++;
                }
            }
        }

        return redirect()->route('seller.products.index')
            ->with('status', 'bulk-stock-updated')
            ->with('bulk_count', $updated);
    }
}
