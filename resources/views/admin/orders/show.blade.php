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
        <a href="{{ route('admin.products.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link sidebar-link-active">
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

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-dark-500 mb-1">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-primary-600 transition-colors">Semua Pesanan</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-900 font-medium">{{ $order->order_number }}</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Detail Pesanan</h1>
        </div>
        <div class="flex items-center gap-3">
            <span class="badge {{ $order->status_badge }} text-xs">{{ $order->status_label }}</span>
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>
    </div>

    @if (session('status') === 'order-status-updated')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Status pesanan berhasil diperbarui.
        </div>
    @endif

    <!-- Update Status -->
    <div class="card p-5 mb-6">
        <h2 class="text-sm font-semibold text-dark-900 mb-3">Ubah Status Pesanan</h2>
        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex items-center gap-3">
            @csrf
            @method('PATCH')
            <select name="status" class="rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                <option value="paid" @selected($order->status === 'paid')>Dibayar</option>
                <option value="shipped" @selected($order->status === 'shipped')>Dikirim</option>
                <option value="completed" @selected($order->status === 'completed')>Selesai</option>
                <option value="cancelled" @selected($order->status === 'cancelled')>Dibatalkan</option>
            </select>
            <button type="submit" class="btn-primary text-sm">Update Status</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Items -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Items -->
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-dark-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-dark-900">Produk Dipesan</h2>
                    <span class="text-xs text-dark-400">{{ $order->items->count() }} item</span>
                </div>
                <div class="divide-y divide-dark-50">
                    @foreach ($order->items as $item)
                        <div class="p-5 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                                @if ($item->product?->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-dark-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-dark-400 mt-0.5">Toko: {{ $item->sellerProfile?->store_name ?? '-' }}</p>
                                <p class="text-xs text-dark-500 mt-0.5">{{ $item->formatted_price }} Ã— {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-dark-900">{{ $item->formatted_subtotal }}</p>
                                <span class="badge {{ $item->status_badge }} text-[10px] mt-1">{{ $item->status_label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="card p-6">
                <h2 class="text-sm font-semibold text-dark-900 mb-4">Ringkasan Pembayaran</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-dark-500">
                        <span>Subtotal</span>
                        <span class="text-dark-700 font-medium">{{ $order->formatted_subtotal }}</span>
                    </div>
                    <div class="flex justify-between text-dark-500">
                        <span>Ongkos Kirim</span>
                        <span class="text-dark-700 font-medium">{{ $order->formatted_shipping_cost }}</span>
                    </div>
                    @if ($order->shipping_courier)
                        <div class="flex justify-between text-dark-500">
                            <span>Kurir</span>
                            <span class="text-dark-700">{{ strtoupper($order->shipping_courier) }} {{ $order->shipping_service }}</span>
                        </div>
                    @endif
                    @if ($order->tracking_number)
                        <div class="flex justify-between text-dark-500">
                            <span>No. Resi</span>
                            <span class="font-mono font-semibold text-indigo-700">{{ $order->tracking_number }}</span>
                        </div>
                    @endif
                    <div class="border-t border-dark-100 pt-3 flex justify-between">
                        <span class="font-semibold text-dark-900">Total</span>
                        <span class="font-bold text-primary-600 text-lg font-display">{{ $order->formatted_grand_total }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Info -->
        <div class="space-y-5">

            <!-- Order Info -->
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-dark-900 mb-4">Info Pesanan</h3>
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-dark-500">No. Order</span>
                        <span class="font-mono text-xs font-semibold text-dark-900">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-500">Tanggal</span>
                        <span class="text-dark-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-500">Metode Bayar</span>
                        <span class="text-dark-900 font-medium">{{ strtoupper($order->payment_method ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-500">Status Bayar</span>
                        @php
                            $payClass = match($order->payment_status) {
                                'paid'     => 'bg-green-100 text-green-700',
                                'refunded' => 'bg-purple-100 text-purple-700',
                                default    => 'bg-amber-100 text-amber-700',
                            };
                            $payLabel = match($order->payment_status) {
                                'paid'     => 'Lunas',
                                'refunded' => 'Refund',
                                default    => 'Belum Bayar',
                            };
                        @endphp
                        <span class="badge {{ $payClass }} text-[10px]">{{ $payLabel }}</span>
                    </div>
                    @if ($order->paid_at)
                        <div class="flex justify-between">
                            <span class="text-dark-500">Dibayar</span>
                            <span class="text-dark-900">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if ($order->shipped_at)
                        <div class="flex justify-between">
                            <span class="text-dark-500">Dikirim</span>
                            <span class="text-dark-900">{{ $order->shipped_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if ($order->completed_at)
                        <div class="flex justify-between">
                            <span class="text-dark-500">Selesai</span>
                            <span class="text-dark-900">{{ $order->completed_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if ($order->cancelled_at)
                        <div class="flex justify-between">
                            <span class="text-dark-500">Dibatalkan</span>
                            <span class="text-red-600">{{ $order->cancelled_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Buyer Info -->
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-dark-900 mb-3">Pembeli</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr($order->user?->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-dark-900">{{ $order->user?->name ?? '-' }}</p>
                        <p class="text-xs text-dark-500">{{ $order->user?->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            @if ($order->address || $order->shipping_address)
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-3">Alamat Pengiriman</h3>
                    @if ($order->address)
                        <div class="text-sm text-dark-700 space-y-0.5">
                            <p class="font-medium">{{ $order->address->recipient_name }}</p>
                            <p class="text-xs text-dark-500">{{ $order->address->phone }}</p>
                            <p class="text-xs mt-1">{{ $order->address->full_address }}</p>
                            <p class="text-xs">{{ $order->address->city }}, {{ $order->address->province }} {{ $order->address->postal_code }}</p>
                        </div>
                    @else
                        <p class="text-sm text-dark-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                    @endif
                </div>
            @endif

            <!-- Notes -->
            @if ($order->notes)
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-2">Catatan Pembeli</h3>
                    <p class="text-sm text-dark-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
