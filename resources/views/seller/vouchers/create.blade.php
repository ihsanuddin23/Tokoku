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
        <a href="{{ route('seller.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('seller.vouchers.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
        <a href="{{ route('seller.store.edit') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 002 2h4a2 2 0 002-2" /></svg>
            Pengaturan Toko
        </a>
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-dark-500 mb-1">
            <a href="{{ route('seller.vouchers.index') }}" class="hover:text-primary-600 transition-colors">Voucher</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-900 font-medium">Tambah Voucher</span>
        </div>
        <h1 class="text-2xl font-bold font-display text-dark-900">Tambah Voucher</h1>
    </div>

    <form method="POST" action="{{ route('seller.vouchers.store') }}" class="card p-6 max-w-2xl">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Kode Voucher</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="HEMAT50" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all uppercase" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Nama Voucher</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Diskon Hemat 50%" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-dark-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="2" placeholder="Deskripsi singkat voucher..." class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Tipe Diskon</label>
                <select name="type" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                    <option value="percentage" @selected(old('type') === 'percentage')>Persentase (%)</option>
                    <option value="fixed" @selected(old('type') === 'fixed')>Nominal (Rp)</option>
                    <option value="free_shipping" @selected(old('type') === 'free_shipping')>Gratis Ongkir</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Nilai</label>
                <input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0" placeholder="50" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Min. Pembelian (Rp)</label>
                <input type="number" name="min_purchase" value="{{ old('min_purchase', 0) }}" step="0.01" min="0" placeholder="0" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Maks. Diskon (Rp)</label>
                <input type="number" name="max_discount" value="{{ old('max_discount') }}" step="0.01" min="0" placeholder="Kosongkan untuk tanpa batas" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Batas Penggunaan Total</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="Kosongkan untuk tanpa batas" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Batas per User</label>
                <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', 1) }}" min="1" placeholder="1" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Mulai Berlaku</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-dark-700 mb-2">Berakhir</label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-dark-300 text-primary-600 focus:ring-primary-500/20">
                <span class="text-sm text-dark-700">Aktifkan voucher</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary text-sm">Simpan Voucher</button>
            <a href="{{ route('seller.vouchers.index') }}" class="btn-secondary text-sm">Batal</a>
        </div>
    </form>
</x-dashboard-layout>
