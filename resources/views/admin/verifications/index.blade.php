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
        <a href="{{ route('admin.verifications.index') }}" class="sidebar-link sidebar-link-active">
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
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Laporan
        </a>
        <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            Voucher
        </a>
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold font-display text-dark-900">Verifikasi Seller</h1>
        <p class="text-sm text-dark-500 mt-0.5">Review pengajuan seller baru</p>
    </div>

    @if (session('status') === 'seller-approved')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Seller berhasil disetujui.
        </div>
    @elseif (session('status') === 'seller-rejected')
        <div class="glass border-red-200/50 text-red-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pengajuan seller ditolak.
        </div>
    @endif

    <!-- Filter -->
    <form method="GET" class="flex items-center gap-3 mb-5">
        <select name="status" class="input-modern cursor-pointer max-w-[180px]" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
            <option value="approved" @selected(request('status') === 'approved')>Approved</option>
            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
        </select>
    </form>

    @if ($verifications->isEmpty())
        <div class="card p-16 text-center">
            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Tidak Ada Pengajuan</h2>
            <p class="text-sm text-dark-400">Pengajuan seller akan muncul di sini.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($verifications as $verification)
                <div class="card p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold shrink-0">
                                {{ strtoupper(substr($verification->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-dark-900">{{ $verification->user->name }}</p>
                                <p class="text-xs text-dark-400">{{ $verification->user->email }}</p>
                            </div>
                        </div>
                        <span class="badge @if ($verification->status === 'pending') bg-amber-100 text-amber-700 @elseif ($verification->status === 'approved') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif text-[10px] capitalize">{{ $verification->status }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-dark-400 mb-1">Nama Toko</p>
                            <p class="text-sm font-medium text-dark-900">{{ $verification->store_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-dark-400 mb-1">Kota</p>
                            <p class="text-sm font-medium text-dark-900">{{ $verification->city }}</p>
                        </div>
                    </div>

                    @if ($verification->description)
                        <div class="mb-4">
                            <p class="text-xs text-dark-400 mb-1">Deskripsi</p>
                            <p class="text-sm text-dark-600">{{ $verification->description }}</p>
                        </div>
                    @endif

                    @if ($verification->status === 'rejected' && $verification->admin_note)
                        <div class="bg-red-50 rounded-xl p-3 mb-4">
                            <p class="text-xs text-red-600 font-medium">Alasan penolakan:</p>
                            <p class="text-sm text-red-700">{{ $verification->admin_note }}</p>
                        </div>
                    @endif

                    @if ($verification->status === 'pending')
                        <div class="flex items-center gap-3 pt-3 border-t border-dark-50">
                            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn bg-green-50 text-green-600 hover:bg-green-100 text-sm" onclick="return confirm('Setujui seller ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}" class="flex-1 flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="admin_note" placeholder="Alasan penolakan..." class="input-modern flex-1 text-sm" required>
                                <button type="submit" class="btn bg-red-50 text-red-600 hover:bg-red-100 text-sm whitespace-nowrap" onclick="return confirm('Tolak pengajuan ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if ($verifications->hasPages())
            <div class="flex justify-center mt-6">
                {{ $verifications->links() }}
            </div>
        @endif
    @endif
</x-dashboard-layout>
