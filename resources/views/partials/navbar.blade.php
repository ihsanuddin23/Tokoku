<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20"
    class="sticky top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'glass shadow-soft' : 'bg-white/80 backdrop-blur-sm'">
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
            <div class="flex-1 max-w-xl hidden sm:block">
                <div class="relative group">
                    <input type="text" placeholder="Cari produk, toko, kategori..."
                        class="w-full bg-dark-50 border border-dark-200/60 rounded-xl pl-11 pr-5 py-2.5 text-sm outline-none transition-all duration-200 focus:bg-white focus:border-primary-400 focus:ring-4 focus:ring-primary-100 placeholder-dark-400">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Catalog Button -->
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Katalog
                </a>

                @auth
                    <!-- Notifications -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" class="relative p-2.5 text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-secondary-500 rounded-full animate-pulse"></span>
                        </button>
                        <div x-show="notifOpen" @click.outside="notifOpen = false" x-transition.origin.top.right
                            class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-card-hover py-2 border border-dark-100 animate-scale-in" style="display: none;">
                            <div class="px-4 py-3 border-b border-dark-100 flex items-center justify-between">
                                <p class="text-sm font-semibold text-dark-900">Notifikasi</p>
                                <span class="badge-primary text-[10px]">3 Baru</span>
                            </div>
                            <div class="max-h-80 overflow-y-auto scrollbar-thin">
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-dark-50 transition-colors">
                                    <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-dark-900">Pesanan dikonfirmasi</p>
                                        <p class="text-xs text-dark-400 mt-0.5">Pesanan #12345 sedang diproses</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-dark-50 transition-colors">
                                    <div class="w-9 h-9 rounded-xl bg-secondary-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-dark-900">Promo spesial!</p>
                                        <p class="text-xs text-dark-400 mt-0.5">Diskon 20% untuk produk pilihan</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-dark-50 transition-colors">
                                    <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-dark-900">Pesanan dikirim</p>
                                        <p class="text-xs text-dark-400 mt-0.5">Paket dalam perjalanan ke alamat Anda</p>
                                    </div>
                                </a>
                            </div>
                            <div class="border-t border-dark-100 p-2">
                                <a href="#" class="block text-center text-sm text-primary-600 hover:text-primary-700 font-medium py-2 rounded-lg hover:bg-primary-50 transition-colors">Lihat Semua</a>
                            </div>
                        </div>
                    </div>

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
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="shrink-0 px-3 py-1.5 text-xs font-medium text-dark-600 hover:text-primary-600 hover:bg-primary-50 rounded-full transition-all duration-200 hover:scale-105">
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
            <div class="relative">
                <input type="text" placeholder="Cari produk..."
                    class="w-full bg-dark-50 border border-dark-200 rounded-xl pl-11 pr-5 py-2.5 text-sm outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 transition-all">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 py-2.5 text-sm font-medium text-dark-700 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                Katalog Produk
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
</nav>
