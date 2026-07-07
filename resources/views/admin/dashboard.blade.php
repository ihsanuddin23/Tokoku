<x-dashboard-layout>
    <x-slot name="sidebarTitle">Admin Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Manajemen User
        </a>
        <a href="{{ route('admin.verifications.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Verifikasi Seller
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            Kategori
        </a>
        <a href="{{ route('admin.banners.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Banner
        </a>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            Semua Pesanan
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-6 sm:p-8 mb-8 animate-fade-in-up">
        <div class="absolute inset-0 bg-grid opacity-10"></div>
        <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-secondary-400/20 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-primary-100 text-xs font-medium mb-2">
                    <span class="w-2 h-2 bg-secondary-300 rounded-full animate-pulse"></span>
                    Admin Control Panel
                </div>
                <h2 class="text-2xl font-bold font-display text-white mb-1">Selamat datang, {{ Auth::user()->name }}! ðŸ”</h2>
                <p class="text-primary-100 text-sm">Pantau seluruh aktivitas platform TokoKu di sini.</p>
            </div>
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3 shrink-0">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-white font-semibold text-sm">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-primary-100 bg-white/10 px-2 py-0.5 rounded-full mt-0.5">Admin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-glow shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <span class="text-[10px] text-dark-400 font-medium">Semua</span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Total User</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $totalUsers }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
                </div>
                <span class="text-[10px] text-dark-400 font-medium">Aktif</span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Seller Aktif</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $totalSellers }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <span class="text-[10px] text-dark-400 font-medium">Total</span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Total Transaksi</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-[10px] text-dark-400 font-medium">Total</span>
            </div>
            <p class="text-xs text-dark-500 font-medium">Total Revenue</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Chart + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <!-- Sales Chart -->
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold font-display text-dark-900">Tren Penjualan 30 Hari</h2>
                    <p class="text-xs text-dark-500 mt-0.5">Revenue & jumlah order</p>
                </div>
                <div class="flex items-center gap-3 text-[10px]">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-primary-500"></span> Revenue</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-secondary-400"></span> Order</span>
                </div>
            </div>
            <canvas id="salesChart" height="200"></canvas>
        </div>

        <!-- Quick Actions -->
        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.verifications.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Verifikasi Seller</p>
                        <p class="text-xs text-dark-500">Review pengajuan seller</p>
                    </div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Kelola User</p>
                        <p class="text-xs text-dark-500">Aktifkan/nonaktifkan akun</p>
                    </div>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Kelola Kategori</p>
                        <p class="text-xs text-dark-500">Atur kategori produk</p>
                    </div>
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-dark-50 hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-dark-900">Kelola Voucher</p>
                        <p class="text-xs text-dark-500">Atur voucher & kupon</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Order Status + Top Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Distribusi Status Order</h2>
            <div class="flex items-center gap-6">
                <canvas id="statusChart" width="200" height="200"></canvas>
                <div class="flex-1 space-y-2">
                    @php
                        $statusColors = [
                            'pending' => '#f59e0b',
                            'paid' => '#3b82f6',
                            'shipped' => '#8b5cf6',
                            'completed' => '#10b981',
                            'cancelled' => '#ef4444',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'paid' => 'Dibayar',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    @foreach ($orderStatusData as $status => $count)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full" style="background: {{ $statusColors[$status] ?? '#999' }}"></span>
                                <span class="text-dark-600">{{ $statusLabels[$status] ?? $status }}</span>
                            </div>
                            <span class="font-semibold text-dark-900">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Kategori Terlaris</h2>
            @forelse ($topCategories as $category)
                @php
                    $maxSold = $topCategories->first()->sold_count;
                    $percent = $maxSold > 0 ? ($category->sold_count / $maxSold) * 100 : 0;
                @endphp
                <div class="mb-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-dark-700">{{ $category->name }}</span>
                        <span class="text-xs text-dark-500">{{ $category->sold_count }} terjual</span>
                    </div>
                    <div class="h-2 rounded-full bg-dark-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary-400 to-primary-600 transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-dark-400 text-center py-4">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold font-display text-dark-900">User Terbaru</h2>
                @if ($pendingVerifications > 0)
                    <a href="{{ route('admin.verifications.index') }}" class="link-arrow">
                        {{ $pendingVerifications }} Pending
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                @endif
            </div>
            <div class="space-y-3">
                @forelse ($recentUsers as $user)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-dark-50/50 hover:bg-dark-50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center shrink-0 text-primary-700 font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-700 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-dark-400">{{ $user->email }} Â· {{ $user->role }}</p>
                        </div>
                        <span class="text-xs text-dark-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-dark-400 text-center py-4">Belum ada user</p>
                @endforelse
            </div>
        </div>

        <div class="card p-6">
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Transaksi Terbaru</h2>
            <div class="space-y-3">
                @forelse ($recentOrders as $order)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-dark-50/50 hover:bg-dark-50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark-700 truncate">{{ $order->order_number }}</p>
                            <p class="text-xs text-dark-400">{{ $order->user->name }} Â· {{ $order->status_label }}</p>
                        </div>
                        <span class="text-xs font-semibold text-dark-500">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-sm text-dark-400 text-center py-4">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        // Sales trend chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Revenue',
                        data: @json($chartRevenue),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.3,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Order',
                        data: @json($chartOrders),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        fill: false,
                        tension: 0.3,
                        yAxisID: 'y1',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.dataset.label === 'Revenue') {
                                    return 'Revenue: Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                                return 'Order: ' + ctx.parsed.y;
                            },
                        },
                    },
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 0, autoSkip: true, maxTicksLimit: 10 } },
                    y: { position: 'left', grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1) + 'M' : v >= 1000 ? (v/1000).toFixed(0) + 'k' : v) } },
                    y1: { position: 'right', grid: { display: false }, ticks: { font: { size: 10 } } },
                },
            },
        });

        // Order status doughnut chart
        @if (!empty($orderStatusData))
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusColors = @json($statusColors);
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(collect($orderStatusData)->keys()->map(fn($s) => $statusLabels[$s] ?? $s)->values()),
                    datasets: [{
                        data: @json(array_values($orderStatusData)),
                        backgroundColor: @json(collect($orderStatusData)->keys()->map(fn($s) => $statusColors[$s] ?? '#999')->values()),
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '65%',
                },
            });
        @endif
    </script>
</x-dashboard-layout>
