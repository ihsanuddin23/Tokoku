<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Wishlist</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Wishlist Saya</h1>
            <p class="text-sm text-dark-500">{{ $wishlists->total() }} produk tersimpan</p>
        </div>

        @if (session('status'))
            <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('status') }}
            </div>
        @endif

        @if ($wishlists->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-red-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Wishlist Masih Kosong</h2>
                <p class="text-sm text-dark-400 mb-6">Simpan produk favoritmu dengan menekan ikon hati di halaman produk.</p>
                <a href="{{ route('products.index') }}" class="btn-primary inline-flex">Jelajahi Produk</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                @foreach ($wishlists as $wishlist)
                    @php $product = $wishlist->product; @endphp
                    @if ($product)
                        <div class="card card-hover overflow-hidden group animate-fade-in-up relative" style="animation-delay: {{ ($loop->iteration - 1) * 0.05 }}s">
                            <!-- Remove from wishlist button -->
                            <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="absolute top-2 right-2 z-10" onsubmit="return confirm('Hapus produk ini dari wishlist?')">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-sm hover:bg-red-50 transition-colors group/btn" title="Hapus dari wishlist">
                                    <svg class="w-4 h-4 text-dark-400 group-hover/btn:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>

                            <a href="{{ route('products.show', $product) }}" class="block">
                                <div class="h-40 bg-dark-50 overflow-hidden">
                                    @if ($product->first_image)
                                        <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4 space-y-2">
                                    <p class="text-xs text-dark-400 truncate">{{ $product->sellerProfile?->store_name }}</p>
                                    <h3 class="text-sm font-medium text-dark-900 line-clamp-2 leading-snug min-h-[2.5rem]">{{ $product->name }}</h3>
                                    <p class="text-base font-bold font-display text-primary-600">{{ $product->formatted_price }}</p>
                                    <div class="flex items-center justify-between pt-1">
                                        @if ($product->review_count > 0)
                                            <span class="text-[10px] text-amber-500 font-medium">★ {{ number_format($product->rating, 1) }} ({{ $product->review_count }})</span>
                                        @else
                                            <span class="text-[10px] text-dark-300">Belum ada ulasan</span>
                                        @endif
                                        <span class="text-[10px] text-dark-400">{{ $product->total_sold }} terjual</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            @if ($wishlists->hasPages())
                <div class="flex justify-center">
                    {{ $wishlists->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
