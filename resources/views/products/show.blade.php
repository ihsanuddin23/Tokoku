<x-app-layout>
    @section('meta_title', $product->name . ' — ' . config('app.name'))
    @section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))
    @section('og_title', $product->name . ' — ' . config('app.name'))
    @section('og_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))
    @section('og_type', 'product')
    @if ($product->first_image)
        @section('og_image', asset('storage/' . $product->first_image))
    @endif

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
                    <div class="flex items-start justify-between gap-3">
                        <h1 class="text-2xl font-bold font-display text-dark-900 mb-2 flex-1">{{ $product->name }}</h1>
                        @auth
                            <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="shrink-0">
                                @csrf
                                <button type="submit" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}"
                                    class="w-10 h-10 rounded-xl border {{ $isWishlisted ? 'border-red-300 bg-red-50 text-red-500' : 'border-dark-200 bg-white text-dark-400 hover:border-red-300 hover:text-red-500' }} flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                </button>
                            </form>
                        @endauth
                    </div>
                    <div class="flex items-center gap-3 text-sm text-dark-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <a href="{{ route('stores.show', $product->sellerProfile->store_slug) }}" class="hover:text-primary-600 transition-colors">
                                {{ $product->sellerProfile->store_name }}
                            </a>
                        </span>
                        <span class="text-dark-300">|</span>
                        <span>{{ $product->total_sold }} terjual</span>
                        @if ($product->review_count > 0)
                            <span class="text-dark-300">|</span>
                            <span class="flex items-center gap-1 text-amber-500 font-medium">
                                ★ {{ number_format($product->rating, 1) }}
                                <span class="text-dark-400 font-normal">({{ $product->review_count }} ulasan)</span>
                            </span>
                        @endif
                        @auth
                            <a href="{{ route('messages.index') }}" onclick="event.preventDefault(); document.getElementById('chat-seller-form').submit()" class="ml-auto text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Chat Penjual
                            </a>
                            <form id="chat-seller-form" action="{{ route('messages.start') }}" method="POST" style="display:none;">
                                @csrf
                                <input type="hidden" name="seller_profile_id" value="{{ $product->seller_profile_id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="body" value="Halo, saya tertarik dengan produk {{ $product->name }}">
                            </form>
                        @endauth
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
                        <div x-data="{
                            selectedVariantId: null,
                            variants: {{ $product->activeVariants->map(fn ($v) => ['id' => $v->id, 'name' => $v->name, 'price' => $v->effective_price, 'formatted_price' => $v->formatted_effective_price, 'stock' => $v->stock, 'price_adjustment' => $v->formatted_price_adjustment])->values()->toJson() }},
                            basePrice: {{ (float) $product->price }},
                            get currentPrice() {
                                if (this.selectedVariantId) {
                                    const v = this.variants.find(v => v.id === this.selectedVariantId);
                                    return v ? v.formatted_price : '{{ $product->formatted_price }}';
                                }
                                return '{{ $product->formatted_price }}';
                            },
                            get currentStock() {
                                if (this.selectedVariantId) {
                                    const v = this.variants.find(v => v.id === this.selectedVariantId);
                                    return v ? v.stock : 0;
                                }
                                return {{ $product->stock }};
                            },
                            get hasVariants() { return this.variants.length > 0; }
                        }">
                            @if ($product->activeVariants->isNotEmpty())
                                <div class="space-y-2">
                                    <p class="text-sm font-medium text-dark-700">Pilih Variasi</p>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" @click="selectedVariantId = null"
                                            :class="selectedVariantId === null ? 'border-primary-500 ring-2 ring-primary-100 bg-primary-50 text-primary-700' : 'border-dark-200 hover:border-primary-300'"
                                            class="border rounded-xl px-4 py-2 text-sm font-medium transition-all">
                                            Standar
                                        </button>
                                        @foreach ($product->activeVariants as $variant)
                                            <button type="button" @click="selectedVariantId = {{ $variant->id }}"
                                                :class="selectedVariantId === {{ $variant->id }} ? 'border-primary-500 ring-2 ring-primary-100 bg-primary-50 text-primary-700' : 'border-dark-200 hover:border-primary-300'"
                                                class="border rounded-xl px-4 py-2 text-sm font-medium transition-all">
                                                {{ $variant->name }}
                                                <span class="text-xs text-dark-400 ml-1">{{ $variant->formatted_price_adjustment }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-3 mt-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" :value="selectedVariantId">
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-10 h-10 rounded-xl bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold transition-colors">-</button>
                                    <input type="number" name="quantity" value="1" min="1" :max="currentStock" class="w-16 text-center input-modern" id="qty">
                                    <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-10 h-10 rounded-xl bg-dark-50 hover:bg-dark-100 text-dark-600 font-bold transition-colors">+</button>
                                </div>
                                <button type="submit" class="btn-primary flex-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="card p-4 text-center space-y-3">
                            <p class="text-sm text-red-500 font-medium">Produk ini sedang habis stoknya.</p>
                            <form method="POST" action="{{ route('products.notify-stock', $product) }}">
                                @csrf
                                <button type="submit" class="btn-primary w-full justify-center text-sm py-2.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    Beri Tahu Saya Saat Stok Tersedia
                                </button>
                            </form>
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

        <!-- Reviews Section -->
        <div class="mb-10" x-data="{ showForm: false }">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-semibold font-display text-dark-900">Ulasan Pembeli</h2>
                    @if ($product->review_count > 0)
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-3xl font-bold text-dark-900">{{ number_format($product->rating, 1) }}</span>
                            <div>
                                <div class="flex text-amber-400 text-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($product->rating))
                                            <span>★</span>
                                        @else
                                            <span class="text-dark-200">★</span>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-xs text-dark-400">{{ $product->review_count }} ulasan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if (session('status') === 'review-submitted')
                <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-4">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Ulasan berhasil dikirim. Terima kasih!
                </div>
            @endif

            <!-- Reviews List -->
            @if ($reviews->isEmpty())
                <div class="card p-8 text-center text-sm text-dark-400">Belum ada ulasan untuk produk ini.</div>
            @else
                <div class="space-y-4 mb-4">
                    @foreach ($reviews as $review)
                        <div class="card p-5">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-semibold text-dark-900">{{ $review->user->name }}</p>
                                        <p class="text-xs text-dark-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex text-amber-400 text-sm my-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $review->rating ? 'text-amber-400' : 'text-dark-200' }}">★</span>
                                        @endfor
                                    </div>
                                    @if ($review->comment)
                                        <p class="text-sm text-dark-600">{{ $review->comment }}</p>
                                    @endif
                                    @if ($review->seller_response)
                                        <div class="mt-3 ml-4 pl-4 border-l-2 border-primary-200 bg-primary-50/50 rounded-r-lg py-2 px-3">
                                            <p class="text-xs font-semibold text-primary-700 mb-1">Balasan Penjual</p>
                                            <p class="text-sm text-dark-600">{{ $review->seller_response }}</p>
                                            <p class="text-[10px] text-dark-400 mt-1">{{ $review->seller_responded_at->format('d M Y') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $reviews->links() }}
            @endif
        </div>

        <!-- Related Products -->
        @if ($related->isNotEmpty())
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold font-display text-dark-900">Produk Serupa</h2>
                    <a href="{{ route('categories.show', $product->category->slug) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors">
                        Lihat Semua →
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($related as $item)
                        <div class="card card-hover overflow-hidden group relative animate-fade-in-up" style="animation-delay: {{ ($loop->iteration - 1) * 0.04 }}s">
                            @auth
                                <form method="POST" action="{{ route('wishlist.toggle', $item) }}" class="absolute top-2 right-2 z-10">
                                    @csrf
                                    <button type="submit"
                                        class="w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-sm hover:bg-red-50 transition-colors"
                                        title="{{ in_array($item->id, $wishlistedIds) ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                        <svg class="w-3.5 h-3.5 {{ in_array($item->id, $wishlistedIds) ? 'text-red-500' : 'text-dark-300' }}"
                                            fill="{{ in_array($item->id, $wishlistedIds) ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth
                            <a href="{{ route('products.show', $item) }}" class="block">
                                <div class="h-36 bg-dark-50 overflow-hidden relative">
                                    @if ($item->first_image)
                                        <img src="{{ asset('storage/' . $item->first_image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-10 h-10 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                    @if ($item->condition === 'used')
                                        <span class="absolute top-2 left-2 badge bg-amber-100 text-amber-700 text-[9px]">Bekas</span>
                                    @endif
                                </div>
                                <div class="p-3 space-y-1.5">
                                    <p class="text-[10px] text-dark-400 truncate">{{ $item->sellerProfile?->store_name }}</p>
                                    <h3 class="text-sm font-medium text-dark-900 line-clamp-2 leading-snug min-h-[2.5rem]">{{ $item->name }}</h3>
                                    <p class="text-sm font-bold text-primary-600">{{ $item->formatted_price }}</p>
                                    <div class="flex items-center justify-between pt-0.5">
                                        @if ($item->review_count > 0)
                                            <span class="text-[10px] text-amber-500 font-medium flex items-center gap-0.5">
                                                ★ {{ number_format($item->rating, 1) }}
                                                <span class="text-dark-400">({{ $item->review_count }})</span>
                                            </span>
                                        @else
                                            <span class="text-[10px] text-dark-300">Belum ada ulasan</span>
                                        @endif
                                        <span class="text-[10px] text-dark-400">{{ $item->total_sold }} terjual</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recently Viewed -->
        @if ($recentlyViewed->isNotEmpty())
            <div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Baru Saja Dilihat</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($recentlyViewed as $item)
                        <div class="card card-hover overflow-hidden group animate-fade-in-up" style="animation-delay: {{ ($loop->iteration - 1) * 0.04 }}s">
                            <a href="{{ route('products.show', $item) }}" class="block">
                                <div class="aspect-square bg-dark-50 overflow-hidden">
                                    @if ($item->images && count($item->images) > 0)
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-dark-300">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <p class="text-xs text-dark-400 mb-0.5">{{ $item->category->name }}</p>
                                    <p class="text-sm font-medium text-dark-900 line-clamp-2 mb-1">{{ $item->name }}</p>
                                    <p class="text-sm font-bold text-primary-600">{{ $item->formatted_price }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
