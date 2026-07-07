<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlists = $request->user()
            ->wishlists()
            ->with(['product.sellerProfile', 'product.category'])
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
            $message = 'Produk dihapus dari wishlist';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $wishlisted = true;
            $message = 'Produk ditambahkan ke wishlist';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'wishlisted' => $wishlisted,
                'message' => $message,
                'count' => $user->wishlists()->count(),
            ]);
        }

        return back()->with('status', $message);
    }
}
