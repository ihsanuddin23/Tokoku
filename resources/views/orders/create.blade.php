<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('cart') }}" class="hover:text-primary-600 transition-colors">Keranjang</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Checkout</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Checkout</h1>
            <p class="text-sm text-dark-500">Konfirmasi pesanan Anda</p>
        </div>

        @if (session('info'))
            <div class="glass border-blue-200/50 text-blue-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('info') }}
            </div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Address -->
                    <div class="card p-6">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Alamat Pengiriman</h2>
                        @if ($addresses->isEmpty())
                            <div class="text-center py-8">
                                <p class="text-sm text-dark-400 mb-4">Anda belum memiliki alamat pengiriman.</p>
                                <a href="{{ route('profile.addresses') }}" class="btn-primary inline-flex text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    Tambah Alamat
                                </a>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach ($addresses as $address)
                                    <label class="block card p-4 cursor-pointer hover:border-primary-400 transition-colors {{ old('address_id') == $address->id ? 'border-primary-400 ring-2 ring-primary-100' : '' }}">
                                        <div class="flex items-start gap-3">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1 w-4 h-4 text-primary-500 focus:ring-primary-400" @selected(old('address_id') == $address->id || $address->is_default) required>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <p class="text-sm font-medium text-dark-900">{{ $address->recipient_name }}</p>
                                                    @if ($address->is_default)
                                                        <span class="badge-primary text-[9px]">Utama</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-dark-500">{{ $address->phone }}</p>
                                                <p class="text-xs text-dark-500 mt-1">{{ $address->full_address }}, {{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <a href="{{ route('profile.addresses') }}" class="inline-flex items-center gap-1 text-xs text-primary-600 hover:text-primary-700 mt-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah alamat baru
                            </a>
                        @endif
                    </div>

                    <!-- Items -->
                    <div class="card p-6">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Produk Dipesan</h2>
                        <div class="space-y-3">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center gap-3 pb-3 {{ !$loop->last ? 'border-b border-dark-50' : '' }}">
                                    <div class="w-14 h-14 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                                        @if ($item->product && $item->product->first_image)
                                            <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-dark-900 truncate">{{ $item->product?->name ?? 'Produk tidak tersedia' }}</p>
                                        @if ($item->variant)
                                            <p class="text-xs text-dark-500">Variasi: {{ $item->variant->name }}</p>
                                        @endif
                                        <p class="text-xs text-dark-400">{{ $item->variant ? $item->variant->formatted_effective_price : ($item->product?->formatted_price ?? '-') }} x {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-dark-900 shrink-0">{{ $item->formatted_subtotal }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Courier -->
                    <div class="card p-6" x-data="{ courier: '{{ old('shipping_courier', 'jne') }}' }">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Pilih Jasa Pengiriman</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @php
                            $shippingService = app(\App\Services\ShippingService::class);
                            $couriers = $shippingService->getCouriers();
                            $courierCosts = $shippingService->getCosts();
                            @endphp
                            @foreach ($couriers as $c)
                                <label class="block cursor-pointer" @click="courier = '{{ $c['id'] }}'">
                                    <input type="radio" name="shipping_courier" value="{{ $c['id'] }}" class="sr-only" @checked(old('shipping_courier', 'jne') === $c['id'])>
                                    <div :class="courier === '{{ $c['id'] }}' ? 'border-primary-500 ring-2 ring-primary-100 bg-primary-50' : 'border-dark-200 hover:border-primary-300'" class="border rounded-2xl p-3 transition-all">
                                        <p class="text-sm font-bold text-dark-900">{{ $c['name'] }}</p>
                                        <p class="text-[10px] text-dark-500 mt-0.5">{{ $c['service'] }} · {{ $c['eta'] }}</p>
                                        <p class="text-xs font-semibold text-primary-600 mt-1">Rp {{ number_format($courierCosts[$c['id']] ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('shipping_courier')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="card p-6" x-data="{ payMethod: '{{ old('payment_method', 'midtrans') }}' }">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-4">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label class="block cursor-pointer" @click="payMethod = 'midtrans'">
                                <input type="radio" name="payment_method" value="midtrans" class="sr-only" @checked(old('payment_method', 'midtrans') === 'midtrans')>
                                <div :class="payMethod === 'midtrans' ? 'border-primary-500 ring-2 ring-primary-100 bg-primary-50' : 'border-dark-200 hover:border-primary-300'" class="border rounded-2xl p-4 flex items-center gap-3 transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-dark-900">Transfer / QRIS / Kartu Kredit</p>
                                        <p class="text-xs text-dark-500">Bayar online via Midtrans (VA, QRIS, e-wallet, kartu kredit)</p>
                                    </div>
                                </div>
                            </label>
                            <label class="block cursor-pointer" @click="payMethod = 'cod'">
                                <input type="radio" name="payment_method" value="cod" class="sr-only" @checked(old('payment_method') === 'cod')>
                                <div :class="payMethod === 'cod' ? 'border-primary-500 ring-2 ring-primary-100 bg-primary-50' : 'border-dark-200 hover:border-primary-300'" class="border rounded-2xl p-4 flex items-center gap-3 transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-dark-900">COD (Bayar di Tempat)</p>
                                        <p class="text-xs text-dark-500">Bayar tunai saat paket tiba. Siapkan uang pas.</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="card p-6">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-3">Catatan (Opsional)</h2>
                        <textarea name="notes" rows="3" class="input-modern resize-none" placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Voucher -->
                    <div class="card p-6" x-data="{
                        voucherCode: '',
                        discount: 0,
                        applied: {{ session('applied_voucher') ? 'true' : 'false' }},
                        appliedCode: '{{ session('applied_voucher')['code'] ?? '' }}',
                        loading: false,
                        error: '',
                        success: '',
                        applyVoucher() {
                            this.loading = true;
                            this.error = '';
                            this.success = '';
                            fetch('{{ route('voucher.apply') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                                body: JSON.stringify({ code: this.voucherCode, shipping_courier: document.querySelector('input[name=shipping_courier]:checked')?.value || 'jne' })
                            }).then(r => r.json()).then(data => {
                                this.loading = false;
                                if (data.message && data.discount === undefined) {
                                    this.error = data.message;
                                } else {
                                    this.discount = data.discount;
                                    this.applied = true;
                                    this.appliedCode = this.voucherCode.toUpperCase();
                                    this.success = data.message;
                                    this.updateSummary();
                                }
                            }).catch(() => { this.loading = false; this.error = 'Terjadi kesalahan.'; });
                        },
                        removeVoucher() {
                            fetch('{{ route('voucher.remove') }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
                            this.applied = false;
                            this.discount = 0;
                            this.voucherCode = '';
                            this.success = '';
                            this.updateSummary();
                        },
                        updateSummary() {
                            document.dispatchEvent(new CustomEvent('voucher-updated', { detail: this.discount, bubbles: true }));
                        }
                    }">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-3">Voucher Diskon</h2>
                        <template x-if="!applied">
                            <div class="flex gap-2">
                                <input type="text" x-model="voucherCode" @keyup.enter="applyVoucher()" placeholder="Masukkan kode voucher" class="flex-1 rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all uppercase">
                                <button type="button" @click="applyVoucher()" :disabled="loading || !voucherCode" class="btn-secondary text-sm whitespace-nowrap">
                                    <span x-show="!loading">Pakai</span>
                                    <span x-show="loading">...</span>
                                </button>
                            </div>
                        </template>
                        <template x-if="applied">
                            <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-green-700" x-text="appliedCode"></p>
                                    <p class="text-xs text-green-600" x-text="'Hemat Rp ' + discount.toLocaleString('id-ID')"></p>
                                </div>
                                <button type="button" @click="removeVoucher()" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </div>
                        </template>
                        <p x-show="error" x-text="error" class="text-xs text-red-500 mt-2"></p>
                        <p x-show="success" x-text="success" class="text-xs text-green-600 mt-2"></p>
                    </div>
                </div>

                <!-- Summary -->
                <div class="card p-6 h-fit" x-data="{
                    courier: '{{ old('shipping_courier', 'jne') }}',
                    payMethod: '{{ old('payment_method', 'midtrans') }}',
                    subtotal: {{ $subtotal }},
                    voucherDiscount: {{ session('applied_voucher')['discount'] ?? 0 }},
                    costs: { jne: 15000, jnt: 14000, sicepat: 13000, pos: 12000, tiki: 13500, anteraja: 20000 },
                    get shippingCost() { return this.costs[this.courier] || 0; },
                    get grandTotal() { return Math.max(0, this.subtotal + this.shippingCost - this.voucherDiscount); },
                    formatRp(v) { return 'Rp ' + v.toLocaleString('id-ID'); }
                }" x-init="
                    $watch('courier', v => courier = v);
                    document.addEventListener('change', e => {
                        if (e.target.name === 'shipping_courier') courier = e.target.value;
                        if (e.target.name === 'payment_method') payMethod = e.target.value;
                    });
                    document.addEventListener('voucher-updated', e => {
                        this.voucherDiscount = e.detail || 0;
                    });
                    window.dispatchEvent(new CustomEvent('voucher-discount', { detail: this.voucherDiscount }));
                ">
                    <h3 class="text-sm font-semibold font-display text-dark-900 mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-dark-500">
                            <span>Subtotal</span>
                            <span class="font-medium text-dark-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-dark-500">
                            <span>Ongkos Kirim</span>
                            <span class="font-medium text-dark-700" x-text="formatRp(shippingCost)">Rp 0</span>
                        </div>
                        <div x-show="voucherDiscount > 0" class="flex items-center justify-between text-green-600">
                            <span>Diskon Voucher</span>
                            <span class="font-medium" x-text="'- ' + formatRp(voucherDiscount)">- Rp 0</span>
                        </div>
                        <div class="border-t border-dark-100 pt-3 flex items-center justify-between">
                            <span class="font-semibold text-dark-900">Total</span>
                            <span class="font-bold text-primary-600 font-display text-lg" x-text="formatRp(grandTotal)">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mt-4 p-3 rounded-xl text-xs" :class="payMethod === 'cod' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700'">
                        <span x-show="payMethod === 'midtrans'">💳 Bayar online via Midtrans setelah order dibuat</span>
                        <span x-show="payMethod === 'cod'">💵 Bayar tunai saat kurir tiba di alamat Anda</span>
                    </div>
                    <button type="submit" class="w-full btn-primary mt-4 justify-center" @disabled($addresses->isEmpty())>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Buat Pesanan
                    </button>
                    <p class="text-[10px] text-dark-400 text-center mt-3">Dengan menekan tombol ini, Anda menyetujui syarat & ketentuan.</p>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
