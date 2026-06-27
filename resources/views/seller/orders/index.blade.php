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
    <div class="mb-6">
        <h1 class="text-2xl font-bold font-display text-dark-900">Pesanan Masuk</h1>
        <p class="text-sm text-dark-500 mt-0.5">Kelola order dari pembeli</p>
    </div>

    @if (session('status') === 'order-status-updated')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Status pesanan berhasil diperbarui.
        </div>
    @endif

    <div class="card overflow-hidden">
        @if ($orderItems->isEmpty())
            <div class="p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Pesanan</h2>
                <p class="text-sm text-dark-400">Order dari pembeli akan muncul di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-dark-100 bg-dark-50/50">
                            <th class="text-left text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">No. Order</th>
                            <th class="text-left text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Produk</th>
                            <th class="text-left text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Pembeli</th>
                            <th class="text-center text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Qty</th>
                            <th class="text-right text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Subtotal</th>
                            <th class="text-center text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Status</th>
                            <th class="text-center text-xs font-semibold text-dark-600 uppercase tracking-wider px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-50">
                        @foreach ($orderItems as $item)
                            <tr class="hover:bg-dark-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-mono font-medium text-dark-900">{{ $item->order->order_number }}</span>
                                    <p class="text-xs text-dark-400">{{ $item->order->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-dark-900 truncate max-w-[180px]">{{ $item->product_name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-dark-700">{{ $item->order->user->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm text-dark-900">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-dark-900">{{ $item->formatted_subtotal }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="badge {{ $item->status_badge }} text-[10px]">{{ $item->status_label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('seller.orders.update-status', $item) }}" class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-xs border border-dark-200 rounded-lg px-2 py-1.5 outline-none focus:border-primary-400 cursor-pointer" onchange="if(this.value !== '{{ $item->status }}') this.form.submit(); else this.selectedIndex = {{ array_search($item->status, ['pending','paid','shipped','completed','cancelled']) }};">
                                            <option value="pending" @selected($item->status === 'pending') @disabled(!in_array('pending', $validTransitions[$item->status] ?? []))>Pending</option>
                                            <option value="paid" @selected($item->status === 'paid') @disabled(!in_array('paid', $validTransitions[$item->status] ?? []))>Dibayar</option>
                                            <option value="shipped" @selected($item->status === 'shipped') @disabled(!in_array('shipped', $validTransitions[$item->status] ?? []))>Dikirim</option>
                                            <option value="completed" @selected($item->status === 'completed') @disabled(!in_array('completed', $validTransitions[$item->status] ?? []))>Selesai</option>
                                            <option value="cancelled" @selected($item->status === 'cancelled') @disabled(!in_array('cancelled', $validTransitions[$item->status] ?? []))>Batal</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($orderItems->hasPages())
                <div class="px-6 py-4 border-t border-dark-100">
                    {{ $orderItems->links() }}
                </div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
