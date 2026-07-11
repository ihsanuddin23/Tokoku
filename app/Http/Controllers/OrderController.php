<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyVoucherRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderStatusUpdated;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Notifications\OrderStatusNotification;
use App\Exceptions\InsufficientStockException;
use App\Services\ShippingService;
use App\Services\StockReservationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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
            ->when($request->search, fn ($q) => $q->where('order_number', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->from_date, fn ($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->to_date, fn ($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $cartItems = $request->user()
            ->cartItems()
            ->with(['product.sellerProfile', 'variant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return view('orders.empty');
        }

        $reservationService = app(StockReservationService::class);

        try {
            $result = $reservationService->reserveForCheckout($request->user()->id, $cartItems);
            $reservationExpiresAt = $result['expires_at'];
        } catch (InsufficientStockException $e) {
            return redirect()->route('cart')->with('info', $e->getMessage());
        }

        $addresses = $request->user()->addresses()->latest()->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        return view('orders.create', compact('cartItems', 'addresses', 'subtotal', 'reservationExpiresAt'));
    }

    public function cancelCheckout(Request $request): RedirectResponse
    {
        app(StockReservationService::class)->releaseForUser($request->user()->id);

        return redirect()->route('cart')->with('info', 'Checkout dibatalkan. Stok produk telah dikembalikan.');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $shippingService = app(ShippingService::class);
        $courierCosts = $shippingService->getCosts();
        $courierServices = $shippingService->getServices();

        $validated = $request->validated();

        $user = $request->user();
        $address = Address::where('id', $validated['address_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $cartItems = $user->cartItems()->with(['product', 'variant'])->get();

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

        $shippingCost    = $courierCosts[$validated['shipping_courier']];
        $shippingService = $courierServices[$validated['shipping_courier']];

        $shippingAddress = "{$address->recipient_name}, {$address->phone}\n{$address->full_address}\n{$address->district}, {$address->city}, {$address->province} {$address->postal_code}";

        $reservationService = app(StockReservationService::class);

        // Check if user has active reservations (from checkout page)
        $hasReservations = \App\Models\StockReservation::where('user_id', $user->id)->active()->exists();

        $order = DB::transaction(function () use ($user, $validated, $cartItems, $shippingCost, $shippingService, $shippingAddress, $address, $reservationService, $hasReservations) {
            $productIds = $cartItems->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $variantIds = $cartItems->pluck('product_variant_id')->filter()->values();
            $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');

            $subtotal = 0;
            foreach ($cartItems as $item) {
                $product = $products[$item->product_id];
                $variant = $item->product_variant_id ? ($variants[$item->product_variant_id] ?? null) : null;

                // Only check stock if no reservation (stock already decremented during checkout)
                if (! $hasReservations) {
                    if ($variant) {
                        if ($variant->stock < $item->quantity) {
                            throw ValidationException::withMessages([
                                'stock' => "Stok variasi {$variant->name} dari {$product->name} tidak mencukupi (tersisa {$variant->stock}).",
                            ]);
                        }
                    } else {
                        if ($product->stock < $item->quantity) {
                            throw ValidationException::withMessages([
                                'stock' => "Stok {$product->name} tidak mencukupi (tersisa {$product->stock}).",
                            ]);
                        }
                    }
                }

                $unitPrice = $variant ? $variant->effective_price : $product->price;
                $subtotal += $unitPrice * $item->quantity;
            }

            $grandTotal = $subtotal + $shippingCost;

            // Apply voucher if session has one
            $appliedVoucher = session('applied_voucher');
            $discountAmount = 0;
            $voucherModel = null;

            if ($appliedVoucher) {
                $voucherModel = Voucher::where('id', $appliedVoucher['id'])
                    ->lockForUpdate()
                    ->first();

                if ($voucherModel && $voucherModel->isValid((float) $subtotal)) {
                    $effectiveSubtotal = $subtotal;

                    if ($voucherModel->isSellerVoucher()) {
                        $effectiveSubtotal = $cartItems->filter(
                            fn ($item) => $item->product && $item->product->seller_profile_id === $voucherModel->seller_profile_id
                        )->sum(function ($item) use ($products, $variants) {
                            $variant = $item->product_variant_id ? ($variants[$item->product_variant_id] ?? null) : null;
                            $unitPrice = $variant ? $variant->effective_price : $products[$item->product_id]->price;
                            return $unitPrice * $item->quantity;
                        });
                    }

                    $discountAmount = $voucherModel->calculateDiscount((float) $effectiveSubtotal, (float) $shippingCost);
                    $grandTotal -= $discountAmount;

                    if ($voucherModel->type === 'free_shipping') {
                        $grandTotal += $shippingCost; // already subtracted via discount
                    }
                }
            }

            $order = $user->orders()->create([
                'address_id' => $address->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->forceFill([
                'order_number'    => 'ORD-' . str_pad((string) $order->id, 8, '0', STR_PAD_LEFT),
                'status'          => 'pending',
                'subtotal'        => $subtotal,
                'shipping_cost'   => $shippingCost,
                'discount_amount' => $discountAmount,
                'grand_total'     => $grandTotal,
                'payment_method'  => $validated['payment_method'],
                'payment_status'  => 'unpaid',
                'shipping_address'  => $shippingAddress,
                'shipping_courier'  => $validated['shipping_courier'],
                'shipping_service'  => $shippingService,
            ])->save();

            foreach ($cartItems as $item) {
                $product = $products[$item->product_id];
                $variant = $item->product_variant_id ? ($variants[$item->product_variant_id] ?? null) : null;

                $unitPrice = $variant ? $variant->effective_price : $product->price;
                $variantName = $variant ? $variant->name : null;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'seller_profile_id' => $product->seller_profile_id,
                    'product_name' => $product->name,
                    'variant_name' => $variantName,
                    'product_price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'subtotal' => $unitPrice * $item->quantity,
                    'status' => 'pending',
                ]);

                // Decrement stock only if no reservation (already decremented during checkout)
                if (! $hasReservations) {
                    if ($variant) {
                        $variant->decrement('stock', $item->quantity);
                    } else {
                        $product->decrement('stock', $item->quantity);
                    }
                }
                $product->increment('total_sold', $item->quantity);
            }

            // Consume reservations if they exist (stock already decremented)
            if ($hasReservations) {
                $reservationService->consumeForUser($user->id);
            }

            Cart::where('user_id', $user->id)->delete();

            if ($voucherModel && $discountAmount > 0) {
                VoucherUsage::create([
                    'voucher_id'      => $voucherModel->id,
                    'user_id'         => $user->id,
                    'order_id'        => $order->id,
                    'discount_amount' => $discountAmount,
                ]);
                $voucherModel->increment('used_count');
            }

            session()->forget('applied_voucher');

            return $order;
        });

        $order->load('items.product.sellerProfile.user', 'user');

        event(new \App\Events\OrderPlaced($order));

        if ($order->payment_method === 'cod') {
            return redirect()->route('orders.show', $order)
                ->with('status', 'order-placed-cod');
        }

        return redirect()->route('payment.show', $order);
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items.product.sellerProfile', 'items.variant', 'address');

        return view('orders.show', compact('order'));
    }

    public function complete(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('complete', $order);

        if ($order->status !== 'shipped') {
            return back()->with('info', 'Pesanan hanya dapat diselesaikan setelah status "Dikirim".');
        }

        $oldStatus = $order->status;

        DB::transaction(function () use ($order) {
            $order->items()->where('status', 'shipped')->update(['status' => 'completed']);

            $order->forceFill([
                'status' => 'completed',
                'completed_at' => now(),
            ])->save();
        });

        $this->notifySellers($order, $oldStatus, 'completed');

        return redirect()->route('orders.show', $order)->with('status', 'order-completed');
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('cancel', $order);

        if (! in_array($order->status, ['pending', 'paid'])) {
            return back()->with('info', 'Pesanan tidak dapat dibatalkan pada status ini.');
        }

        $oldStatus = $order->status;

        DB::transaction(function () use ($order) {
            $order->load('items.product', 'items.variant');
            $productIds = $order->items->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $variantIds = $order->items->pluck('product_variant_id')->filter()->values();
            $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->lockForUpdate()->get()->keyBy('id');

            foreach ($order->items as $item) {
                if ($item->status !== 'cancelled' && $item->product) {
                    $product = $products[$item->product_id] ?? $item->product;
                    if ($item->product_variant_id && isset($variants[$item->product_variant_id])) {
                        $variants[$item->product_variant_id]->increment('stock', $item->quantity);
                    } else {
                        $product->increment('stock', $item->quantity);
                    }
                    $product->decrement('total_sold', $item->quantity);
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

        $this->notifySellers($order, $oldStatus, 'cancelled');

        return redirect()->route('orders.show', $order)->with('status', 'order-cancelled');
    }

    public function reorder(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('reorder', $order);

        $user = $request->user();
        $added = 0;

        $order->load('items.product', 'items.variant');

        foreach ($order->items as $item) {
            if (! $item->product || $item->product->status !== 'active') {
                continue;
            }

            $availableStock = $item->variant ? $item->variant->stock : $item->product->stock;
            if ($availableStock < 1) {
                continue;
            }

            $existing = $user->cartItems()
                ->where('product_id', $item->product_id)
                ->where('product_variant_id', $item->product_variant_id)
                ->first();

            if ($existing) {
                $newQty = min($existing->quantity + $item->quantity, $availableStock);
                $existing->update(['quantity' => $newQty]);
            } else {
                $user->cartItems()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => min($item->quantity, $availableStock),
                ]);
            }
            $added++;
        }

        if ($added === 0) {
            return back()->with('info', 'Tidak ada produk yang tersedia untuk dipesan ulang.');
        }

        return redirect()->route('cart')
            ->with('status', 'Produk berhasil ditambahkan ke keranjang. Silakan periksa sebelum checkout.');
    }

    private function notifySellers(Order $order, string $oldStatus, string $newStatus): void
    {
        $order->load('items.sellerProfile.user');

        $notifiedSellers = [];
        foreach ($order->items as $item) {
            if ($item->sellerProfile && $item->sellerProfile->user && ! in_array($item->sellerProfile->user->id, $notifiedSellers)) {
                $notifiedSellers[] = $item->sellerProfile->user->id;
                Mail::to($item->sellerProfile->user->email)
                    ->queue(new OrderStatusUpdated($order, $oldStatus, $newStatus));
                $item->sellerProfile->user->notify(
                    new OrderStatusNotification($order, $oldStatus, $newStatus, route('seller.orders.show', $order->id))
                );
            }
        }
    }

    public function applyVoucher(ApplyVoucherRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $request->user();
        $cartItems = $user->cartItems()->with(['product', 'variant'])->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong.'], 422);
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        $voucher = Voucher::where('code', strtoupper($validated['code']))->first();

        if (! $voucher) {
            return response()->json(['message' => 'Kode voucher tidak ditemukan.'], 422);
        }

        $effectiveSubtotal = $subtotal;

        if ($voucher->isSellerVoucher()) {
            $sellerSubtotal = $cartItems->filter(
                fn ($item) => $item->product && $item->product->seller_profile_id === $voucher->seller_profile_id
            )->sum(fn ($item) => $item->subtotal);

            if ($sellerSubtotal <= 0) {
                return response()->json(['message' => 'Voucher ini hanya berlaku untuk produk dari toko tertentu.'], 422);
            }

            $effectiveSubtotal = $sellerSubtotal;
        }

        if (! $voucher->isValid((float) $effectiveSubtotal)) {
            $reason = match (true) {
                ! $voucher->is_active => 'Voucher tidak aktif.',
                now()->lt($voucher->starts_at) => 'Voucher belum berlaku.',
                now()->gt($voucher->expires_at) => 'Voucher sudah kedaluwarsa.',
                $voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit => 'Kuota voucher sudah habis.',
                $effectiveSubtotal < (float) $voucher->min_purchase => 'Minimal pembelian Rp ' . number_format((float) $voucher->min_purchase, 0, ',', '.'),
                default => 'Voucher tidak dapat digunakan.',
            };
            return response()->json(['message' => $reason], 422);
        }

        $userUsageCount = VoucherUsage::where('voucher_id', $voucher->id)
            ->where('user_id', $user->id)
            ->count();

        if ($userUsageCount >= $voucher->usage_limit_per_user) {
            return response()->json(['message' => 'Anda sudah menggunakan voucher ini sebanyak maksimum yang diperbolehkan.'], 422);
        }

        $shippingService = app(ShippingService::class);
        $courierCosts = $shippingService->getCosts();
        $shippingCost = $courierCosts[$request->input('shipping_courier', 'jne')] ?? 15000;

        $discount = $voucher->calculateDiscount((float) $effectiveSubtotal, (float) $shippingCost);

        session()->put('applied_voucher', [
            'id'       => $voucher->id,
            'code'     => $voucher->code,
            'discount' => $discount,
        ]);

        return response()->json([
            'message'   => 'Voucher berhasil diterapkan!',
            'discount'  => $discount,
            'formatted' => 'Rp ' . number_format($discount, 0, ',', '.'),
        ]);
    }

    public function removeVoucher(Request $request): RedirectResponse
    {
        session()->forget('applied_voucher');

        return back()->with('info', 'Voucher dibatalkan.');
    }

    public function invoice(Request $request, Order $order)
    {
        $this->authorize('invoice', $order);

        $order->load('items.product.sellerProfile', 'user', 'address');

        $pdf = Pdf::loadView('invoices.order', compact('order'));

        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function trackForm(): View
    {
        return view('orders.track');
    }

    public function trackOrder(Request $request): View
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:50'],
            'email'         => ['required', 'email'],
        ]);

        $order = Order::where('order_number', $validated['order_number'])
            ->whereHas('user', fn ($q) => $q->where('email', $validated['email']))
            ->with('items.product.sellerProfile', 'items.product.category')
            ->first();

        return view('orders.track', compact('order'));
    }
}
