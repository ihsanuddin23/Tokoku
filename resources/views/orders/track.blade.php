<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Lacak Pesanan</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Lacak Pesanan</h1>
            <p class="text-sm text-dark-500 mt-1">Cek status pesanan Anda tanpa perlu login.</p>
        </div>

        <!-- Search Form -->
        <div class="card p-6 mb-6">
            <form method="POST" action="{{ route('orders.track.search') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="order_number" class="block text-sm font-medium text-dark-700 mb-1.5">Nomor Pesanan</label>
                    <input type="text" id="order_number" name="order_number" value="{{ old('order_number') }}"
                        class="input-modern @error('order_number') border-red-400 @enderror"
                        placeholder="Contoh: ORD-00000123" required>
                    @error('order_number')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-dark-700 mb-1.5">Email Pemesan</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="input-modern @error('email') border-red-400 @enderror"
                        placeholder="email@contoh.com" required>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn-primary w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Lacak Pesanan
                </button>
            </form>
        </div>

        @isset($order)
            @if ($order)
                <!-- Order Found -->
                <div class="card p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-dark-400">Nomor Pesanan</p>
                            <p class="text-lg font-bold font-display text-dark-900">{{ $order->order_number }}</p>
                        </div>
                        <span class="badge {{ $order->status_badge }} text-xs">{{ $order->status_label }}</span>
                    </div>

                    <!-- Status Timeline -->
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

                <!-- Shipping Info -->
                <div class="card p-6 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold font-display text-dark-900">Info Pengiriman</h2>
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
                </div>

                <!-- Items -->
                <div class="card p-6 mb-6">
                    <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Produk Dipesan</h2>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-dark-50' : '' }}">
                                <div class="w-14 h-14 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->first_image)
                                        <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-dark-900">{{ $item->product_name }}</p>
                                    <p class="text-xs text-dark-400 mt-0.5">{{ $item->formatted_price }} x {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-semibold text-dark-900 shrink-0">{{ $item->formatted_subtotal }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="card p-6">
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
                        @if ($order->discount_amount > 0)
                            <div class="flex items-center justify-between text-green-600">
                                <span>Diskon</span>
                                <span class="font-medium">- Rp {{ number_format((float) $order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="border-t border-dark-100 pt-3 flex items-center justify-between">
                            <span class="font-semibold text-dark-900">Total</span>
                            <span class="font-bold text-primary-600 font-display text-lg">{{ $order->formatted_grand_total }}</span>
                        </div>
                    </div>
                </div>

                @if ($order->status === 'shipped' || $order->status === 'completed')
                    <p class="text-center text-sm text-dark-400 mt-6">
                        @auth
                            <a href="{{ route('orders.show', $order) }}" class="text-primary-600 hover:text-primary-700 font-medium">Lihat detail pesanan lengkap</a>
                        @else
                            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Masuk</a> untuk melihat detail pesanan lengkap &amp; mengelola pesanan.
                        @endauth
                    </p>
                @endif
            @else
                <!-- Order Not Found -->
                <div class="card p-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold font-display text-dark-900 mb-2">Pesanan Tidak Ditemukan</h3>
                    <p class="text-sm text-dark-500 max-w-sm mx-auto">
                        Pastikan nomor pesanan dan email yang Anda masukkan benar. Jika Anda belum memiliki akun, coba gunakan email yang Anda gunakan saat checkout.
                    </p>
                </div>
            @endif
        @endisset
    </div>
</x-app-layout>
