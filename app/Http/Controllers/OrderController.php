<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(Request $request): View
    {
        $cartItems = $request->user()
            ->cartItems()
            ->with('product.sellerProfile')
            ->get();

        if ($cartItems->isEmpty()) {
            return view('orders.empty');
        }

        $addresses = $request->user()->addresses()->latest()->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        return view('orders.create', compact('cartItems', 'addresses', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();
        $address = Address::where('id', $validated['address_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('info', 'Keranjang Anda kosong.');
        }

        foreach ($cartItems as $item) {
            if (! $item->product) {
                return back()->with('info', 'Salah satu produk di keranjang tidak tersedia lagi.');
            }
            if ($item->product->status !== 'active') {
                return back()->with('info', "Produk \"{$item->product->name}\" tidak tersedia untuk dipesan.");
            }
        }

        $shippingCost = 0;

        $shippingAddress = "{$address->recipient_name}, {$address->phone}\n{$address->full_address}\n{$address->district}, {$address->city}, {$address->province} {$address->postal_code}";

        DB::transaction(function () use ($user, $validated, $cartItems, $shippingCost, $shippingAddress, $address) {
            $productIds = $cartItems->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $subtotal = 0;
            foreach ($cartItems as $item) {
                $product = $products[$item->product_id];
                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'stock' => "Stok {$product->name} tidak mencukupi (tersisa {$product->stock}).",
                    ]);
                }
                $subtotal += $product->price * $item->quantity;
            }

            $grandTotal = $subtotal + $shippingCost;

            $order = $user->orders()->create([
                'address_id' => $address->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->forceFill([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'payment_method' => 'manual',
                'payment_status' => 'unpaid',
                'shipping_address' => $shippingAddress,
            ])->save();

            foreach ($cartItems as $item) {
                $product = $products[$item->product_id];

                (new OrderItem)->forceFill([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'seller_profile_id' => $product->seller_profile_id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $product->price * $item->quantity,
                    'status' => 'pending',
                ])->save();

                $product->decrement('stock', $item->quantity);
                $product->increment('total_sold', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('status', 'order-placed');
    }

    public function show(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items.product.sellerProfile', 'address');

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'paid'])) {
            return back()->with('info', 'Pesanan tidak dapat dibatalkan pada status ini.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->status !== 'cancelled' && $item->product) {
                    $item->product->increment('stock', $item->quantity);
                    $item->product->decrement('total_sold', $item->quantity);
                }
            }

            $order->items()->where('status', '!=', 'cancelled')->update(['status' => 'cancelled']);

            $paymentStatus = $order->payment_status === 'paid' ? 'refunded' : 'unpaid';

            $order->forceFill([
                'status' => 'cancelled',
                'payment_status' => $paymentStatus,
                'cancelled_at' => now(),
            ])->save();
        });

        return redirect()->route('orders.show', $order)->with('status', 'order-cancelled');
    }
}
