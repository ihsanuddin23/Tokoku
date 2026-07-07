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
        <a href="{{ route('admin.returns.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1m12 0a2 2 0 01-2 2H6a2 2 0 01-2-2m12 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v6m12 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 15H4" /></svg>
            Pengembalian
        </a>
        <a href="{{ route('admin.payments.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Pembayaran
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
        <a href="{{ route('admin.settings.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Pengaturan
        </a>
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold font-display text-dark-900">Manajemen Pembayaran</h1>
        <p class="text-sm text-dark-400 mt-1">Kelola status pembayaran semua pesanan</p>
    </div>

    @if (session('status'))
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            @if (session('status') === 'payment-marked-paid') Pembayaran ditandai lunas.
            @elseif (session('status') === 'payment-marked-refunded') Pembayaran ditandai di-refund.
            @endif
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-xs text-dark-400 mb-1">Total Pesanan</p>
            <p class="text-2xl font-bold font-display text-dark-900">{{ $stats['total'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-dark-400 mb-1">Lunas</p>
            <p class="text-2xl font-bold font-display text-green-600">{{ $stats['paid'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-dark-400 mb-1">Belum Bayar</p>
            <p class="text-2xl font-bold font-display text-yellow-600">{{ $stats['unpaid'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-dark-400 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold font-display text-primary-600">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card p-4 mb-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan..." class="flex-1 rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
            <select name="payment_status" class="rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                <option value="">Semua Status</option>
                <option value="unpaid" @selected(request('payment_status') === 'unpaid')>Belum Dibayar</option>
                <option value="paid" @selected(request('payment_status') === 'paid')>Lunas</option>
                <option value="refunded" @selected(request('payment_status') === 'refunded')>Refund</option>
            </select>
            <select name="payment_method" class="rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                <option value="">Semua Metode</option>
                <option value="midtrans" @selected(request('payment_method') === 'midtrans')>Midtrans</option>
                <option value="cod" @selected(request('payment_method') === 'cod')>COD</option>
            </select>
            <button type="submit" class="btn-primary text-sm whitespace-nowrap">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-dark-100 bg-dark-50/50">
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">No. Pesanan</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Pembeli</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Metode</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Total</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-dark-700">Tanggal</th>
                    <th class="text-right px-4 py-3 font-semibold text-dark-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b border-dark-50 hover:bg-dark-50/30 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs font-medium text-dark-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-dark-700">{{ $order->user->name }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium uppercase {{ $order->payment_method === 'midtrans' ? 'text-blue-600' : 'text-orange-600' }}">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-dark-900">{{ $order->formatted_grand_total }}</td>
                        <td class="px-4 py-3">
                            @if ($order->payment_status === 'paid')
                                <span class="badge bg-green-100 text-green-700 text-[10px]">Lunas</span>
                            @elseif ($order->payment_status === 'unpaid')
                                <span class="badge bg-yellow-100 text-yellow-700 text-[10px]">Belum Bayar</span>
                            @elseif ($order->payment_status === 'refunded')
                                <span class="badge bg-red-100 text-red-700 text-[10px]">Refund</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-dark-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if ($order->payment_status === 'unpaid')
                                    <form method="POST" action="{{ route('admin.payments.mark-paid', $order) }}" onsubmit="return confirm('Tandai pembayaran ini sebagai lunas?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-700 text-xs font-medium">Tandai Lunas</button>
                                    </form>
                                @elseif ($order->payment_status === 'paid')
                                    <form method="POST" action="{{ route('admin.payments.mark-refunded', $order) }}" onsubmit="return confirm('Tandai pembayaran ini sebagai di-refund?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-xs font-medium">Refund</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
        <div class="flex justify-center mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-dashboard-layout>
