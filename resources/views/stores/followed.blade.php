<x-app-layout>
    @section('meta_title', 'Toko Diikuti — ' . config('app.name'))

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Toko Diikuti</span>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold font-display text-dark-900">Toko Diikuti</h1>
            <span class="text-sm text-dark-500">{{ $followedStores->total() }} toko</span>
        </div>

        @if ($followedStores->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-dark-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <p class="text-sm text-dark-400 mb-4">Anda belum mengikuti toko apapun.</p>
                <a href="{{ route('home') }}" class="btn-primary text-sm">Jelajahi Toko</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                @foreach ($followedStores as $follow)
                    @php $store = $follow->sellerProfile; @endphp
                    <div class="card card-hover overflow-hidden">
                        <div class="h-24 bg-gradient-to-br from-primary-400 to-primary-600 relative">
                            @if ($store->banner)
                                <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-5 -mt-10 relative">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden shrink-0 ring-4 ring-white shadow-md mb-3">
                                @if ($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-primary-600">{{ strtoupper(substr($store->store_name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('stores.show', $store->store_slug) }}" class="block">
                                <h3 class="text-base font-semibold font-display text-dark-900 hover:text-primary-600 transition-colors">{{ $store->store_name }}</h3>
                            </a>
                            <div class="flex items-center gap-2 text-xs text-dark-500 mt-1">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $store->city ?? 'Indonesia' }}
                                </span>
                                <span class="text-dark-300">|</span>
                                <span>{{ $store->active_products_count ?? 0 }} produk</span>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-[10px] text-dark-400">Mengikuti sejak {{ $follow->created_at->diffForHumans() }}</span>
                                <button type="button"
                                    x-data="{ following: true }"
                                    x-on:click="if (confirm('Berhenti mengikuti toko ini?')) { fetch('{{ route('stores.unfollow', $store) }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' } }).then(() => { window.location.reload(); }) }"
                                    class="text-xs text-dark-400 hover:text-red-500 transition-colors font-medium">
                                    Berhenti ikuti
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($followedStores->hasPages())
                <div class="flex justify-center">
                    {{ $followedStores->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
