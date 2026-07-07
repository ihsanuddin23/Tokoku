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
        <a href="{{ route('seller.payouts.index') }}" class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Penarikan Dana
        </a>
        <a href="{{ route('seller.reviews.index') }}" class="sidebar-link sidebar-link-active">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
            Ulasan
        </a>
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold font-display text-dark-900">Ulasan Produk</h1>
        <p class="text-sm text-dark-400 mt-1">Kelola dan balas ulasan dari pembeli</p>
    </div>

    @if (session('status') === 'review-responded')
        <div class="glass border-green-200/50 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-soft mb-6 animate-fade-in-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Balasan berhasil dikirim.
        </div>
    @endif

    <div class="mb-4 flex gap-2">
        <a href="{{ route('seller.reviews.index') }}" class="btn-secondary text-sm @if(!request('filter')) btn-primary @endif">Semua</a>
        <a href="{{ route('seller.reviews.index', ['filter' => 'unresponded']) }}" class="btn-secondary text-sm @if(request('filter') === 'unresponded') btn-primary @endif">Belum Dibalas</a>
        <a href="{{ route('seller.reviews.index', ['filter' => 'responded']) }}" class="btn-secondary text-sm @if(request('filter') === 'responded') btn-primary @endif">Sudah Dibalas</a>
    </div>

    @if ($reviews->isEmpty())
        <div class="card p-12 text-center">
            <p class="text-sm text-dark-400">Belum ada ulasan untuk produk Anda.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($reviews as $review)
                <div class="card p-5">
                    <div class="flex items-start gap-4">
                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=e2e8f0&color=475569' }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <p class="text-sm font-semibold text-dark-900">{{ $review->user->name }}</p>
                                    <p class="text-xs text-dark-400">{{ $review->created_at->format('d M Y') }} &middot; {{ $review->product->name }}</p>
                                </div>
                                <div class="flex text-amber-400 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-amber-400' : 'text-dark-200' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            @if ($review->comment)
                                <p class="text-sm text-dark-600 mt-2">{{ $review->comment }}</p>
                            @endif

                            @if ($review->seller_response)
                                <div class="mt-3 ml-4 pl-4 border-l-2 border-primary-200 bg-primary-50/50 rounded-r-lg py-2 px-3">
                                    <p class="text-xs font-semibold text-primary-700 mb-1">Balasan Anda</p>
                                    <p class="text-sm text-dark-600">{{ $review->seller_response }}</p>
                                    <p class="text-[10px] text-dark-400 mt-1">{{ $review->seller_responded_at->format('d M Y, H:i') }}</p>
                                </div>
                            @else
                                <form method="POST" action="{{ route('reviews.respond', $review) }}" class="mt-3">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex gap-2">
                                        <input type="text" name="seller_response" placeholder="Tulis balasan untuk ulasan ini..." class="flex-1 rounded-xl border-dark-200 bg-white px-4 py-2 text-sm text-dark-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" required>
                                        <button type="submit" class="btn-primary text-sm whitespace-nowrap">Balas</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($reviews->hasPages())
        <div class="flex justify-center mt-6">
            {{ $reviews->links() }}
        </div>
    @endif
</x-dashboard-layout>
