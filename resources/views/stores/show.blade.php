<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium truncate">{{ $store->store_name }}</span>
        </div>

        <!-- Store Header -->
        <div class="relative rounded-3xl overflow-hidden mb-8">
            <div class="h-40 sm:h-56 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 relative">
                @if ($store->banner)
                    <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 bg-grid opacity-10"></div>
                    <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                @endif
            </div>
            <div class="bg-white px-6 sm:px-8 pb-6 -mt-12 relative">
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden shrink-0 ring-4 ring-white shadow-lg -mt-12">
                        @if ($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-3xl font-bold text-primary-600">{{ strtoupper(substr($store->store_name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h1 class="text-2xl font-bold font-display text-dark-900">{{ $store->store_name }}</h1>
                            @if ($store->is_verified)
                                <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 text-sm text-dark-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ $store->city }}
                            </span>
                            <span class="text-dark-300">|</span>
                            <span>{{ $store->products()->active()->count() }} produk</span>
                        </div>
                    </div>
                </div>
                @if ($store->description)
                    <p class="text-sm text-dark-600 leading-relaxed mt-4 max-w-3xl">{{ $store->description }}</p>
                @endif
            </div>
        </div>

        <!-- Sort Bar -->
        <div class="flex items-center justify-between mb-5">
            <p class="text-sm text-dark-500">Produk dari toko ini</p>
            <div class="flex items-center gap-2">
                <span class="text-xs text-dark-400">Urutkan:</span>
                <select name="sort" class="bg-dark-50 border border-dark-200 rounded-lg px-3 py-1.5 text-xs text-dark-700 outline-none focus:border-primary-400 cursor-pointer" onchange="window.location.href='{{ route('stores.show', $store->store_slug) }}' + (this.value ? '?sort=' + this.value : '')">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Terbaru</option>
                    <option value="popular" @selected(request('sort') === 'popular')>Terpopuler</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga Terendah</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga Tertinggi</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        @if ($products->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-dark-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <p class="text-sm text-dark-400">Toko ini belum memiliki produk.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="card card-hover overflow-hidden group">
                        <div class="h-40 bg-dark-50 overflow-hidden relative">
                            @if ($product->first_image)
                                <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            @if ($product->condition === 'used')
                                <span class="absolute top-2 left-2 badge bg-amber-100 text-amber-700 text-[9px]">Bekas</span>
                            @endif
                        </div>
                        <div class="p-4 space-y-2">
                            <h3 class="text-sm font-medium text-dark-900 line-clamp-2 leading-snug min-h-[2.5rem]">{{ $product->name }}</h3>
                            <p class="text-base font-bold font-display text-primary-600">{{ $product->formatted_price }}</p>
                            <div class="flex items-center justify-between pt-1">
                                @if ($product->stock > 0)
                                    <span class="text-[10px] text-green-600 font-medium">Stok: {{ $product->stock }}</span>
                                @else
                                    <span class="text-[10px] text-red-500 font-medium">Habis</span>
                                @endif
                                <span class="text-[10px] text-dark-400">{{ $product->total_sold }} terjual</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($products->hasPages())
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
