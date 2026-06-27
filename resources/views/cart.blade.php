<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Keranjang</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Keranjang Belanja</h1>
            <p class="text-sm text-dark-500">Review produk pilihan Anda sebelum checkout.</p>
        </div>

        @if (session('status') === 'cart-added')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Produk ditambahkan ke keranjang.
            </div>
        @elseif (session('status') === 'cart-updated')
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Keranjang diperbarui.
            </div>
        @elseif (session('status') === 'cart-removed')
            <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Produk dihapus dari keranjang.
            </div>
        @endif
        @if (session('info'))
            <div class="glass border-blue-200/50 text-blue-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('info') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="card p-16 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-primary-500/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Keranjang Kosong</h2>
                    <p class="text-sm text-dark-400 max-w-md mx-auto mb-6">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
                    <a href="{{ route('products.index') }}" class="btn-primary inline-flex">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-3">
                    @foreach ($cartItems as $item)
                        @if (! $item->product)
                            <div class="card p-4 flex items-center gap-4 border-red-200">
                                <div class="w-20 h-20 rounded-xl bg-dark-50 overflow-hidden shrink-0 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-dark-900">Produk tidak tersedia lagi</p>
                                    <p class="text-xs text-dark-400 mt-0.5">Produk ini telah dihapus oleh penjual.</p>
                                </div>
                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-600 transition-colors font-medium">Hapus</button>
                                </form>
                            </div>
                        @else
                        <div class="card p-4 flex items-center gap-4">
                            <div class="w-20 h-20 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                                @if ($item->product->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product) }}" class="text-sm font-medium text-dark-900 hover:text-primary-600 transition-colors line-clamp-2">{{ $item->product->name }}</a>
                                @if ($item->product->sellerProfile)
                                    <p class="text-xs text-dark-400 mt-0.5">{{ $item->product->sellerProfile->store_name }}</p>
                                @endif
                                <p class="text-sm font-semibold text-primary-600 mt-1">{{ $item->product->formatted_price }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit()" class="w-8 h-8 rounded-lg bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold text-sm transition-colors">-</button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-14 text-center text-sm border border-dark-200 rounded-lg py-1 outline-none focus:border-primary-400" onchange="this.form.submit()">
                                    <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit()" class="w-8 h-8 rounded-lg bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold text-sm transition-colors">+</button>
                                </form>
                                <form method="POST" action="{{ route('cart.destroy', $item) }}" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-dark-400 hover:text-red-500 transition-colors flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="card p-6 h-fit">
                    <h3 class="text-sm font-semibold font-display text-dark-900 mb-4">Ringkasan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-dark-500">
                            <span>Subtotal ({{ $cartItems->count() }} item)</span>
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
                    <a href="{{ route('orders.create') }}" class="w-full btn-primary mt-5 justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        Checkout
                    </a>
                    <a href="{{ route('products.index') }}" class="block w-full text-center text-xs text-dark-500 hover:text-primary-600 transition-colors mt-3">Lanjut Belanja</a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
