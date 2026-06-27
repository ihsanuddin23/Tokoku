<x-dashboard-layout>
    <x-slot name="sidebarTitle">Seller Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('seller.products.index') }}" class="sidebar-link sidebar-link-active">
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

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Produk Saya</h1>
            <p class="text-sm text-dark-500 mt-0.5">Kelola produk toko Anda</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Produk
        </a>
    </div>

    @if (session('status') === 'product-created')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Produk berhasil ditambahkan.
        </div>
    @elseif (session('status') === 'product-updated')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Produk berhasil diperbarui.
        </div>
    @elseif (session('status') === 'product-deleted')
        <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Produk berhasil dihapus.
        </div>
    @elseif (session('status') === 'bulk-stock-updated')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Stok {{ session('bulk_count') }} produk berhasil diperbarui.
        </div>
    @endif

    <!-- Filter Bar -->
    <div class="card p-4 mb-6">
        <form method="GET" action="{{ route('seller.products.index') }}" class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <div class="relative flex-1 w-full">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                    class="input-modern pl-10 py-2.5 text-sm">
            </div>
            <select name="category" class="input-modern cursor-pointer py-2.5 text-sm w-full sm:w-auto">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" class="input-modern cursor-pointer py-2.5 text-sm w-full sm:w-auto">
                <option value="">Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
            <select name="sort" class="input-modern cursor-pointer py-2.5 text-sm w-full sm:w-auto">
                <option value="newest" @selected(request('sort', 'newest') === 'newest')>Terbaru</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga Terendah</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga Tertinggi</option>
                <option value="stock_asc" @selected(request('sort') === 'stock_asc')>Stok Terendah</option>
                <option value="stock_desc" @selected(request('sort') === 'stock_desc')>Stok Tertinggi</option>
            </select>
            <button type="submit" class="btn-primary py-2.5 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter
            </button>
            @if (request()->hasAny(['search', 'category', 'status', 'sort']))
                <a href="{{ route('seller.products.index') }}" class="text-xs text-dark-500 hover:text-primary-600 transition-colors whitespace-nowrap">Reset</a>
            @endif
        </form>
    </div>

    <!-- Products Table -->
    <div class="card overflow-hidden">
        @if ($products->isEmpty())
            <div class="p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Produk</h2>
                <p class="text-sm text-dark-400 max-w-md mx-auto mb-6">Mulai tambahkan produk pertama Anda untuk dijual di TokoKu.</p>
                <a href="{{ route('seller.products.create') }}" class="btn-primary inline-flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Produk
                </a>
            </div>
        @else
          <form method="POST" action="{{ route('seller.products.bulk-stock') }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-dark-100 bg-dark-50/50">
                            <th class="text-left text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Produk</th>
                            <th class="text-left text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Kategori</th>
                            <th class="text-right text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Harga</th>
                            <th class="text-center text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Stok</th>
                            <th class="text-center text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Status</th>
                            <th class="text-right text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-50">
                        @foreach ($products as $product)
                            <tr class="hover:bg-dark-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-dark-100 flex items-center justify-center overflow-hidden shrink-0">
                                            @if ($product->first_image)
                                                <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-dark-900 truncate max-w-[200px]">{{ $product->name }}</p>
                                            <p class="text-xs text-dark-400">{{ $product->condition_label }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-dark-600">{{ $product->category->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-dark-900">{{ $product->formatted_price }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="number" name="stocks[{{ $product->id }}]" value="{{ $product->stock }}" min="0" class="w-20 text-center bg-dark-50 border border-dark-200 rounded-lg px-2 py-1.5 text-sm outline-none focus:border-primary-400">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($product->status === 'active')
                                        <span class="badge-success text-[10px]">Aktif</span>
                                    @elseif ($product->status === 'inactive')
                                        <span class="badge bg-dark-100 text-dark-500 text-[10px]">Nonaktif</span>
                                    @else
                                        <span class="badge bg-amber-100 text-amber-700 text-[10px]">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="p-2 rounded-lg text-dark-500 hover:bg-primary-50 hover:text-primary-600 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-dark-500 hover:bg-red-50 hover:text-red-600 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions Bar -->
            <div class="px-6 py-4 border-t border-dark-100 flex items-center justify-between gap-4 bg-dark-50/30">
                <p class="text-xs text-dark-500">Edit stok langsung di tabel, lalu klik simpan untuk update semua.</p>
                <button type="submit" class="btn-primary text-sm py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Stok Massal
                </button>
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-dark-100">
                    {{ $products->links() }}
                </div>
            @endif
          </form>
        @endif
    </div>
</x-dashboard-layout>
