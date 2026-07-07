<x-app-layout>
    <!-- Banner Slider -->
    @if ($banners->isNotEmpty())
    <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="relative rounded-3xl overflow-hidden h-56 sm:h-72 lg:h-96 shadow-card" x-data="{ active: 0, count: {{ $banners->count() }} }" x-init="setInterval(() => { active = (active + 1) % count }, 5000)">
            @php
                $bannerGradients = [
                    'from-emerald-500 via-green-600 to-teal-700',
                    'from-orange-500 via-red-500 to-pink-600',
                    'from-blue-600 via-indigo-600 to-purple-700',
                    'from-violet-600 via-purple-600 to-fuchsia-700',
                ];
                $bannerAccents = [
                    ['bg' => 'bg-secondary-400', 'text' => 'text-orange-100', 'badge' => 'bg-white/20'],
                    ['bg' => 'bg-amber-400', 'text' => 'text-amber-100', 'badge' => 'bg-white/20'],
                    ['bg' => 'bg-cyan-400', 'text' => 'text-cyan-100', 'badge' => 'bg-white/20'],
                    ['bg' => 'bg-pink-400', 'text' => 'text-pink-100', 'badge' => 'bg-white/20'],
                ];
            @endphp
            @foreach ($banners as $i => $banner)
                <a href="{{ $banner->link }}" x-show="active === {{ $i }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 block">
                    <div class="relative h-56 sm:h-72 lg:h-96 bg-gradient-to-br {{ $bannerGradients[$i % 4] }} flex items-center overflow-hidden">
                        <!-- Decorative shapes -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/3 translate-x-1/4"></div>
                        <div class="absolute bottom-0 left-1/4 w-48 h-48 bg-white/5 rounded-full blur-2xl translate-y-1/3"></div>
                        <div class="absolute inset-0 bg-grid opacity-5"></div>

                        <!-- Content -->
                        <div class="relative flex items-center justify-between w-full px-8 sm:px-12 lg:px-16">
                            <div class="max-w-lg text-white">
                                <span class="inline-flex items-center gap-2 {{ $bannerAccents[$i % 4]['badge'] }} backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold mb-4">
                                    @if ($i === 0)
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        Promo Spesial
                                    @elseif($i === 1)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        Flash Sale
                                    @else
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                        Gratis Ongkir
                                    @endif
                                </span>
                                <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold font-display leading-tight mb-3">{{ $banner->title }}</h2>
                                <p class="{{ $bannerAccents[$i % 4]['text'] }} text-sm sm:text-base lg:text-lg mb-5">Klik untuk melihat penawaran menarik</p>
                                <span class="inline-flex items-center gap-2 bg-white text-dark-900 font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-dark-50 transition-all active:scale-95 shadow-lg">
                                    Lihat Penawaran
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </span>
                            </div>
                            <!-- Decorative icon -->
                            <div class="hidden sm:flex shrink-0">
                                <div class="w-24 h-24 lg:w-36 lg:h-36 rounded-3xl bg-white/15 backdrop-blur-sm flex items-center justify-center animate-float">
                                    @if ($i === 0)
                                        <svg class="w-12 h-12 lg:w-20 lg:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z" /></svg>
                                    @elseif($i === 1)
                                        <svg class="w-12 h-12 lg:w-20 lg:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    @else
                                        <svg class="w-12 h-12 lg:w-20 lg:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            @if ($banners->count() > 1)
                <!-- Dots -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach ($banners as $i => $banner)
                        <button @click="active = {{ $i }}" :class="active === {{ $i }} ? 'bg-white w-8' : 'bg-white/50 hover:bg-white w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
                <!-- Arrows -->
                <button @click="active = (active - 1 + count) % count" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm hover:bg-white/30 flex items-center justify-center text-white transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="active = (active + 1) % count" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm hover:bg-white/30 flex items-center justify-center text-white transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            @endif
        </div>
    </section>
    @endif

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900 text-white mt-6">
        <!-- Decorative shapes -->
        <div class="absolute top-10 right-10 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-48 h-48 bg-secondary-500/15 rounded-full blur-2xl animate-pulse-slow"></div>
        <div class="absolute top-1/3 left-1/2 w-32 h-32 bg-primary-400/10 rounded-full blur-xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute inset-0 bg-grid opacity-5"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="text-center max-w-3xl mx-auto animate-fade-in-up">
                <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-secondary-400 rounded-full animate-pulse"></span>
                    Platform E-Commerce Terpercaya
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-display leading-tight mb-6">
                    Belanja Mudah,<br>
                    <span class="bg-gradient-to-r from-primary-400 via-green-300 to-primary-500 bg-clip-text text-transparent">Jualan Menyenangkan</span>
                </h1>
                <p class="text-dark-300 text-lg sm:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                    Platform e-commerce modern yang menghubungkan pembeli dan penjual dalam satu ekosistem yang simpel, cepat, dan terpercaya.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold px-8 py-3.5 rounded-xl hover:from-primary-400 hover:to-primary-500 transition-all duration-300 active:scale-95 shadow-glow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Mulai Belanja
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white/15 backdrop-blur-sm border-2 border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/25 transition-all duration-300 active:scale-95">
                            Daftar Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Wave divider -->
        <div class="relative">
            <svg class="w-full" viewBox="0 0 1440 60" fill="none" preserveAspectRatio="none"><path d="M0 60L60 50C120 40 240 20 360 15C480 10 600 20 720 25C840 30 960 30 1080 25C1200 20 1320 10 1380 5L1440 0V60H0Z" fill="#f8fafc"/></svg>
        </div>
    </section>

    <!-- Features Strip -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="card p-6 flex items-center gap-4 animate-fade-in-up border border-dark-100">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-glow shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="font-semibold text-dark-900 text-sm">Belanja Aman</p>
                    <p class="text-xs text-dark-500 mt-0.5">Transaksi terjamin keamanan</p>
                </div>
            </div>
            <div class="card p-6 flex items-center gap-4 animate-fade-in-up border border-dark-100" style="animation-delay: 0.1s;">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <div>
                    <p class="font-semibold text-dark-900 text-sm">Proses Cepat</p>
                    <p class="text-xs text-dark-500 mt-0.5">Checkout dalam hitungan menit</p>
                </div>
            </div>
            <div class="card p-6 flex items-center gap-4 animate-fade-in-up border border-dark-100" style="animation-delay: 0.2s;">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                </div>
                <div>
                    <p class="font-semibold text-dark-900 text-sm">Mulai Berjualan</p>
                    <p class="text-xs text-dark-500 mt-0.5">Buka toko gratis, langsung jualan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Strip -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-500 via-primary-600 to-secondary-500 p-5 sm:p-6 shadow-lg shadow-primary-500/20 animate-fade-in-up">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-10 w-24 h-24 bg-white/10 rounded-full blur-xl translate-y-1/2"></div>
            <div class="relative flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-lg font-display">Diskon 20% untuk pengguna baru</p>
                        <p class="text-white/80 text-sm">Gunakan kode <span class="font-bold text-white bg-white/20 px-2 py-0.5 rounded">NEWBIE20</span> di checkout</p>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="shrink-0 inline-flex items-center justify-center gap-2 bg-white text-primary-600 font-bold px-6 py-2.5 rounded-xl hover:bg-primary-50 transition-all duration-200 active:scale-95 shadow-md">
                    Belanja Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Flash Sale -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="card border border-red-100 overflow-hidden animate-fade-in-up">
            <div class="bg-gradient-to-r from-red-500 via-red-500 to-rose-500 px-5 py-4 sm:px-6 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-lg font-display">Flash Sale</p>
                            <p class="text-white/80 text-sm">Berakhir dalam</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2" x-data="flashSale()" x-init="start()">
                        <div class="w-12 h-12 bg-white rounded-xl flex flex-col items-center justify-center shadow-md">
                            <span x-text="hours" class="text-red-500 font-bold text-lg leading-none">00</span>
                            <span class="text-[10px] text-dark-500">Jam</span>
                        </div>
                        <span class="text-white font-bold text-xl">:</span>
                        <div class="w-12 h-12 bg-white rounded-xl flex flex-col items-center justify-center shadow-md">
                            <span x-text="minutes" class="text-red-500 font-bold text-lg leading-none">00</span>
                            <span class="text-[10px] text-dark-500">Menit</span>
                        </div>
                        <span class="text-white font-bold text-xl">:</span>
                        <div class="w-12 h-12 bg-white rounded-xl flex flex-col items-center justify-center shadow-md">
                            <span x-text="seconds" class="text-red-500 font-bold text-lg leading-none">00</span>
                            <span class="text-[10px] text-dark-500">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 sm:p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @forelse ($products->take(5) as $product)
                        @php
                            $discount = rand(15, 35);
                            $salePrice = $product->price * (1 - $discount / 100);
                        @endphp
                        <a href="{{ route('products.show', $product) }}" class="group cursor-pointer">
                            <div class="aspect-square bg-gradient-to-br from-red-50 to-rose-100 rounded-2xl flex items-center justify-center relative mb-3 overflow-hidden group-hover:from-red-100 group-hover:to-rose-200 transition-all duration-300">
                                @if ($product->first_image)
                                    <img src="{{ Storage::url($product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                @endif
                                <span class="absolute top-2 left-2 badge bg-red-500 text-white text-[10px]">-{{ $discount }}%</span>
                            </div>
                            <p class="text-sm text-dark-800 font-medium line-clamp-2 group-hover:text-red-500 transition-colors">{{ $product->name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-red-500 font-bold text-base font-display">Rp {{ number_format($salePrice, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-xs text-dark-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-2 w-full bg-dark-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-red-400 to-red-500 h-1.5 rounded-full" style="width: {{ rand(40, 90) }}%"></div>
                            </div>
                            <p class="text-[10px] text-dark-500 mt-1">{{ rand(5, 50) }} terjual</p>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-8 text-dark-400">
                            <p>Belum ada flash sale tersedia.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-5 text-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 text-red-500 hover:text-red-600 font-semibold text-sm transition-colors">
                        Lihat Semua Flash Sale
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        function flashSale() {
            return {
                hours: '00',
                minutes: '00',
                seconds: '00',
                start() {
                    const end = new Date();
                    end.setHours(23, 59, 59, 999);
                    const update = () => {
                        const now = new Date();
                        let diff = end - now;
                        if (diff < 0) diff = 0;
                        const h = Math.floor(diff / 1000 / 60 / 60);
                        const m = Math.floor((diff / 1000 / 60) % 60);
                        const s = Math.floor((diff / 1000) % 60);
                        this.hours = String(h).padStart(2, '0');
                        this.minutes = String(m).padStart(2, '0');
                        this.seconds = String(s).padStart(2, '0');
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }
    </script>

    <!-- Categories -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 bg-gradient-to-b from-primary-50/70 via-primary-50/30 to-transparent rounded-3xl">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">Kategori</span>
                <h2 class="text-2xl font-bold font-display text-dark-900 mt-1">Kategori Populer</h2>
            </div>
            <a href="{{ route('categories.index') }}" class="link-arrow">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="card card-hover p-5 text-center group cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-3 group-hover:from-primary-400 group-hover:to-primary-600 transition-all duration-300">
                        <span class="text-2xl">{{ $category->icon ?? '📦' }}</span>
                    </div>
                    <p class="text-sm font-medium text-dark-700 group-hover:text-primary-600 transition-colors">{{ $category->name }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Products -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">Best Seller</span>
                <h2 class="text-2xl font-bold font-display text-dark-900 mt-1">Produk Terlaris</h2>
                <p class="text-sm text-dark-500 mt-1">Produk paling diminati minggu ini</p>
            </div>
            <a href="{{ route('products.index') }}" class="link-arrow">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="card card-hover overflow-hidden group cursor-pointer">
                    <div class="aspect-square bg-gradient-to-br from-dark-100 to-dark-200 group-hover:from-primary-50 group-hover:to-primary-100 transition-all duration-300 flex items-center justify-center relative">
                        @if ($product->first_image)
                            <img src="{{ Storage::url($product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-dark-300 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        @endif
                        @if ($product->total_sold > 100)
                            <span class="absolute top-3 left-3 badge-danger">Terlaris</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-dark-800 font-medium line-clamp-2">{{ $product->name }}</p>
                        <p class="text-primary-600 font-bold text-base mt-1.5 font-display">{{ $product->formatted_price }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                <span class="text-xs text-dark-400">{{ $product->rating ?? '0.0' }}</span>
                            </div>
                            <span class="text-xs text-dark-400">{{ $product->sellerProfile?->city }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-dark-400">
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- New Products -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 bg-gradient-to-b from-blue-50/60 via-blue-50/20 to-transparent rounded-3xl">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">Baru Arrived</span>
                <h2 class="text-2xl font-bold font-display text-dark-900 mt-1">Produk Terbaru</h2>
                <p class="text-sm text-dark-500 mt-1">Baru saja ditambahkan oleh seller</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="link-arrow">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse ($newProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="card card-hover overflow-hidden group cursor-pointer">
                    <div class="aspect-square bg-gradient-to-br from-dark-100 to-dark-200 group-hover:from-primary-50 group-hover:to-primary-100 transition-all duration-300 flex items-center justify-center relative">
                        @if ($product->first_image)
                            <img src="{{ Storage::url($product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-dark-300 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        @endif
                        <span class="absolute top-3 left-3 badge bg-green-100 text-green-700 text-[9px]">Baru</span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-dark-800 font-medium line-clamp-2">{{ $product->name }}</p>
                        <p class="text-primary-600 font-bold text-base mt-1.5 font-display">{{ $product->formatted_price }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                <span class="text-xs text-dark-400">{{ $product->rating ?? '0.0' }}</span>
                            </div>
                            <span class="text-xs text-dark-400">{{ $product->sellerProfile?->city }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-dark-400">
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Popular Stores -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">Toko Pilihan</span>
                <h2 class="text-2xl font-bold font-display text-dark-900 mt-1">Toko Terpopuler</h2>
                <p class="text-sm text-dark-500 mt-1">Toko dengan produk terbanyak</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse ($popularStores as $store)
                <a href="{{ route('stores.show', $store->store_slug) }}" class="card card-hover p-5 text-center group cursor-pointer">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 group-hover:from-primary-400 group-hover:to-primary-600 transition-all duration-300 overflow-hidden flex items-center justify-center mx-auto mb-3">
                        @if ($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl font-bold text-primary-600 group-hover:text-white transition-colors">{{ strtoupper(substr($store->store_name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-dark-700 group-hover:text-primary-600 transition-colors line-clamp-1">{{ $store->store_name }}</p>
                    <p class="text-xs text-dark-400 mt-0.5">{{ $store->city }}</p>
                    <p class="text-xs text-dark-500 mt-1">{{ $store->active_products }} produk</p>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-dark-400">
                    <p>Belum ada toko tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Stats Banner -->
    <section class="relative overflow-hidden bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 text-white py-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-500/10 rounded-full blur-2xl"></div>
        <div class="absolute inset-0 bg-grid opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Tokoku dalam Angka</span>
                <h2 class="text-2xl sm:text-3xl font-bold font-display mt-2">Dipercaya Ribuan Pengguna</h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center animate-fade-in-up">
                    <p class="text-3xl lg:text-4xl font-bold font-display text-primary-400">10K+</p>
                    <p class="text-sm text-dark-400 mt-1">Pembeli Aktif</p>
                </div>
                <div class="text-center animate-fade-in-up" style="animation-delay: 0.1s;">
                    <p class="text-3xl lg:text-4xl font-bold font-display text-secondary-400">500+</p>
                    <p class="text-sm text-dark-400 mt-1">Seller Terdaftar</p>
                </div>
                <div class="text-center animate-fade-in-up" style="animation-delay: 0.2s;">
                    <p class="text-3xl lg:text-4xl font-bold font-display text-blue-400">50K+</p>
                    <p class="text-sm text-dark-400 mt-1">Produk Tersedia</p>
                </div>
                <div class="text-center animate-fade-in-up" style="animation-delay: 0.3s;">
                    <p class="text-3xl lg:text-4xl font-bold font-display text-purple-400">99%</p>
                    <p class="text-sm text-dark-400 mt-1">Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why TokoKu -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gradient-to-b from-secondary-50/50 via-transparent to-primary-50/40 rounded-3xl">
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold font-display text-dark-900 mb-3">Mengapa TokoKu?</h2>
            <p class="text-dark-500 max-w-xl mx-auto">Kami memberikan pengalaman belanja dan berjualan terbaik untuk Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card p-8 text-center group animate-fade-in-up">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mx-auto mb-5 shadow-glow group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-lg font-semibold font-display text-dark-900 mb-2">Pembayaran Aman</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Sistem pembayaran terenkripsi dengan proteksi penuh untuk setiap transaksi.</p>
            </div>
            <div class="card p-8 text-center group animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center mx-auto mb-5 shadow-sm group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-lg font-semibold font-display text-dark-900 mb-2">Pengiriman Cepat</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Integrasi dengan kurir terpercaya untuk pengiriman ke seluruh Indonesia.</p>
            </div>
            <div class="card p-8 text-center group animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-5 shadow-sm group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <h3 class="text-lg font-semibold font-display text-dark-900 mb-2">Dukungan 24/7</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Tim support siap membantu Anda kapan saja melalui berbagai channel.</p>
            </div>
        </div>
    </section>

    <!-- Seller CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900 p-8 sm:p-12 text-white shadow-card">
            <div class="absolute top-0 right-0 w-72 h-72 bg-primary-500/15 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 w-48 h-48 bg-secondary-500/10 rounded-full blur-2xl"></div>
            <div class="absolute inset-0 bg-grid opacity-5"></div>
            <div class="relative flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="max-w-xl text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold font-display mb-3">Punya Produk untuk Dijual?</h2>
                    <p class="text-dark-300 text-base sm:text-lg leading-relaxed mb-6">Buka toko gratis di TokoKu hari ini. Jangkau ribuan pembeli tanpa biaya awal. Proses pendaftaran cepat dan mudah!</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        @auth
                            @if (Auth::user()->isBuyer())
                                <a href="{{ route('become-seller') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold px-7 py-3.5 rounded-xl hover:from-primary-400 hover:to-primary-500 transition-all duration-300 active:scale-95 shadow-glow">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    Mulai Berjualan
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold px-7 py-3.5 rounded-xl hover:from-primary-400 hover:to-primary-500 transition-all duration-300 active:scale-95 shadow-glow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                Mulai Berjualan
                            </a>
                        @endauth
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white font-semibold px-7 py-3.5 rounded-xl hover:bg-white/20 transition-all duration-300 active:scale-95">
                            Jelajahi Produk
                        </a>
                    </div>
                </div>
                <div class="hidden lg:flex shrink-0">
                    <div class="w-32 h-32 rounded-3xl bg-white/15 backdrop-blur-sm flex items-center justify-center animate-float">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <span class="section-label !text-primary-600 !pb-0">Cara Kerja</span>
            <h2 class="text-2xl sm:text-3xl font-bold font-display text-dark-900 mb-3">Belanja dalam 3 Langkah Mudah</h2>
            <p class="text-dark-500 max-w-xl mx-auto">Proses simpel dari pilih produk hingga sampai ke rumah Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
            <!-- Connection line (desktop) -->
            <div class="hidden md:block absolute top-12 left-[16.66%] right-[16.66%] h-0.5 bg-gradient-to-r from-primary-200 via-primary-300 to-primary-200"></div>

            <div class="step-card text-center group animate-fade-in-up">
                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mx-auto mb-4 shadow-glow text-white font-bold text-lg z-10 group-hover:scale-110 transition-transform">1</div>
                <h3 class="text-base font-semibold font-display text-dark-900 mb-2">Pilih Produk</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Jelajahi ribuan produk dari berbagai toko terpercaya di TokoKu.</p>
            </div>
            <div class="step-card text-center group animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center mx-auto mb-4 shadow-sm text-white font-bold text-lg z-10 group-hover:scale-110 transition-transform">2</div>
                <h3 class="text-base font-semibold font-display text-dark-900 mb-2">Checkout Aman</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Pembayaran terjamin dengan berbagai metode pembayaran populer.</p>
            </div>
            <div class="step-card text-center group animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-4 shadow-sm text-white font-bold text-lg z-10 group-hover:scale-110 transition-transform">3</div>
                <h3 class="text-base font-semibold font-display text-dark-900 mb-2">Terima Pesanan</h3>
                <p class="text-sm text-dark-500 leading-relaxed">Produk dikirim cepat ke alamat Anda dengan kurir terpercaya.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-dark-50 py-16 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-secondary-500/5 rounded-full blur-2xl"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="section-label !text-primary-600 !pb-0">Testimoni</span>
                <h2 class="text-2xl sm:text-3xl font-bold font-display text-dark-900 mb-3">Apa Kata Pengguna TokoKu?</h2>
                <p class="text-dark-500 max-w-xl mx-auto">Ribuan pembeli dan penjual sudah merasakan pengalaman terbaik di TokoKu.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card p-6 animate-fade-in-up">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-sm text-dark-600 leading-relaxed mb-5">"Belanja di TokoKu sangat enak. Produknya beragam, harganya bersaing, dan pengirimannya cepat. Sudah langganan beli di sini!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">A</div>
                        <div>
                            <p class="text-sm font-semibold text-dark-900">Andi Pratama</p>
                            <p class="text-xs text-dark-400">Pembeli · Bandung</p>
                        </div>
                    </div>
                </div>
                <div class="card p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-sm text-dark-600 leading-relaxed mb-5">"Sebagai seller, TokoKu bantu saya berkembang. Dashboardnya mudah dipakai, dan pembeli terus bertambah tiap bulan."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white font-semibold">R</div>
                        <div>
                            <p class="text-sm font-semibold text-dark-900">Rina Wijaya</p>
                            <p class="text-xs text-dark-400">Seller · Jakarta</p>
                        </div>
                    </div>
                </div>
                <div class="card p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-sm text-dark-600 leading-relaxed mb-5">"Awalnya ragu jualan online, tapi TokoKu bikin semuanya simpel. Verifikasi cepat, dan fiturnya lengkap banget!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">B</div>
                        <div>
                            <p class="text-sm font-semibold text-dark-900">Budi Santoso</p>
                            <p class="text-xs text-dark-400">Seller · Surabaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <span class="section-label !text-primary-600 !pb-0">FAQ</span>
            <h2 class="text-2xl sm:text-3xl font-bold font-display text-dark-900 mb-3">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-dark-500 max-w-xl mx-auto">Punya pertanyaan? Mungkin jawabannya sudah ada di sini.</p>
        </div>
        <div class="max-w-3xl mx-auto space-y-3" x-data="{ open: 0 }">
            @foreach ([
                ['Bagaimana cara mulai belanja di TokoKu?', 'Cukup buat akun, jelajahi katalog produk, pilih produk yang diinginkan, lalu checkout. Pembayaran bisa dilakukan dengan berbagai metode populer.'],
                ['Apakah saya bisa berjualan tanpa biaya?', 'Ya! Mendaftar sebagai seller di TokoKu gratis. Tidak ada biaya pendaftaran atau langganan. Anda hanya perlu verifikasi identitas untuk mulai berjualan.'],
                ['Berapa lama proses pengiriman?', 'Pengiriman biasanya memakan waktu 1-3 hari kerja untuk wilayah Jabodetabek dan 2-5 hari kerja untuk wilayah lainnya, tergantung kurir yang dipilih.'],
                ['Bagaimana jika produk yang diterima rusak?', 'Anda bisa mengajukan komplain dalam 24 jam setelah menerima pesanan. Tim kami akan membantu proses pengembalian atau penggantian produk.'],
                ['Apakah data pribadi saya aman?', 'Tentu. TokoKu menggunakan enkripsi tingkat bank untuk melindungi data Anda. Kami tidak akan membagikan data pribadi Anda ke pihak ketiga tanpa izin.'],
            ] as $i => $faq)
                <div class="card overflow-hidden transition-all duration-200" :class="open === {{ $i }} ? 'ring-2 ring-primary-300' : ''">
                    <button @click="open = open === {{ $i }} ? -1 : {{ $i }}" class="w-full flex items-center justify-between gap-4 p-5 text-left">
                        <span class="text-sm font-semibold text-dark-900">{{ $faq[0] }}</span>
                        <svg class="w-5 h-5 text-primary-500 shrink-0 transition-transform duration-300" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak style="display: none;">
                        <p class="px-5 pb-5 text-sm text-dark-500 leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Newsletter -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-8 sm:p-12 text-white shadow-lg shadow-primary-500/20">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-10 w-48 h-48 bg-white/10 rounded-full blur-2xl translate-y-1/2"></div>
            <div class="relative flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="max-w-xl text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold font-display mb-3">Dapatkan Promo & Update Terbaru</h2>
                    <p class="text-white/80 text-base leading-relaxed">Langganan newsletter kami dan dapatkan info diskon, produk baru, dan tips berjualan langsung ke email Anda.</p>
                </div>
                <form class="w-full max-w-md flex flex-col sm:flex-row gap-3" onsubmit="event.preventDefault(); alert('Terima kasih sudah berlangganan newsletter TokoKu!');">
                    <input type="email" required placeholder="Masukkan email Anda" class="flex-1 bg-white/20 border border-white/30 text-white placeholder-white/70 rounded-xl px-5 py-3.5 outline-none focus:bg-white/30 focus:border-white transition-all">
                    <button type="submit" class="shrink-0 bg-white text-primary-600 font-bold px-6 py-3.5 rounded-xl hover:bg-primary-50 transition-all active:scale-95 shadow-md">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Payment & Shipping Partners -->
    <section class="bg-white border-y border-dark-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <p class="text-sm font-semibold text-dark-500 uppercase tracking-wider">Didukung oleh Metode Pembayaran & Kurir Terpercaya</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4 items-center justify-items-center opacity-80 hover:opacity-100 transition-opacity duration-300">
                <!-- Payment methods -->
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>Transfer Bank</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>GoPay</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>OVO</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>DANA</span>
                </div>
                <!-- Shipping partners -->
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>JNE</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>J&T</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>SiCepat</span>
                </div>
                <div class="flex items-center justify-center px-4 py-2 bg-dark-50 rounded-xl border border-dark-100 w-full h-12 text-sm font-semibold text-dark-700">
                    <span>GoSend</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Top -->
    <button x-data="{ visible: false }" @scroll.window="visible = window.scrollY > 400" x-show="visible" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="fixed bottom-20 sm:bottom-6 right-6 z-50 w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-full shadow-lg shadow-primary-500/30 flex items-center justify-center transition-all hover:scale-110 active:scale-95" aria-label="Back to top" style="display: none;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
    </button>

</x-app-layout>
