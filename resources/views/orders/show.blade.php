<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('orders.index') }}" class="hover:text-primary-600 transition-colors">Pesanan</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">{{ $order->order_number }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-display text-dark-900">Detail Pesanan</h1>
                    <p class="text-sm text-dark-500 mt-0.5">{{ $order->order_number }}</p>
                </div>
                <span class="badge {{ $order->status_badge }} text-xs">{{ $order->status_label }}</span>
            </div>
        </div>

        @if (session('status') === 'order-cancelled')
            <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pesanan telah dibatalkan.
            </div>
        @endif

        <!-- Status Timeline -->
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between">
                @php $statuses = ['pending' => 'Dibuat', 'paid' => 'Dibayar', 'shipped' => 'Dikirim', 'completed' => 'Selesai']; @endphp
                @foreach ($statuses as $key => $label)
                    @php $active = collect(array_keys($statuses))->search($order->status) !== false && collect(array_keys($statuses))->search($key) <= collect(array_keys($statuses))->search($order->status); @endphp
                    <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold {{ $active ? 'bg-gradient-to-br from-primary-400 to-primary-600 text-white shadow-glow' : 'bg-dark-100 text-dark-400' }}">
                                @if ($active)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </div>
                            <span class="text-[10px] mt-1.5 {{ $active ? 'text-dark-900 font-medium' : 'text-dark-400' }}">{{ $label }}</span>
                        </div>
                        @if (!$loop->last)
                            <div class="flex-1 h-0.5 mx-2 {{ collect(array_keys($statuses))->search($key) < collect(array_keys($statuses))->search($order->status) ? 'bg-primary-500' : 'bg-dark-200' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card p-6 mb-6">
            <h2 class="text-sm font-semibold font-display text-dark-900 mb-3">Alamat Pengiriman</h2>
            <div class="bg-dark-50 rounded-xl p-4">
                <p class="text-sm text-dark-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
            @if ($order->notes)
                <div class="mt-3">
                    <p class="text-xs text-dark-400 mb-1">Catatan:</p>
                    <p class="text-sm text-dark-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Items -->
        <div class="card p-6 mb-6">
            <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Produk Dipesan</h2>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-dark-50' : '' }}">
                        <div class="w-16 h-16 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                            @if ($item->product && $item->product->first_image)
                                <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-900">{{ $item->product_name }}</p>
                            <p class="text-xs text-dark-400 mt-0.5">{{ $item->formatted_price }} x {{ $item->quantity }}</p>
                            @if ($item->product)
                                <a href="{{ route('products.show', $item->product) }}" class="text-xs text-primary-600 hover:text-primary-700 mt-1 inline-block">Lihat Produk</a>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-dark-900 shrink-0">{{ $item->formatted_subtotal }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="card p-6 mb-6">
            <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Ringkasan Pembayaran</h2>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between text-dark-500">
                    <span>Subtotal</span>
                    <span class="font-medium text-dark-700">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex items-center justify-between text-dark-500">
                    <span>Ongkos Kirim</span>
                    <span class="font-medium text-dark-700">{{ $order->formatted_shipping_cost }}</span>
                </div>
                <div class="border-t border-dark-100 pt-3 flex items-center justify-between">
                    <span class="font-semibold text-dark-900">Total</span>
                    <span class="font-bold text-primary-600 font-display text-lg">{{ $order->formatted_grand_total }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('orders.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            @if (in_array($order->status, ['pending', 'paid']))
                <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini? Stok produk akan dikembalikan.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
