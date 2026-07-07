<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20"
    class="sticky top-0 z-50 bg-white border-b border-dark-100 transition-shadow duration-300"
    :class="scrolled ? 'shadow-soft' : ''">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-glow group-hover:scale-110 transition-transform duration-300">
                    T
                </div>
                <span class="text-xl font-bold font-display text-dark-900 group-hover:text-primary-600 transition-colors">TokoKu</span>
            </a>

            <!-- Search Bar (desktop) -->
            <div class="flex-1 max-w-xl hidden sm:block" x-data="liveSearch()" @click.outside="showResults = false">
                <form action="{{ route('products.index') }}" method="GET" @submit="showResults = false">
                    <div class="relative group">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk, toko, kategori..."
                            class="w-full bg-dark-50 border border-dark-200/60 rounded-xl pl-11 pr-5 py-2.5 text-sm outline-none transition-all duration-200 focus:bg-white focus:border-primary-400 focus:ring-4 focus:ring-primary-100 placeholder-dark-400"
                            x-model="query"
                            @input.debounce.300ms="performSearch()"
                            @focus="if (query.length >= 2 && results.length > 0) showResults = true"
                        >
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-dark-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <!-- Live Search Results -->
                        <div
                            x-show="showResults"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-card-hover border border-dark-100 overflow-hidden z-50"
                            style="display: none;"
                        >
                            <!-- Loading -->
                            <div x-show="loading" class="p-6 text-center text-sm text-dark-400" style="display: none;">
                                <svg class="w-6 h-6 mx-auto mb-2 animate-spin text-primary-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mencari...
                            </div>

                            <!-- Results -->
                            <div x-show="!loading && results.length > 0" class="max-h-96 overflow-y-auto scrollbar-thin">
                                <template x-for="product in results" :key="product.id">
                                    <a :href="product.url" class="flex items-center gap-3 p-3 hover:bg-primary-50 transition-colors border-b border-dark-50 last:border-0">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-dark-50 shrink-0">
                                            <img x-show="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover">
                                            <div x-show="!product.image" class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-dark-900 truncate" x-text="product.name"></p>
                                            <p class="text-xs text-dark-400 truncate" x-text="product.store"></p>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <p class="text-sm font-bold text-primary-600" x-text="product.price"></p>
                                            <p class="text-[10px] text-dark-400" x-show="product.rating">
                                                <span x-text="'★ ' + product.rating"></span>
                                                <span x-text="'(' + product.review_count + ')'" x-show="product.review_count > 0"></span>
                                            </p>
                                        </div>
                                    </a>
                                </template>
                                <a href="{{ route('products.index') }}" class="block py-3 text-center text-sm font-medium text-primary-600 hover:bg-primary-50 transition-colors">
                                    Lihat semua hasil →
                                </a>
                            </div>

                            <!-- No Results -->
                            <div x-show="!loading && results.length === 0 && query.length >= 2" class="p-6 text-center text-sm text-dark-400" style="display: none;">
                                Tidak ada produk ditemukan untuk "<span class="font-medium text-dark-600" x-text="query"></span>"
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Catalog Button -->
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Katalog
                </a>

                <!-- Categories Button -->
                <a href="{{ route('categories.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /></svg>
                    Kategori
                </a>

                <!-- FAQ Button -->
                <a href="{{ route('faq') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Bantuan
                </a>

                <!-- About Button -->
                <a href="{{ route('about') }}" class="hidden md:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Tentang
                </a>

                <!-- Contact Button -->
                <a href="{{ route('contact.index') }}" class="hidden md:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Kontak
                </a>

                @auth
                    <!-- Notifications -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" class="relative p-2.5 text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group" title="Notifikasi">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                            @if ($unreadCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>

                        <div x-show="notifOpen" @click.outside="notifOpen = false" x-transition.origin.top.right
                            class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-card-hover border border-dark-100 z-50 overflow-hidden animate-scale-in"
                            style="display: none;">
                            <div class="px-4 py-3 border-b border-dark-100 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-dark-900">Notifikasi</h3>
                                @if ($unreadCount > 0)
                                    <form method="POST" action="{{ route('notifications.read-all') }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Tandai semua dibaca</button>
                                    </form>
                                @endif
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-dark-50">
                                @forelse (auth()->user()->notifications->take(8) as $notif)
                                    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 hover:bg-dark-50 transition-colors flex items-start gap-3 {{ $notif->read_at ? 'opacity-60' : '' }}">
                                            @if (!$notif->read_at)
                                                <span class="w-2 h-2 rounded-full bg-primary-500 shrink-0 mt-1.5"></span>
                                            @else
                                                <span class="w-2 h-2 shrink-0 mt-1.5"></span>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="text-xs font-semibold text-dark-900">{{ $notif->data['title'] ?? 'Notifikasi' }}</p>
                                                <p class="text-xs text-dark-500 mt-0.5 line-clamp-2">{{ $notif->data['message'] ?? '' }}</p>
                                                <p class="text-[10px] text-dark-300 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                            </div>
                                        </button>
                                    </form>
                                @empty
                                    <div class="px-4 py-8 text-center text-sm text-dark-400">Tidak ada notifikasi</div>
                                @endforelse
                            </div>
                            @if (auth()->user()->notifications->count() > 8)
                                <div class="px-4 py-2 border-t border-dark-100 text-center">
                                    <a href="{{ route('dashboard') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat semua notifikasi</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist') }}" class="relative p-2.5 text-dark-600 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-200 group" title="Wishlist">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                        @if ($wishlistCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart') }}" class="relative p-2.5 text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-secondary-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center @auth @if(auth()->user()->cartItems()->count() == 0) hidden @endif @endauth">@auth{{ auth()->user()->cartItems()->count() }}@endauth</span>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ userMenu: false }">
                        <button @click="userMenu = !userMenu" class="flex items-center gap-2 p-1.5 pr-3 rounded-full hover:bg-dark-50 transition-all duration-200">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm overflow-hidden">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-dark-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-dark-400 hidden sm:block transition-transform duration-200" :class="userMenu ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenu" @click.outside="userMenu = false" x-transition.origin.top.right
                            class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-card-hover py-2 border border-dark-100 animate-scale-in"
                            style="display: none;">
                            <div class="px-4 py-3 border-b border-dark-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold overflow-hidden">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-dark-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-dark-400 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                @if (Auth::user()->isBuyer())
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-dark-700 hover:bg-dark-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-dark-700 hover:bg-dark-50 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-dark-700 hover:bg-dark-50 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    Pesanan Saya
                                </a>
                                @if (Auth::user()->isBuyer())
                                    <a href="{{ route('become-seller') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-primary-600 font-medium hover:bg-primary-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        Jadi Seller
                                    </a>
                                @endif
                                @if (Auth::user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-dark-700 hover:bg-dark-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                                        Dashboard Seller
                                    </a>
                                @endif
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-dark-700 hover:bg-dark-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Dashboard Admin
                                    </a>
                                @endif
                            </div>
                            <div class="border-t border-dark-100 p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-glow hover:shadow-glow-lg transition-all duration-300 active:scale-95">
                        Daftar
                    </a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button @click="open = !open" class="sm:hidden p-2.5 text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Category Quick Links -->
    <div class="hidden sm:block border-t border-dark-100/50 bg-white/50 backdrop-blur-sm transition-all duration-300 overflow-hidden" :class="scrolled ? 'max-h-0 opacity-0 py-0' : 'max-h-20 opacity-100'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-1.5 py-2.5 overflow-x-auto scrollbar-thin">
                <span class="text-xs font-semibold text-dark-400 shrink-0 pr-2">Kategori:</span>
                @foreach (\App\Models\Category::where('is_active', true)->orderBy('name')->limit(8)->get() as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="shrink-0 px-3 py-1.5 text-xs font-medium text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-full transition-all duration-200 hover:scale-105">
                        {{ $cat->name }}
                    </a>
                @endforeach
                <span class="shrink-0 w-px h-4 bg-dark-200 mx-1"></span>
                <a href="{{ route('products.index') }}" class="shrink-0 px-3 py-1.5 text-xs font-semibold text-primary-600 hover:bg-primary-50 rounded-full transition-all duration-200 flex items-center gap-1">
                    Semua
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition.origin.top class="sm:hidden border-t border-dark-100 bg-white/95 backdrop-blur-md" style="display: none;">
        <div class="px-4 py-4 space-y-3">
            <!-- Mobile Search -->
            <div x-data="liveSearch()" @click.outside="showResults = false">
                <form action="{{ route('products.index') }}" method="GET" @submit="showResults = false">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk..."
                            class="w-full bg-dark-50 border border-dark-200 rounded-xl pl-11 pr-10 py-2.5 text-sm outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 transition-all"
                            x-model="query"
                            @input.debounce.300ms="performSearch()"
                            @focus="if (query.length >= 2 && results.length > 0) showResults = true"
                        >
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <!-- Live Search Results -->
                        <div
                            x-show="showResults"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-card-hover border border-dark-100 overflow-hidden z-50"
                            style="display: none;"
                        >
                            <div x-show="loading" class="p-4 text-center text-sm text-dark-400" style="display: none;">
                                <svg class="w-5 h-5 mx-auto mb-1 animate-spin text-primary-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mencari...
                            </div>
                            <div x-show="!loading && results.length > 0" class="max-h-80 overflow-y-auto scrollbar-thin">
                                <template x-for="product in results" :key="product.id">
                                    <a :href="product.url" class="flex items-center gap-3 p-3 hover:bg-primary-50 transition-colors border-b border-dark-50 last:border-0">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-dark-50 shrink-0">
                                            <img x-show="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover">
                                            <div x-show="!product.image" class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-dark-900 truncate" x-text="product.name"></p>
                                            <p class="text-xs text-primary-600 font-semibold" x-text="product.price"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                            <div x-show="!loading && results.length === 0 && query.length >= 2" class="p-4 text-center text-sm text-dark-400" style="display: none;">
                                Tidak ada hasil untuk "<span class="font-medium text-dark-600" x-text="query"></span>"
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                Katalog Produk
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /></svg>
                Semua Kategori
            </a>
            <a href="{{ route('faq') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                FAQ & Bantuan
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Tentang Kami
            </a>
            <a href="{{ route('contact.index') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Hubungi Kami
            </a>
            @auth
                @if (Auth::user()->isBuyer())
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-2.5 text-sm text-dark-700 hover:text-primary-600 transition-colors">
                        <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Dashboard
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 py-2.5 text-sm text-dark-700 hover:text-primary-600 transition-colors">
                    <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profil Saya
                </a>
                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 py-2.5 text-sm text-dark-700 hover:text-primary-600 transition-colors">
                    <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Pesanan Saya
                </a>
                @if (Auth::user()->isBuyer())
                    <a href="{{ route('become-seller') }}" class="flex items-center gap-3 py-2.5 text-sm text-primary-600 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Jadi Seller
                    </a>
                @endif
                <div class="border-t border-dark-100 pt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 py-2.5 text-sm text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('register') }}" class="block w-full text-center bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold py-3 rounded-xl text-sm shadow-glow transition-all">
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>

    <script>
        function liveSearch() {
            return {
                query: '{{ request('search') }}',
                results: [],
                loading: false,
                showResults: false,
                abortController: null,

                async performSearch() {
                    if (this.query.length < 2) {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }

                    if (this.abortController) {
                        this.abortController.abort();
                    }

                    this.abortController = new AbortController();
                    this.loading = true;
                    this.showResults = true;

                    try {
                        const response = await fetch(
                            '{{ route('products.search') }}?q=' + encodeURIComponent(this.query),
                            { signal: this.abortController.signal }
                        );
                        const data = await response.json();
                        this.results = data.products || [];
                    } catch (e) {
                        if (e.name !== 'AbortError') {
                            this.results = [];
                        }
                    } finally {
                        this.loading = false;
                    }
                },
            };
        }
    </script>
</nav>
