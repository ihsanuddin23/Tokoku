<x-dashboard-layout>
    <x-slot name="sidebarTitle">Admin Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Manajemen User
        </a>
        <a href="{{ route('admin.verifications.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Verifikasi Seller
        </a>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            Semua Pesanan
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            Kategori
        </a>
        <a href="{{ route('admin.banners.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Banner
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

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Semua Produk</h1>
            <p class="text-sm text-dark-500 mt-0.5">{{ $products->total() }} produk ditemukan</p>
        </div>
        <a href="{{ route('admin.products.export-csv') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Export CSV
        </a>
    </div>

    @if (session('status'))
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('status') }}
        </div>
    @endif

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.products.index') }}" class="card p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="text-xs font-medium text-dark-600 mb-1 block">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." class="input-modern text-sm w-full">
        </div>
        <div class="min-w-[140px]">
            <label class="text-xs font-medium text-dark-600 mb-1 block">Status</label>
            <select name="status" class="input-modern text-sm w-full">
                <option value="">Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
        </div>
        <div class="min-w-[160px]">
            <label class="text-xs font-medium text-dark-600 mb-1 block">Kategori</label>
            <select name="category" class="input-modern text-sm w-full">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary text-sm">Filter</button>
        @if (request()->hasAny(['search','status','category']))
            <a href="{{ route('admin.products.index') }}" class="btn-secondary text-sm">Reset</a>
        @endif
    </form>

    <!-- Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-dark-50 border-b border-dark-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Produk</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Toko</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Kategori</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Harga</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Stok</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Status</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-dark-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    @forelse ($products as $product)
                        <tr class="hover:bg-dark-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-dark-100 overflow-hidden shrink-0">
                                        @if ($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-dark-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('products.show', $product) }}" target="_blank" class="font-medium text-dark-900 hover:text-primary-600 transition-colors line-clamp-1">{{ $product->name }}</a>
                                        <p class="text-xs text-dark-400 mt-0.5">{{ $product->total_sold }} terjual
                                            @if ($product->review_count > 0)
                                                Â· â˜… {{ number_format($product->rating, 1) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('stores.show', $product->sellerProfile?->store_slug) }}" target="_blank" class="text-xs text-dark-600 hover:text-primary-600">
                                    {{ $product->sellerProfile?->store_name ?? '-' }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-xs text-dark-500">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-5 py-4 text-right font-medium text-dark-900">{{ $product->formatted_price }}</td>
                            <td class="px-5 py-4 text-right text-dark-600">{{ $product->stock }}</td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusClass = match($product->status) {
                                        'active'   => 'bg-green-100 text-green-700',
                                        'inactive' => 'bg-red-100 text-red-700',
                                        default    => 'bg-dark-100 text-dark-600',
                                    };
                                    $statusLabel = match($product->status) {
                                        'active'   => 'Aktif',
                                        'inactive' => 'Nonaktif',
                                        default    => 'Draft',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} text-[10px]">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs px-2.5 py-1 rounded-lg {{ $product->status === 'active' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }} transition-colors font-medium">
                                            {{ $product->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs px-2.5 py-1 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center text-sm text-dark-400">Tidak ada produk ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="px-5 py-4 border-t border-dark-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
