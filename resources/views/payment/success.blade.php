<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-dark-500">Pesanan Anda telah dikonfirmasi dan sedang diproses oleh seller.</p>
        </div>

        <!-- Order Info Card -->
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between mb-5 pb-4 border-b border-dark-100">
                <div>
                    <p class="text-xs text-dark-400 mb-1">Nomor Pesanan</p>
                    <p class="text-sm font-bold text-dark-900 font-mono">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-dark-400 mb-1">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                        Dibayar
                    </span>
                </div>
            </div>

            <div class="space-y-3 mb-5">
                @foreach ($order->items as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-dark-100 overflow-hidden shrink-0">
                            @if ($item->product && $item->product->first_image)
                                <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-800 truncate">{{ $item->product_name }}</p>
                            <p class="text-xs text-dark-400">{{ $item->quantity }}x · Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-semibold text-dark-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-dark-100 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-dark-500">Subtotal produk</span>
                    <span class="text-dark-700">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-dark-500">Ongkos kirim</span>
                    <span class="text-dark-700">{{ $order->formatted_shipping_cost }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold border-t border-dark-100 pt-2">
                    <span class="text-dark-900">Total Dibayar</span>
                    <span class="text-green-600 text-base">{{ $order->formatted_grand_total }}</span>
                </div>
            </div>

            @if ($order->payment)
                <div class="mt-4 pt-4 border-t border-dark-100 flex items-center justify-between text-xs text-dark-400">
                    <span>Metode: <span class="font-medium text-dark-600">{{ strtoupper($order->payment->payment_type ?? '-') }}</span></span>
                    <span>{{ $order->payment->paid_at?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}</span>
                </div>
            @endif
        </div>

        <!-- Delivery Info -->
        @if ($order->address)
            <div class="card p-5 mb-6">
                <h3 class="text-sm font-semibold text-dark-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Dikirim ke
                </h3>
                <p class="text-sm font-medium text-dark-900">{{ $order->address->recipient_name }}</p>
                <p class="text-sm text-dark-500">{{ $order->address->phone }}</p>
                <p class="text-sm text-dark-500 mt-1">{{ $order->address->full_address }}, {{ $order->address->district }}, {{ $order->address->city }}, {{ $order->address->province }} {{ $order->address->postal_code }}</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('orders.show', $order) }}"
                class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-3 rounded-xl text-sm text-center shadow-glow hover:shadow-glow-lg transition-all duration-300 active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                Lacak Pesanan
            </a>
            <a href="{{ route('products.index') }}"
                class="flex-1 btn-outline py-3 rounded-xl text-sm text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Belanja Lagi
            </a>
        </div>
    </div>
</x-app-layout>
