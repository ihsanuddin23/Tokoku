<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Dashboard</span>
        </div>

        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-8 sm:p-10 mb-8 animate-fade-in-up">
            <div class="absolute inset-0 bg-grid opacity-10"></div>
            <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-secondary-400/20 rounded-full blur-3xl"></div>
            <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-primary-100 text-sm mb-3">
                        <span class="w-2 h-2 bg-secondary-300 rounded-full animate-pulse"></span>
                        Selamat datang kembali
                    </div>
                    <h2 class="text-3xl font-bold font-display text-white mb-2">{{ Auth::user()->name }} 👋</h2>
                    <p class="text-primary-100 text-sm max-w-md">Kelola akun, pantau pesanan, dan nikmati pengalaman belanja terbaik di TokoKu.</p>
                </div>
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-4 shrink-0">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ Auth::user()->email }}</p>
                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-primary-100 bg-white/10 px-2 py-0.5 rounded-full mt-1 capitalize">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('products.index') }}" class="card card-hover p-5 group animate-fade-in-up">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-glow mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Belanja</p>
                <p class="text-xs text-dark-400 mt-0.5">Jelajahi produk</p>
            </a>
            <a href="{{ route('cart') }}" class="card card-hover p-5 group animate-fade-in-up" style="animation-delay: 0.05s;">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Keranjang</p>
                <p class="text-xs text-dark-400 mt-0.5">Lihat keranjang</p>
            </a>
            <a href="{{ route('orders.index') }}" class="card card-hover p-5 group animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Pesanan</p>
                <p class="text-xs text-dark-400 mt-0.5">Pantau status</p>
            </a>
            <a href="{{ route('profile.edit') }}" class="card card-hover p-5 group animate-fade-in-up" style="animation-delay: 0.15s;">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Profil</p>
                <p class="text-xs text-dark-400 mt-0.5">Edit profil</p>
            </a>
            <a href="{{ route('stores.followed') }}" class="card card-hover p-5 group animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Toko Diikuti</p>
                <p class="text-xs text-dark-400 mt-0.5">Toko favorit</p>
            </a>
            <a href="{{ route('messages.index') }}" class="card card-hover p-5 group animate-fade-in-up" style="animation-delay: 0.25s;">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
                <p class="text-sm font-semibold text-dark-900">Pesan</p>
                <p class="text-xs text-dark-400 mt-0.5">Chat dengan seller</p>
            </a>
        </div>

        <!-- Recent Orders + Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 card p-6 animate-fade-in-up">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-semibold font-display text-dark-900">Pesanan Terbaru</h3>
                        <p class="text-xs text-dark-500 mt-0.5">5 transaksi terakhir Anda</p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="link-arrow">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
                @forelse ($recentOrders as $order)
                    <div class="flex items-center gap-3 pb-3 {{ !$loop->last ? 'border-b border-dark-50' : '' }}">
                        <div class="w-10 h-10 rounded-lg bg-dark-50 overflow-hidden shrink-0">
                            @if ($order->items->first() && $order->items->first()->product && $order->items->first()->product->first_image)
                                <img src="{{ asset('storage/' . $order->items->first()->product->first_image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-900 truncate">{{ $order->order_number }}</p>
                            <p class="text-xs text-dark-400">{{ $order->created_at->format('d M Y') }} · {{ $order->items->count() }} item</p>
                        </div>
                        <span class="badge {{ $order->status_badge }} text-[9px]">{{ $order->status_label }}</span>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-16 h-16 rounded-2xl bg-dark-50 flex items-center justify-center mx-auto mb-4 animate-bounce-in">
                            <svg class="w-8 h-8 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                        <p class="text-sm text-dark-400 mb-1">Belum ada pesanan</p>
                        <p class="text-xs text-dark-400">Mulai belanja untuk melihat pesanan di sini</p>
                    </div>
                @endforelse
            </div>

            <!-- Activity Sidebar -->
            <div class="space-y-6">
                <!-- Stats Mini -->
                <div class="card p-5 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <h3 class="text-sm font-semibold font-display text-dark-900 mb-4">Statistik Belanja</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </div>
                                <span class="text-xs text-dark-500">Total Pesanan</span>
                            </div>
                            <span class="text-sm font-bold text-dark-900">{{ $totalOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="text-xs text-dark-500">Total Belanja</span>
                            </div>
                            <span class="text-sm font-bold text-dark-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-xs text-dark-500">Selesai</span>
                            </div>
                            <span class="text-sm font-bold text-dark-900">{{ $completedOrders }}</span>
                        </div>
                    </div>
                </div>

                <!-- Become Seller CTA -->
                @if (Auth::user()->role === 'buyer')
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-dark-800 to-dark-900 p-5 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary-500/20 rounded-full blur-2xl"></div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h4 class="text-sm font-semibold text-white mb-1">Mulai Berjualan</h4>
                        <p class="text-xs text-dark-400 mb-4 leading-relaxed">Jadilah seller dan jangkau ribuan pembeli di TokoKu.</p>
                        <a href="{{ route('become-seller') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-400 hover:text-primary-300 transition-colors">
                            Daftar Sekarang
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
