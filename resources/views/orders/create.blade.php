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
                                        <p class="text-xs text-dark-400">{{ $item->product?->formatted_price ?? '-' }} x {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-dark-900 shrink-0">{{ $item->formatted_subtotal }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="card p-6">
                        <h2 class="text-sm font-semibold font-display text-dark-900 mb-3">Catatan (Opsional)</h2>
                        <textarea name="notes" rows="3" class="input-modern resize-none" placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Summary -->
                <div class="card p-6 h-fit">
                    <h3 class="text-sm font-semibold font-display text-dark-900 mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-dark-500">
                            <span>Subtotal</span>
                            <span class="font-medium text-dark-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-dark-500">
                            <span>Ongkos Kirim</span>
                            <span class="font-medium text-dark-700">Rp 0</span>
                        </div>
                        <div class="border-t border-dark-100 pt-3 flex items-center justify-between">
                            <span class="font-semibold text-dark-900">Total</span>
                            <span class="font-bold text-primary-600 font-display text-lg">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full btn-primary mt-5 justify-center" @disabled($addresses->isEmpty())>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Buat Pesanan
                    </button>
                    <p class="text-[10px] text-dark-400 text-center mt-3">Dengan menekan tombol ini, Anda menyetujui syarat & ketentuan.</p>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
