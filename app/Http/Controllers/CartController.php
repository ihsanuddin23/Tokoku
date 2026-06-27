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
            ->with('product.sellerProfile')
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->status !== 'active') {
            return back()->with('info', 'Produk ini tidak tersedia.');
        }

        if ($product->stock < $validated['quantity']) {
            return back()->with('info', 'Jumlah melebihi stok yang tersedia (' . $product->stock . ').');
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cart) {
            $newQty = $cart->quantity + $validated['quantity'];
            if ($newQty > $product->stock) {
                return back()->with('info', 'Total di keranjang melebihi stok (' . $product->stock . ').');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->route('cart')->with('status', 'cart-added');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            abort(403);
        }

        if (! $cart->product) {
            $cart->delete();
            return back()->with('info', 'Produk ini tidak tersedia lagi dan telah dihapus dari keranjang.');
        }

        if ($cart->product->status !== 'active') {
            return back()->with('info', 'Produk ini saat ini tidak tersedia.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($cart->product->stock < $validated['quantity']) {
            return back()->with('info', 'Jumlah melebihi stok (' . $cart->product->stock . ').');
        }

        $cart->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'cart-updated');
    }

    public function destroy(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            abort(403);
        }

        $cart->delete();

        return back()->with('status', 'cart-removed');
    }
}
