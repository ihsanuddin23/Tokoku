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
        <a href="{{ route('seller.orders.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Pesanan
        </a>
        <a href="{{ route('seller.reports.index') }}" class="sidebar-link">
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

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-dark-500 mb-1">
                <a href="{{ route('seller.orders.index') }}" class="hover:text-primary-600 transition-colors">Pesanan</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-900 font-medium">{{ $order->order_number }}</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900">Detail Pesanan</h1>
        </div>
        <a href="{{ route('seller.orders.index') }}" class="btn-secondary text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    @if (session('status') === 'order-status-updated')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Status pesanan berhasil diperbarui.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Items & Status Update -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Order Status Card -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-dark-900">Status Pesanan</h2>
                    <div class="flex items-center gap-3">
                        @php
                            $statusConfig = [
                                'pending'   => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-amber-100 text-amber-700'],
                                'paid'      => ['label' => 'Sudah Dibayar', 'class' => 'bg-blue-100 text-blue-700'],
                                'shipped'   => ['label' => 'Dikirim', 'class' => 'bg-indigo-100 text-indigo-700'],
                                'completed' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-700'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-700'],
                            ];
                            $sc = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'bg-dark-100 text-dark-600'];
                        @endphp
                        <span class="badge {{ $sc['class'] }} text-xs">{{ $sc['label'] }}</span>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="flex items-center gap-3 p-4 rounded-2xl {{ $order->payment_status === 'paid' ? 'bg-green-50 border border-green-100' : 'bg-amber-50 border border-amber-100' }}">
                    @if ($order->payment_status === 'paid')
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Pembayaran Diterima</p>
                            <p class="text-xs text-green-600">
                                {{ $order->payment_method ? 'via ' . strtoupper($order->payment_method) : '' }}
                                {{ $order->paid_at ? '· ' . $order->paid_at->format('d M Y, H:i') : '' }}
                            </p>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-amber-800">Menunggu Pembayaran</p>
                            <p class="text-xs text-amber-600">Buyer belum menyelesaikan pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items -->
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-dark-100">
                    <h2 class="text-sm font-semibold text-dark-900">Produk Dipesan</h2>
                </div>
                <div class="divide-y divide-dark-50">
                    @foreach ($order->items as $item)
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 rounded-xl bg-dark-50 overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->first_image)
                                        <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-dark-900">{{ $item->product_name }}</p>
                                    <p class="text-xs text-dark-500 mt-0.5">{{ $item->formatted_price }} × {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-bold text-dark-900">{{ $item->formatted_subtotal }}</p>
                                    <span class="badge {{ $item->status_badge }} text-[10px] mt-1">{{ $item->status_label }}</span>
                                </div>
                            </div>

                            <!-- Update Status Form -->
                            @if (count($validTransitions[$item->status] ?? []) > 0)
                                <div class="mt-4 pt-4 border-t border-dark-50" x-data="{ nextStatus: '{{ $validTransitions[$item->status][0] ?? '' }}' }">
                                    <form method="POST" action="{{ route('seller.orders.update-status', $item) }}" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center justify-end gap-3">
                                            <span class="text-xs text-dark-500">Ubah status:</span>
                                            <select name="status" x-model="nextStatus" class="text-xs border border-dark-200 rounded-lg px-3 py-1.5 outline-none focus:border-primary-400 cursor-pointer bg-white">
                                                @foreach ($validTransitions[$item->status] as $nextStatus)
                                                    <option value="{{ $nextStatus }}">
                                                        {{ match($nextStatus) {
                                                            'paid' => 'Tandai Dibayar',
                                                            'shipped' => 'Tandai Dikirim',
                                                            'completed' => 'Tandai Selesai',
                                                            'cancelled' => 'Batalkan',
                                                            default => ucfirst($nextStatus),
                                                        } }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-primary text-xs px-4 py-1.5">Simpan</button>
                                        </div>
                                        <div x-show="nextStatus === 'shipped'" x-transition class="flex items-center gap-2">
                                            <label class="text-xs text-dark-500 shrink-0">No. Resi:</label>
                                            <input type="text" name="tracking_number" placeholder="Contoh: JNE1234567890" class="input-modern text-xs flex-1" :required="nextStatus === 'shipped'">
                                        </div>
                                    </form>
                                </div>
                            @elseif ($item->status === 'shipped' && $order->tracking_number)
                                <div class="mt-3 pt-3 border-t border-dark-50">
                                    <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-200 rounded-lg px-3 py-1.5">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        <span class="text-xs text-indigo-700 font-medium">No. Resi: <span class="font-bold">{{ $order->tracking_number }}</span></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Order Info -->
        <div class="space-y-5">

            <!-- Order Info -->
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-dark-900 mb-4">Info Pesanan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-dark-500">No. Order</span>
                        <span class="font-mono font-medium text-dark-900 text-xs">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-500">Tanggal</span>
                        <span class="text-dark-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-500">Subtotal</span>
                        <span class="font-semibold text-dark-900">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>
                    @if ($order->notes)
                        <div class="pt-2 border-t border-dark-100">
                            <p class="text-dark-500 text-xs mb-1">Catatan Pembeli:</p>
                            <p class="text-dark-700 text-xs">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Buyer Info -->
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-dark-900 mb-4">Informasi Pembeli</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-dark-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-dark-500">{{ $order->user->email }}</p>
                    </div>
                </div>
                @if ($order->user->phone)
                    <p class="text-xs text-dark-600">📱 {{ $order->user->phone }}</p>
                @endif
            </div>

            <!-- Shipping Address -->
            @if ($order->address)
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-3">Alamat Pengiriman</h3>
                    <div class="text-sm text-dark-700 space-y-0.5">
                        <p class="font-medium text-dark-900">{{ $order->address->recipient_name }}</p>
                        <p class="text-xs text-dark-500">{{ $order->address->phone }}</p>
                        <p class="text-xs mt-1">{{ $order->address->address }}</p>
                        <p class="text-xs">{{ $order->address->city }}, {{ $order->address->province }} {{ $order->address->postal_code }}</p>
                    </div>
                </div>
            @elseif ($order->shipping_address)
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-3">Alamat Pengiriman</h3>
                    <p class="text-sm text-dark-700">{{ $order->shipping_address }}</p>
                </div>
            @endif

            <!-- Payment Info -->
            @if ($order->payment)
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-dark-900 mb-3">Info Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-dark-500">Metode</span>
                            <span class="text-dark-900 font-medium">{{ strtoupper($order->payment->payment_type ?? '-') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-500">Status</span>
                            @if ($order->payment->transaction_status === 'settlement' || $order->payment_status === 'paid')
                                <span class="text-green-600 font-semibold">Lunas</span>
                            @elseif ($order->payment->transaction_status === 'pending')
                                <span class="text-amber-600 font-semibold">Pending</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ ucfirst($order->payment->transaction_status ?? '-') }}</span>
                            @endif
                        </div>
                        @if ($order->payment->paid_at)
                            <div class="flex justify-between">
                                <span class="text-dark-500">Dibayar</span>
                                <span class="text-dark-900">{{ $order->payment->paid_at->format('d M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
