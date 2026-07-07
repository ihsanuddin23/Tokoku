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
        <a href="{{ route('admin.returns.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1m12 0a2 2 0 01-2 2H6a2 2 0 01-2-2m12 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v6m12 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 15H4" /></svg>
            Pengembalian
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
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
            <a href="{{ route('admin.returns.index') }}" class="hover:text-primary-600 transition-colors">Pengembalian</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">#{{ $return->id }}</span>
        </div>
        <h1 class="text-2xl font-bold font-display text-dark-900">Detail Pengembalian</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-dark-900 mb-4">Informasi Pengajuan</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-dark-50">
                        <span class="text-sm text-dark-400">ID Pengajuan</span>
                        <span class="text-sm font-mono font-medium text-dark-900">#{{ $return->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-dark-50">
                        <span class="text-sm text-dark-400">Nomor Pesanan</span>
                        <a href="{{ route('admin.orders.show', $return->order) }}" class="text-sm font-mono font-medium text-primary-600 hover:text-primary-700">{{ $return->order->order_number }}</a>
                    </div>
                    <div class="flex justify-between py-2 border-b border-dark-50">
                        <span class="text-sm text-dark-400">Pembeli</span>
                        <span class="text-sm font-medium text-dark-900">{{ $return->user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-dark-50">
                        <span class="text-sm text-dark-400">Alasan</span>
                        <span class="text-sm font-medium text-dark-900">{{ $return->reason }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-dark-50">
                        <span class="text-sm text-dark-400">Tanggal Pengajuan</span>
                        <span class="text-sm text-dark-700">{{ $return->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-dark-400">Status</span>
                        <span class="badge {{ $return->status_badge }} text-[10px]">{{ $return->status_label }}</span>
                    </div>
                </div>

                @if ($return->description)
                    <div class="mt-4 pt-4 border-t border-dark-50">
                        <p class="text-xs text-dark-400 mb-1">Deskripsi</p>
                        <p class="text-sm text-dark-600">{{ $return->description }}</p>
                    </div>
                @endif

                @if ($return->admin_note)
                    <div class="mt-4 pt-4 border-t border-dark-50">
                        <p class="text-xs text-dark-400 mb-1">Catatan Admin</p>
                        <p class="text-sm text-dark-600">{{ $return->admin_note }}</p>
                    </div>
                @endif
            </div>

            <div class="card p-6">
                <h2 class="text-lg font-semibold text-dark-900 mb-4">Item Pesanan</h2>
                <div class="space-y-3">
                    @foreach ($return->order->items as $item)
                        <div class="flex items-center gap-3 py-2 border-b border-dark-50 last:border-0">
                            <div class="w-10 h-10 rounded-lg bg-dark-50 overflow-hidden shrink-0">
                                @if ($item->product && $item->product->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-dark-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-dark-400">{{ $item->quantity }}x â€” {{ $item->formatted_subtotal }}</p>
                            </div>
                            @if ($return->order_item_id === $item->id)
                                <span class="badge bg-primary-100 text-primary-700 text-[10px]">Diajukan</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-dark-900 mb-4">Aksi</h2>

                @if ($return->status === 'pending')
                    <form action="{{ route('admin.returns.approve', $return) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <textarea name="admin_note" rows="3" placeholder="Catatan untuk pembeli (opsional)..." class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all resize-none"></textarea>
                        <button type="submit" class="btn-primary w-full justify-center text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Setujui Pengajuan
                        </button>
                    </form>

                    <form action="{{ route('admin.returns.reject', $return) }}" method="POST" class="space-y-3 mt-4">
                        @csrf
                        @method('PATCH')
                        <textarea name="admin_note" rows="3" placeholder="Alasan penolakan (wajib)..." class="w-full rounded-xl border-dark-200 bg-white px-4 py-2.5 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all resize-none" required></textarea>
                        <button type="submit" class="btn w-full justify-center text-sm bg-red-500 hover:bg-red-600 text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            Tolak Pengajuan
                        </button>
                    </form>
                @elseif ($return->status === 'approved')
                    <form action="{{ route('admin.returns.refund', $return) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn w-full justify-center text-sm bg-green-500 hover:bg-green-600 text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            Proses Refund
                        </button>
                    </form>
                @else
                    <p class="text-sm text-dark-400 text-center py-4">Pengajuan ini sudah selesai diproses.</p>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
