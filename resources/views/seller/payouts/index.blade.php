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
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            Pesanan
        </a>
        <a href="{{ route('seller.store.edit') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8" /></svg>
            Toko
        </a>
        <a href="{{ route('seller.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('seller.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
        <a href="{{ route('seller.payouts.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Penarikan Dana
        </a>
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold font-display text-dark-900">Penarikan Dana</h1>
        <p class="text-sm text-dark-400 mt-1">Kelola pencairan pendapatan Anda</p>
    </div>

    @if (session('status') === 'payout-requested')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pengajuan penarikan berhasil dikirim. Dana akan diproses dalam 2-3 hari kerja.
        </div>
    @endif

    @if (session('info'))
        <div class="glass border-yellow-200/50 text-yellow-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ session('info') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="card p-5">
            <p class="text-xs text-dark-400 mb-1">Saldo Tersedia</p>
            <p class="text-2xl font-bold font-display text-green-600">Rp {{ number_format($pendingEarnings, 0, ',', '.') }}</p>
        </div>
        <div class="card p-5">
            <p class="text-xs text-dark-400 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold font-display text-dark-900">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</p>
        </div>
        <div class="card p-5">
            <p class="text-xs text-dark-400 mb-1">Sudah Ditarik</p>
            <p class="text-2xl font-bold font-display text-primary-600">Rp {{ number_format($totalPaidOut, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Request Payout -->
    @if ($pendingEarnings > 0)
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-semibold text-dark-900 mb-4">Ajukan Penarikan</h2>
            <form action="{{ route('seller.payouts.request') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-2">Nama Bank</label>
                        <input type="text" name="bank_name" placeholder="BCA / Mandiri / BNI..." class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-2">Nama Pemilik Rekening</label>
                        <input type="text" name="bank_account_name" placeholder="John Doe" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-700 mb-2">Nomor Rekening</label>
                        <input type="text" name="bank_account_number" placeholder="1234567890" class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-dark-500">Jumlah: <span class="font-bold text-dark-900">Rp {{ number_format($pendingEarnings, 0, ',', '.') }}</span></p>
                    <button type="submit" class="btn-primary text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" /></svg>
                        Tarik Dana
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- History -->
    <div class="card overflow-hidden">
        <div class="px-5 py-4 border-b border-dark-50">
            <h2 class="text-sm font-semibold text-dark-900">Riwayat Penarikan</h2>
        </div>
        @if ($payouts->isEmpty())
            <div class="p-12 text-center">
                <p class="text-sm text-dark-400">Belum ada riwayat penarikan.</p>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-dark-100 bg-dark-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-dark-700">No. Penarikan</th>
                        <th class="text-left px-4 py-3 font-semibold text-dark-700">Jumlah</th>
                        <th class="text-left px-4 py-3 font-semibold text-dark-700">Bank</th>
                        <th class="text-left px-4 py-3 font-semibold text-dark-700">Status</th>
                        <th class="text-left px-4 py-3 font-semibold text-dark-700">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payouts as $payout)
                        <tr class="border-b border-dark-50 hover:bg-dark-50/30 transition-colors">
                            <td class="px-4 py-3 font-mono text-xs font-medium text-dark-900">{{ $payout->payout_number }}</td>
                            <td class="px-4 py-3 font-medium text-dark-900">{{ $payout->formatted_amount }}</td>
                            <td class="px-4 py-3 text-dark-600">{{ $payout->bank_name }} - {{ $payout->bank_account_number }}</td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $payout->status_badge }} text-[10px]">{{ $payout->status_label }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-dark-400">{{ $payout->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if ($payouts->hasPages())
        <div class="flex justify-center mt-6">
            {{ $payouts->links() }}
        </div>
    @endif
</x-dashboard-layout>
