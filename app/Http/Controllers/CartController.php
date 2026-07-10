<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = $request->user()
            ->cartItems()
            ->with(['product.sellerProfile', 'variant'])
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->status !== 'active') {
            return back()->with('info', 'Produk ini tidak tersedia.');
        }

        $variant = null;
        $availableStock = $product->stock;

        if (! empty($validated['product_variant_id'])) {
            $variant = $product->variants()->where('id', $validated['product_variant_id'])->where('is_active', true)->first();
            if (! $variant) {
                return back()->with('info', 'Variasi produk tidak tersedia.');
            }
            $availableStock = $variant->stock;
        }

        if ($availableStock < $validated['quantity']) {
            return back()->with('info', 'Jumlah melebihi stok yang tersedia (' . $availableStock . ').');
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->where('product_variant_id', $validated['product_variant_id'] ?? null)
            ->first();

        if ($cart) {
            $newQty = $cart->quantity + $validated['quantity'];
            if ($newQty > $availableStock) {
                return back()->with('info', 'Total di keranjang melebihi stok (' . $availableStock . ').');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            $request->user()->cartItems()->create([
                'product_id' => $validated['product_id'],
                'product_variant_id' => $validated['product_variant_id'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->route('cart')->with('status', 'cart-added');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $this->authorize('update', $cart);

        if (! $cart->product) {
            $cart->delete();
            return back()->with('info', 'Produk ini tidak tersedia lagi dan telah dihapus dari keranjang.');
        }

        $cart->load('variant');

        if ($cart->product->status !== 'active') {
            return back()->with('info', 'Produk ini saat ini tidak tersedia.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $availableStock = $cart->variant ? $cart->variant->stock : $cart->product->stock;

        if ($availableStock < $validated['quantity']) {
            return back()->with('info', 'Jumlah melebihi stok (' . $availableStock . ').');
        }

        $cart->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'cart-updated');
    }

    public function destroy(Request $request, Cart $cart): RedirectResponse
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return back()->with('status', 'cart-removed');
    }
}
