<x-app-layout>
    @section('meta_title', $category->name . ' — ' . config('app.name'))
    @section('meta_description', 'Temukan produk ' . $category->name . ' terbaik di TokoKu.')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('categories.index') }}" class="hover:text-primary-600 transition-colors">Kategori</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">{{ $category->name }}</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center shrink-0">
                    @if ($category->icon)
                        <span class="text-2xl">{{ $category->icon }}</span>
                    @else
                        <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold font-display text-dark-900">{{ $category->name }}</h1>
                    <p class="text-sm text-dark-500">{{ $products->total() }} produk tersedia</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filter Sidebar -->
            <aside class="w-full lg:w-64 shrink-0 space-y-4">
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Filter
                    </h3>
                    <form method="GET" action="{{ route('categories.show', $category->slug) }}" class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-dark-700 mb-2">Cari di Kategori Ini</p>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." class="w-full bg-dark-50 border border-dark-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary-400">
                        </div>
                        <div class="border-t border-dark-100 pt-4">
                            <p class="text-xs font-medium text-dark-700 mb-2">Rentang Harga</p>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full bg-dark-50 border border-dark-200 rounded-lg px-2.5 py-1.5 text-xs outline-none focus:border-primary-400">
                                <span class="text-dark-400 text-xs">—</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full bg-dark-50 border border-dark-200 rounded-lg px-2.5 py-1.5 text-xs outline-none focus:border-primary-400">
                            </div>
                        </div>
                        <div class="border-t border-dark-100 pt-4">
                            <p class="text-xs font-medium text-dark-700 mb-2">Kondisi</p>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs text-dark-500 cursor-pointer hover:text-dark-700 transition-colors">
                                    <input type="radio" name="condition" value="new" class="w-4 h-4 border-dark-300 text-primary-500 focus:ring-primary-400" @checked(request('condition') === 'new')>
                                    Baru
                                </label>
                                <label class="flex items-center gap-2 text-xs text-dark-500 cursor-pointer hover:text-dark-700 transition-colors">
                                    <input type="radio" name="condition" value="used" class="w-4 h-4 border-dark-300 text-primary-500 focus:ring-primary-400" @checked(request('condition') === 'used')>
                                    Bekas
                                </label>
                            </div>
                        </div>
                        <div class="border-t border-dark-100 pt-4">
                            <p class="text-xs font-medium text-dark-700 mb-2">Rating Minimum</p>
                            <div class="space-y-2">
                                @foreach ([4 => '4★ ke atas', 3 => '3★ ke atas', 2 => '2★ ke atas'] as $val => $label)
                                    <label class="flex items-center gap-2 text-xs text-dark-500 cursor-pointer hover:text-dark-700 transition-colors">
                                        <input type="radio" name="min_rating" value="{{ $val }}" class="w-4 h-4 border-dark-300 text-primary-500 focus:ring-primary-400" @checked(request('min_rating') == $val)>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="w-full btn-primary text-xs py-2.5">Terapkan Filter</button>
                        @if (request()->hasAny(['search', 'min_price', 'max_price', 'condition', 'min_rating']))
                            <a href="{{ route('categories.show', $category->slug) }}" class="block w-full text-center text-xs text-dark-500 hover:text-primary-600 transition-colors">Reset Filter</a>
                        @endif
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort Bar -->
                <div class="flex items-center justify-between mb-5">
                    <p class="text-sm text-dark-500">Menampilkan <span class="font-semibold text-dark-900">{{ $products->total() }} produk</span></p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-dark-400">Urutkan:</span>
                        <select name="sort" class="bg-dark-50 border border-dark-200 rounded-lg px-3 py-1.5 text-xs text-dark-700 outline-none focus:border-primary-400 cursor-pointer" onchange="const base='{{ route('categories.show', $category->slug) }}'; const params='{{ http_build_query(request()->only(['search', 'min_price', 'max_price', 'condition', 'min_rating'])) }}'; const url=params?base+'?'+params+'&sort='+this.value:base+'?sort='+this.value; window.location.href=url">
                            <option value="newest" @selected(request('sort', 'newest') === 'newest')>Terbaru</option>
                            <option value="popular" @selected(request('sort') === 'popular')>Terpopuler</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga Terendah</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="card p-16 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-primary-500/5 rounded-full blur-3xl"></div>
                        <div class="relative">
                            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                                <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Produk Tidak Ditemukan</h2>
                            <p class="text-sm text-dark-400 max-w-md mx-auto mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
                            <a href="{{ route('categories.show', $category->slug) }}" class="btn-primary inline-flex">Reset Filter</a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                        @foreach ($products as $product)
                            <x-products.partials.product-card :product="$product" :index="$loop->iteration - 1" />
                        @endforeach
                    </div>
                    @if ($products->hasPages())
                        <div class="flex justify-center">
                            {{ $products->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Related Categories -->
        @if ($relatedCategories->isNotEmpty())
            <div class="mt-12 pt-8 border-t border-dark-100">
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Kategori Lainnya</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach ($relatedCategories as $relCategory)
                        <a href="{{ route('categories.show', $relCategory->slug) }}" class="card card-hover px-5 py-3 flex items-center gap-3 group">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                                @if ($relCategory->icon)
                                    <span class="text-lg">{{ $relCategory->icon }}</span>
                                @else
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-dark-900 group-hover:text-primary-600 transition-colors">{{ $relCategory->name }}</p>
                                <p class="text-xs text-dark-400">{{ $relCategory->products_count }} produk</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
