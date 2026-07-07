<x-dashboard-layout>
    <x-slot name="sidebarTitle">Admin Dashboard</x-slot>
    <x-slot name="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">Dashboard</a>
        <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link sidebar-link-active">Voucher</a>
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-dark-500 mb-1">
            <a href="{{ route('admin.vouchers.index') }}" class="hover:text-primary-600 transition-colors">Voucher</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-900 font-medium">Tambah Voucher</span>
        </div>
        <h1 class="text-2xl font-bold font-display text-dark-900">Tambah Voucher</h1>
    </div>

    <form method="POST" action="{{ route('admin.vouchers.store') }}" class="card p-6 max-w-2xl">
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
            <a href="{{ route('admin.vouchers.index') }}" class="btn-secondary text-sm">Batal</a>
        </div>
    </form>
</x-dashboard-layout>
