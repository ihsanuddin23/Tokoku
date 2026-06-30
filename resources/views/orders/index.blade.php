<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Pesanan Saya</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Pesanan Saya</h1>
            <p class="text-sm text-dark-500">Riwayat pesanan Anda</p>
        </div>

        @if (session('status') === 'order-placed')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pesanan berhasil dibuat! Silakan lakukan pembayaran.
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="card p-16 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-primary-500/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Pesanan</h2>
                    <p class="text-sm text-dark-400 max-w-md mx-auto mb-6">Mulai belanja dan buat pesanan pertama Anda.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary inline-flex">Mulai Belanja</a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="card p-5">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-dark-50">
                            <div>
                                <p class="text-sm font-mono font-medium text-dark-900">{{ $order->order_number }}</p>
                                <p class="text-xs text-dark-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="badge {{ $order->status_badge }} text-[10px]">{{ $order->status_label }}</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            @foreach ($order->items->take(2) as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-dark-50 overflow-hidden shrink-0">
                                        @if ($item->product && $item->product->first_image)
                                            <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <p class="text-sm text-dark-700 flex-1 truncate">{{ $item->product_name }}</p>
                                    <p class="text-xs text-dark-400">{{ $item->quantity }}x</p>
                                    <p class="text-sm font-medium text-dark-900">{{ $item->formatted_subtotal }}</p>
                                </div>
                            @endforeach
                            @if ($order->items->count() > 2)
                                <p class="text-xs text-dark-400 pl-13">+{{ $order->items->count() - 2 }} produk lainnya</p>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-dark-400">Total</p>
                                <p class="text-lg font-bold font-display text-primary-600">{{ $order->formatted_grand_total }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($order->canBePaid())
                                    <a href="{{ route('payment.show', $order) }}"
                                        class="btn text-sm bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white shadow-glow">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        Bayar
                                    </a>
                                @endif
                                <a href="{{ route('orders.show', $order) }}" class="btn-secondary text-sm">
                                    Lihat Detail
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($orders->hasPages())
                <div class="flex justify-center mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
