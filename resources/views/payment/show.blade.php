<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('orders.index') }}" class="hover:text-primary-600 transition-colors">Pesanan</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Pembayaran</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Pembayaran</h1>
            <p class="text-sm text-dark-500">Selesaikan pembayaran untuk pesanan <span class="font-semibold text-dark-700">{{ $order->order_number }}</span></p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- Payment Action -->
            <div class="lg:col-span-3 space-y-5">
                <!-- Status -->
                <div class="card p-6">
                    <h2 class="text-sm font-semibold font-display text-dark-900 mb-4 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-primary-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        </div>
                        Pilih Metode Pembayaran
                    </h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 p-3 bg-dark-50 rounded-xl">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-dark-600">Transfer Bank (BCA, Mandiri, BNI, BRI)</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-dark-50 rounded-xl">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-dark-600">QRIS (semua aplikasi e-wallet)</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-dark-50 rounded-xl">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-dark-600">GoPay, OVO, Dana, ShopeePay</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-dark-50 rounded-xl">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-dark-600">Kartu Kredit / Debit Visa, Mastercard</span>
                        </div>
                    </div>

                    <div class="border-t border-dark-100 pt-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-dark-600">Total Pembayaran:</span>
                            <span class="text-xl font-bold text-dark-900">{{ $order->formatted_grand_total }}</span>
                        </div>

                        @if (config('midtrans.client_key'))
                            <button id="pay-button" onclick="payNow()"
                                class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-3.5 rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                Bayar Sekarang
                            </button>
                        @else
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                                <p class="font-semibold mb-1">Konfigurasi Midtrans Diperlukan</p>
                                <p>Tambahkan <code class="bg-amber-100 px-1 rounded">MIDTRANS_CLIENT_KEY</code> dan <code class="bg-amber-100 px-1 rounded">MIDTRANS_SERVER_KEY</code> di file <code class="bg-amber-100 px-1 rounded">.env</code> untuk mengaktifkan pembayaran.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Security badge -->
                <div class="flex items-center justify-center gap-3 text-xs text-dark-400">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    <span>Pembayaran aman diproses oleh <strong>Midtrans</strong></span>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="card p-5 sticky top-24">
                    <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-dark-100 overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->first_image)
                                        <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-dark-800 truncate">{{ $item->product_name }}</p>
                                    <p class="text-xs text-dark-400">x{{ $item->quantity }}</p>
                                </div>
                                <span class="text-xs font-semibold text-dark-700 shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dark-100 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-dark-500">Subtotal</span>
                            <span class="text-dark-700">{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-dark-500">Ongkir</span>
                            <span class="text-dark-700">{{ $order->formatted_shipping_cost }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold border-t border-dark-100 pt-2 mt-2">
                            <span class="text-dark-900">Total</span>
                            <span class="text-primary-600">{{ $order->formatted_grand_total }}</span>
                        </div>
                    </div>

                    <a href="{{ route('orders.show', $order) }}" class="mt-4 block text-center text-sm text-dark-400 hover:text-dark-600 transition-colors">
                        Lihat detail pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (config('midtrans.client_key'))
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            function payNow() {
                const btn = document.getElementById('pay-button');
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat...';

                snap.pay('{{ $payment->snap_token }}', {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('payment.finish', $order) }}?transaction_status=' + result.transaction_status;
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route('payment.finish', $order) }}?transaction_status=pending';
                    },
                    onError: function(result) {
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg> Bayar Sekarang';
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg> Bayar Sekarang';
                    }
                });
            }
        </script>
    @endif
</x-app-layout>
