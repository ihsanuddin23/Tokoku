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

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Voucher Toko</h1>
            <p class="text-sm text-dark-400 mt-1">Kelola voucher promo untuk produk toko Anda</p>
        </div>
        <a href="{{ route('seller.vouchers.create') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Voucher
        </a>
    </div>

    @if (session('status'))
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            @if (session('status') === 'voucher-created') Voucher berhasil dibuat.
            @elseif (session('status') === 'voucher-updated') Voucher berhasil diperbarui.
            @elseif (session('status') === 'voucher-deleted') Voucher berhasil dihapus.
            @endif
        </div>
    @endif

    @if (session('info'))
        <div class="glass border-amber-200/50 text-amber-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ session('info') }}
        </div>
    @endif

    <div class="mb-4 flex gap-2">
        <a href="{{ route('seller.vouchers.index') }}" class="btn-secondary text-sm @if(!request('status')) btn-primary @endif">Semua</a>
        <a href="{{ route('seller.vouchers.index', ['status' => 'active']) }}" class="btn-secondary text-sm @if(request('status') === 'active') btn-primary @endif">Aktif</a>
        <a href="{{ route('seller.vouchers.index', ['status' => 'scheduled']) }}" class="btn-secondary text-sm @if(request('status') === 'scheduled') btn-primary @endif">Terjadwal</a>
        <a href="{{ route('seller.vouchers.index', ['status' => 'expired']) }}" class="btn-secondary text-sm @if(request('status') === 'expired') btn-primary @endif">Kedaluwarsa</a>
        <a href="{{ route('seller.vouchers.index', ['status' => 'inactive']) }}" class="btn-secondary text-sm @if(request('status') === 'inactive') btn-primary @endif">Nonaktif</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-dark-100 bg-dark-50/50">
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Kode</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Nama</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Tipe</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Nilai</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Min. Belanja</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Penggunaan</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Periode</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Status</th>
                    <th class="text-right px-4 py-3 font-semibold text-dark-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vouchers as $voucher)
                    @php
                        $isExpired = $voucher->expires_at < now();
                        $isScheduled = $voucher->starts_at > now();
                        $isActive = $voucher->is_active && !$isExpired && !$isScheduled;
                    @endphp
                    <tr class="border-b border-dark-50 hover:bg-dark-50/30 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs font-bold text-primary-600">{{ $voucher->code }}</td>
                        <td class="px-4 py-3 text-dark-900">{{ $voucher->name }}</td>
                        <td class="px-4 py-3">
                            <span class="badge bg-dark-100 text-dark-600 text-[10px]">{{ $voucher->type_label }}</span>
                        </td>
                        <td class="px-4 py-3 text-dark-700">
                            @if ($voucher->type === 'percentage')
                                {{ $voucher->value }}%
                            @elseif ($voucher->type === 'fixed')
                                Rp {{ number_format((float)$voucher->value, 0, ',', '.') }}
                            @else
                                Gratis Ongkir
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-dark-600">Rp {{ number_format((float)$voucher->min_purchase, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-xs text-dark-600">{{ $voucher->used_count }}{{ $voucher->usage_limit ? '/' . $voucher->usage_limit : '' }}</td>
                        <td class="px-4 py-3 text-xs text-dark-400">{{ $voucher->starts_at->format('d M') }} - {{ $voucher->expires_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($isActive)
                                <span class="badge bg-green-100 text-green-700 text-[10px]">Aktif</span>
                            @elseif ($isScheduled)
                                <span class="badge bg-blue-100 text-blue-700 text-[10px]">Terjadwal</span>
                            @elseif ($isExpired)
                                <span class="badge bg-red-100 text-red-700 text-[10px]">Kedaluwarsa</span>
                            @else
                                <span class="badge bg-dark-100 text-dark-500 text-[10px]">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('seller.vouchers.edit', $voucher) }}" class="text-blue-600 hover:text-blue-700 text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('seller.vouchers.destroy', $voucher) }}" onsubmit="return confirm('Hapus voucher {{ $voucher->code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-sm text-dark-400">Belum ada voucher. <a href="{{ route('seller.vouchers.create') }}" class="text-primary-600 font-medium hover:underline">Buat voucher pertama Anda</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($vouchers->hasPages())
        <div class="flex justify-center mt-6">
            {{ $vouchers->links() }}
        </div>
    @endif
</x-dashboard-layout>
