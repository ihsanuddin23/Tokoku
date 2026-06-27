<x-dashboard-layout>
    <x-slot name="sidebarTitle">Seller Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('seller.products.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('seller.orders.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Pesanan
        </a>
        <a href="#" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('seller.store.edit') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
            Pengaturan Toko
        </a>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-dark-800 via-dark-900 to-dark-950 p-6 sm:p-8 mb-8 animate-fade-in-up">
        <div class="absolute inset-0 bg-grid opacity-5"></div>
        <div class="absolute -top-8 -right-8 w-48 h-48 bg-primary-500/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-secondary-500/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-primary-400 text-xs font-medium mb-2">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Toko Aktif
                </div>
                <h2 class="text-2xl font-bold font-display text-white mb-1">Halo, {{ Auth::user()->name }}! 🛒</h2>
                <p class="text-dark-400 text-sm">Pantau performa toko dan kelola produk Anda di sini.</p>
            </div>
            <div class="flex items-center gap-3 bg-white/5 backdrop-blur-sm rounded-2xl px-4 py-3 shrink-0">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-glow">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-white font-semibold text-sm">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-primary-300 bg-primary-500/15 px-2 py-0.5 rounded-full mt-0.5">Seller</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-glow shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="badge-success text-[10px]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    12%
                </span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Penjualan Hari Ini</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="badge-success text-[10px]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    8%
                </span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Penjualan Bulan Ini</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <span class="badge-warning text-[10px]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    3%
                </span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Total Order</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </div>
                <span class="badge-success text-[10px]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    Baru
                </span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Produk Aktif</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $activeProducts }}</p>
        </div>
    </div>

    <!-- Chart + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <!-- Chart Placeholder -->
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold font-display text-dark-900">Grafik Penjualan</h2>
                    <p class="text-xs text-dark-500 mt-0.5">7 hari terakhir</p>
                </div>
                <div class="flex gap-2">
                    <button class="badge-primary text-[10px] cursor-pointer">Mingguan</button>
                    <button class="badge bg-dark-100 text-dark-500 text-[10px] cursor-pointer">Bulanan</button>
                </div>
            </div>
            <div class="flex items-end justify-between gap-3 h-48 pt-4">
                @foreach (['Sen' => 45, 'Sel' => 62, 'Rab' => 38, 'Kam' => 71, 'Jum' => 85, 'Sab' => 55, 'Min' => 30] as $day => $height)
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all duration-300 group-hover:from-primary-600 group-hover:to-primary-400 group-hover:scale-y-105 origin-bottom" style="height: {{ $height }}%"></div>
                        <span class="text-[10px] text-dark-400 font-medium">{{ $day }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('seller.products.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Tambah Produk</p>
                        <p class="text-xs text-dark-500">Unggah produk baru</p>
                    </div>
                </a>
                <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Lihat Pesanan</p>
                        <p class="text-xs text-dark-500">Kelola order masuk</p>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Laporan Penjualan</p>
                        <p class="text-xs text-dark-500">Analisis performa toko</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders + Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold font-display text-dark-900">Order Terbaru</h2>
                <a href="{{ route('seller.orders.index') }}" class="link-arrow">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
            </div>
            <div class="text-center py-12">
                @forelse ($recentOrders as $item)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-dark-50/50 hover:bg-dark-50 transition-colors text-left">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-700 truncate">{{ $item->product_name }}</p>
                            <p class="text-xs text-dark-400">{{ $item->order->user->name }} · {{ $item->status_label }}</p>
                        </div>
                        <span class="text-xs font-semibold text-dark-500">{{ $item->formatted_subtotal }}</span>
                    </div>
                @empty
                    <div class="w-16 h-16 rounded-2xl bg-dark-50 flex items-center justify-center mx-auto mb-4 animate-bounce-in">
                        <svg class="w-8 h-8 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-sm text-dark-400 mb-1">Belum ada order masuk</p>
                    <p class="text-xs text-dark-400">Order dari pembeli akan muncul di sini</p>
                @endforelse
            </div>
        </div>

        <!-- Top Products -->
        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Produk Terlaris</h2>
            <div class="space-y-3">
                @forelse ($topProducts as $product)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-dark-50/50 hover:bg-dark-50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-dark-200 to-dark-300 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-700 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-dark-400">{{ $product->total_sold }} terjual</p>
                        </div>
                        <span class="text-xs font-semibold text-dark-500">{{ $product->formatted_price }}</span>
                    </div>
                @empty
                    <p class="text-sm text-dark-400 text-center py-4">Belum ada produk</p>
                @endforelse
            </div>
            <a href="{{ route('seller.products.index') }}" class="mt-4 link-arrow text-xs">
                Kelola Produk
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </div>
    </div>
</x-dashboard-layout>
