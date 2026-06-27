<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <a href="{{ route('products.index') }}" class="hover:text-primary-600 transition-colors">Produk</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium truncate">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Images -->
            <div class="space-y-4">
                <div class="card overflow-hidden aspect-square bg-dark-50 flex items-center justify-center">
                    @if ($product->first_image)
                        <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-24 h-24 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    @endif
                </div>
                @if ($product->images && count($product->images) > 1)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach ($product->images as $img)
                            <div class="aspect-square rounded-xl overflow-hidden border border-dark-100 cursor-pointer hover:border-primary-400 transition-colors">
                                <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="space-y-5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="badge-primary text-[10px]">{{ $product->category->name }}</span>
                        <span class="badge {{ $product->condition === 'new' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }} text-[10px]">{{ $product->condition_label }}</span>
                    </div>
                    <h1 class="text-2xl font-bold font-display text-dark-900 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center gap-3 text-sm text-dark-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <a href="{{ route('stores.show', $product->sellerProfile->store_slug) }}" class="hover:text-primary-600 transition-colors">
                                {{ $product->sellerProfile->store_name }}
                            </a>
                        </span>
                        <span class="text-dark-300">|</span>
                        <span>{{ $product->total_sold }} terjual</span>
                    </div>
                </div>

                <div class="card p-5">
                    <p class="text-3xl font-bold font-display text-primary-600 mb-4">{{ $product->formatted_price }}</p>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="border-r border-dark-100 pr-4">
                            <p class="text-xs text-dark-400">Stok</p>
                            <p class="text-sm font-semibold {{ $product->stock > 0 ? 'text-dark-900' : 'text-red-500' }}">{{ $product->stock > 0 ? $product->stock : 'Habis' }}</p>
                        </div>
                        <div class="border-r border-dark-100 pr-4">
                            <p class="text-xs text-dark-400">Berat</p>
                            <p class="text-sm font-semibold text-dark-900">{{ $product->weight > 0 ? $product->weight . 'g' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-dark-400">SKU</p>
                            <p class="text-sm font-semibold text-dark-900">{{ $product->sku ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                @if ($product->description)
                    <div>
                        <h3 class="text-sm font-semibold text-dark-900 mb-2">Deskripsi</h3>
                        <p class="text-sm text-dark-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                @endif

                @auth
                    @if ($product->stock > 0)
                        <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-10 h-10 rounded-xl bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold transition-colors">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center input-modern" id="qty">
                                <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-10 h-10 rounded-xl bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold transition-colors">+</button>
                            </div>
                            <button type="submit" class="btn-primary flex-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <div class="card p-4 text-center">
                            <p class="text-sm text-red-500 font-medium">Produk ini sedang habis stoknya.</p>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                        Masuk untuk Membeli
                    </a>
                @endauth
            </div>
        </div>

        <!-- Related Products -->
        @if ($related->isNotEmpty())
            <div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Produk Serupa</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($related as $item)
                        <a href="{{ route('products.show', $item) }}" class="card card-hover overflow-hidden group">
                            <div class="h-36 bg-dark-50 overflow-hidden">
                                @if ($item->first_image)
                                    <img src="{{ asset('storage/' . $item->first_image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3 space-y-1">
                                <h3 class="text-sm font-medium text-dark-900 line-clamp-2">{{ $item->name }}</h3>
                                <p class="text-sm font-bold text-primary-600">{{ $item->formatted_price }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
