<x-dashboard-layout>
    <x-slot name="sidebarTitle">Seller Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link">
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
        <a href="{{ route('seller.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
        <a href="{{ route('seller.store.edit') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
            Pengaturan Toko
        </a>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold font-display text-dark-900">Pengaturan Toko</h1>
            <p class="text-sm text-dark-500 mt-1">Kelola informasi dan tampilan toko Anda</p>
        </div>

        @if (session('status') === 'store-updated')
            <div class="card p-4 mb-6 bg-green-50 border-green-200">
                <div class="flex items-center gap-2 text-sm text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Informasi toko berhasil diperbarui.
                </div>
            </div>
        @endif

        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Banner Upload -->
            <div class="card p-6">
                <h2 class="text-sm font-semibold text-dark-900 mb-4">Banner Toko</h2>
                <div class="relative rounded-2xl overflow-hidden h-40 bg-dark-50 mb-3">
                    @if ($store->banner)
                        <img src="{{ asset('storage/' . $store->banner) }}" alt="Banner" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-dark-300">
                            <span class="text-sm">Belum ada banner</span>
                        </div>
                    @endif
                </div>
                <label class="block">
                    <span class="text-xs text-dark-500">Upload Banner Baru</span>
                    <input type="file" name="banner" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-dark-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                </label>
            </div>

            <!-- Logo Upload -->
            <div class="card p-6">
                <h2 class="text-sm font-semibold text-dark-900 mb-4">Logo Toko</h2>
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-20 h-20 rounded-2xl bg-dark-50 overflow-hidden shrink-0">
                        @if ($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-dark-300">
                                <span class="text-2xl font-bold">{{ strtoupper(substr($store->store_name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block">
                            <span class="text-xs text-dark-500">Upload Logo Baru</span>
                            <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-dark-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            <div class="card p-6 space-y-4">
                <h2 class="text-sm font-semibold text-dark-900">Informasi Toko</h2>

                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Nama Toko</label>
                    <input type="text" name="store_name" value="{{ $store->store_name }}" required class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Kota</label>
                    <input type="text" name="city" value="{{ $store->city }}" required class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Deskripsi Toko</label>
                    <textarea name="description" rows="4" class="w-full bg-dark-50 border border-dark-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-primary-400 transition resize-none">{{ $store->description }}</textarea>
                </div>

                <div class="flex items-center gap-2 text-xs text-dark-400 pt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    <a href="{{ route('stores.show', $store->store_slug) }}" target="_blank" class="text-primary-600 hover:underline">Lihat halaman toko publik</a>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
