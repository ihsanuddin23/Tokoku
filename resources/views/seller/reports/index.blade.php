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
        <a href="{{ route('seller.reports.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('seller.vouchers.index') }}" class="sidebar-link">
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
            <h1 class="text-2xl font-bold font-display text-dark-900">Laporan Penjualan</h1>
            <p class="text-sm text-dark-500 mt-1">Analisis performa toko Anda</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card p-5 mb-6">
        <form method="GET" action="{{ route('seller.reports.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-xs font-medium text-dark-500 mb-1.5">Dari Tanggal</label>
                <input type="date" name="from" value="{{ $fromDate }}" class="form-input">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-xs font-medium text-dark-500 mb-1.5">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ $toDate }}" class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter
            </button>
            <a href="{{ route('seller.reports.export-pdf', ['from' => $fromDate, 'to' => $toDate]) }}" class="btn bg-red-50 text-red-600 hover:bg-red-100 transition-colors" target="_blank">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                Export PDF
            </a>
            <a href="{{ route('seller.reports.export-csv', ['from' => $fromDate, 'to' => $toDate]) }}" class="btn bg-green-50 text-green-600 hover:bg-green-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Export CSV
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="stat-card">
            <p class="text-xs text-dark-500 font-medium">Total Revenue</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-dark-500 font-medium">Total Order</p>
            <p class="text-2xl font-bold font-display text-dark-900 mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-dark-500 font-medium">Selesai</p>
            <p class="text-2xl font-bold font-display text-green-600 mt-1">{{ $totalCompleted }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-dark-500 font-medium">Pending</p>
            <p class="text-2xl font-bold font-display text-amber-600 mt-1">{{ $totalPending }}</p>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card p-6 mb-6">
        <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Produk Terlaris</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-dark-100">
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">Produk</th>
                        <th class="text-right py-3 px-4 text-xs font-medium text-dark-500 uppercase">Terjual</th>
                        <th class="text-right py-3 px-4 text-xs font-medium text-dark-500 uppercase">Stok</th>
                        <th class="text-right py-3 px-4 text-xs font-medium text-dark-500 uppercase">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $product)
                        <tr class="border-b border-dark-50 hover:bg-dark-50/50">
                            <td class="py-3 px-4 text-sm font-medium text-dark-700">{{ $product->name }}</td>
                            <td class="py-3 px-4 text-sm text-right text-dark-600">{{ $product->total_sold }}</td>
                            <td class="py-3 px-4 text-sm text-right {{ $product->stock <= 5 ? 'text-amber-600 font-semibold' : 'text-dark-600' }}">{{ $product->stock }}</td>
                            <td class="py-3 px-4 text-sm text-right text-dark-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-8 text-center text-sm text-dark-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="card p-6">
        <h2 class="text-lg font-semibold font-display text-dark-900 mb-4">Detail Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-dark-100">
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">No. Pesanan</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">Produk</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">Pembeli</th>
                        <th class="text-right py-3 px-4 text-xs font-medium text-dark-500 uppercase">Qty</th>
                        <th class="text-right py-3 px-4 text-xs font-medium text-dark-500 uppercase">Subtotal</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-dark-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderItems as $item)
                        <tr class="border-b border-dark-50 hover:bg-dark-50/50">
                            <td class="py-3 px-4 text-sm font-medium text-dark-700">{{ $item->order->order_number }}</td>
                            <td class="py-3 px-4 text-sm text-dark-600">{{ $item->product_name }}</td>
                            <td class="py-3 px-4 text-sm text-dark-600">{{ $item->order->user->name }}</td>
                            <td class="py-3 px-4 text-sm text-right text-dark-600">{{ $item->quantity }}</td>
                            <td class="py-3 px-4 text-sm text-right text-dark-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-sm"><span class="badge {{ $item->status === 'completed' ? 'badge-success' : ($item->status === 'cancelled' ? 'badge-danger' : 'badge-warning') }}">{{ $item->status_label }}</span></td>
                            <td class="py-3 px-4 text-sm text-dark-400">{{ $item->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-8 text-center text-sm text-dark-400">Belum ada transaksi pada periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
