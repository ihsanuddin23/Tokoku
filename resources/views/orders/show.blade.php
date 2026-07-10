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

        @if (session('status') === 'order-completed')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pesanan telah selesai. Terima kasih sudah berbelanja!
            </div>
        @endif

        @if (session('status') === 'order-placed-cod')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pesanan berhasil dibuat! Bayar tunai saat kurir tiba di alamat Anda.
            </div>
        @endif

        @if (session('status') === 'order-cancelled')
            <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pesanan telah dibatalkan.
            </div>
        @endif

        <!-- Status Timeline -->
        <div class="card p-6 mb-6">
            @php
                $cancelled = $order->status === 'cancelled';
                $timelineStatuses = [
                    'pending'   => ['label' => 'Pesanan Dibuat',  'time' => $order->created_at,    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    'paid'      => ['label' => 'Pembayaran',      'time' => $order->paid_at,        'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    'shipped'   => ['label' => 'Dikirim',         'time' => $order->shipped_at,     'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                    'completed' => ['label' => 'Selesai',         'time' => $order->completed_at,   'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                $statusOrder = array_keys($timelineStatuses);
                $currentIdx  = array_search($order->status, $statusOrder) ?? 0;
            @endphp

            @if ($cancelled)
                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl">
                    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Pesanan Dibatalkan</p>
                        @if ($order->cancelled_at)
                            <p class="text-xs text-red-400">{{ $order->cancelled_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="relative">
                    @foreach ($timelineStatuses as $key => $step)
                        @php
                            $stepIdx = array_search($key, $statusOrder);
                            $isDone  = $stepIdx <= $currentIdx;
                            $isCurrent = $stepIdx === $currentIdx;
                        @endphp
                        <div class="flex items-start gap-4 {{ !$loop->last ? 'mb-5' : '' }} relative">
                            @if (!$loop->last)
                                <div class="absolute left-[17px] top-9 w-0.5 h-full {{ $isDone && !$isCurrent ? 'bg-primary-400' : 'bg-dark-100' }}"></div>
                            @endif
                            <div class="w-9 h-9 rounded-full shrink-0 flex items-center justify-center z-10
                                {{ $isDone ? 'bg-gradient-to-br from-primary-400 to-primary-600 text-white shadow-glow' : 'bg-dark-100 text-dark-300' }}">
                                @if ($isDone)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isCurrent ? $step['icon'] : 'M5 13l4 4L19 7' }}" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-semibold {{ $isDone ? 'text-dark-900' : 'text-dark-400' }}">{{ $step['label'] }}</p>
                                @if ($isDone && $step['time'])
                                    <p class="text-xs text-dark-400 mt-0.5">{{ \Carbon\Carbon::parse($step['time'])->format('d M Y, H:i') }}</p>
                                @elseif (!$isDone)
                                    <p class="text-xs text-dark-300 mt-0.5">Menunggu...</p>
                                @endif
                                @if ($key === 'shipped' && $isDone && $order->tracking_number)
                                    <div class="mt-2 inline-flex items-center gap-2 bg-indigo-50 border border-indigo-200 rounded-lg px-3 py-1.5">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        <span class="text-xs text-indigo-700 font-medium">No. Resi: <span class="font-bold">{{ $order->tracking_number }}</span></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Shipping Address -->
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold font-display text-dark-900">Alamat Pengiriman</h2>
                @if ($order->shipping_courier)
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-dark-100 text-dark-700 px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l-3-3m3 3l3-3" /></svg>
                        {{ strtoupper($order->shipping_courier) }} {{ $order->shipping_service }}
                    </span>
                @endif
            </div>
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
                            @if ($item->variant_name)
                                <p class="text-xs text-dark-500 mt-0.5">Variasi: {{ $item->variant_name }}</p>
                            @endif
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
                <div class="flex items-center justify-between text-dark-500">
                    <span>Pembayaran</span>
                    @if ($order->payment_method === 'cod')
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">💵 COD</span>
                    @elseif ($order->payment_method === 'midtrans')
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">💳 Online</span>
                    @else
                        <span class="text-dark-700">{{ strtoupper($order->payment_method ?? '-') }}</span>
                    @endif
                </div>
                <div class="border-t border-dark-100 pt-3 flex items-center justify-between">
                    <span class="font-semibold text-dark-900">Total</span>
                    <span class="font-bold text-primary-600 font-display text-lg">{{ $order->formatted_grand_total }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <a href="{{ route('orders.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <div class="flex items-center gap-3">
                @if ($order->canBePaid() && $order->payment_method !== 'cod')
                    <a href="{{ route('payment.show', $order) }}"
                        class="btn bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white shadow-glow hover:shadow-glow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Bayar Sekarang
                    </a>
                @endif
                @if ($order->status === 'pending' && $order->payment_method === 'cod')
                    <span class="inline-flex items-center gap-2 text-sm font-medium text-green-700 bg-green-50 border border-green-200 px-4 py-2.5 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Bayar saat paket tiba (COD)
                    </span>
                @endif
                @if ($order->status === 'shipped')
                    <form method="POST" action="{{ route('orders.complete', $order) }}" onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Pesanan Diterima
                        </button>
                    </form>
                @endif
                @if ($order->canBeCancelled())
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini? Stok produk akan dikembalikan.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
                @if (in_array($order->status, ['completed', 'shipped']))
                    <a href="{{ route('returns.create', $order) }}" class="btn bg-yellow-50 text-yellow-700 hover:bg-yellow-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1m12 0a2 2 0 01-2 2H6a2 2 0 01-2-2m12 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v6m12 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 15H4" /></svg>
                        Ajukan Pengembalian
                    </a>
                @endif
                @if (in_array($order->status, ['completed', 'shipped', 'cancelled']))
                    <form method="POST" action="{{ route('orders.reorder', $order) }}">
                        @csrf
                        <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            Beli Lagi
                        </button>
                    </form>
                @endif
                <a href="{{ route('orders.invoice', $order) }}" class="btn bg-dark-50 text-dark-700 hover:bg-dark-100 transition-colors" target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    Invoice PDF
                </a>
            </div>
        </div>

        @if ($order->status === 'completed')
            @php
                $reviewedProductIds = \App\Models\ProductReview::where('user_id', auth()->id())
                    ->where('order_id', $order->id)
                    ->pluck('product_id')->toArray();
                $unreviewedItems = $order->items->filter(fn($i) => !in_array($i->product_id, $reviewedProductIds));
            @endphp
            @if ($unreviewedItems->isNotEmpty())
                <div class="card p-6 mt-6">
                    <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Beri Ulasan Produk</h2>
                    @if (session('status') === 'review-submitted')
                        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-4">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Ulasan berhasil dikirim. Terima kasih!
                        </div>
                    @endif
                    <form method="POST" action="{{ route('reviews.store', $order) }}" class="space-y-5">
                        @csrf
                        @foreach ($unreviewedItems as $index => $item)
                            <div class="border border-dark-100 rounded-2xl p-4 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($item->product && $item->product->first_image)
                                        <img src="{{ asset('storage/' . $item->product->first_image) }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                                    @endif
                                    <p class="text-sm font-semibold text-dark-900">{{ $item->product_name }}</p>
                                </div>
                                <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <div x-data="{ rating: 5 }">
                                    <p class="text-xs font-medium text-dark-600 mb-1.5">Rating</p>
                                    <div class="flex gap-1 text-2xl">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <button type="button" @click="rating = {{ $s }}; $refs.ratingInput{{ $index }}.value = {{ $s }}"
                                                :class="rating >= {{ $s }} ? 'text-amber-400' : 'text-dark-200'"
                                                class="transition-colors cursor-pointer hover:text-amber-400">★</button>
                                        @endfor
                                    </div>
                                    <input type="hidden" x-ref="ratingInput{{ $index }}" name="reviews[{{ $index }}][rating]" value="5">
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-dark-600 mb-1.5">Komentar (opsional)</p>
                                    <textarea name="reviews[{{ $index }}][comment]" rows="2" class="input-modern resize-none text-sm" placeholder="Bagaimana pengalaman Anda dengan produk ini?"></textarea>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn-primary w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
