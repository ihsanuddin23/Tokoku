<x-app-layout>
    @section('meta_title', 'Semua Kategori — ' . config('app.name'))
    @section('meta_description', 'Jelajahi semua kategori produk di TokoKu. Temukan produk sesuai kebutuhan Anda.')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-dark-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-dark-600 font-medium">Kategori</span>
            </div>
            <h1 class="text-2xl font-bold font-display text-dark-900 mb-1">Semua Kategori</h1>
            <p class="text-sm text-dark-500">Temukan produk berdasarkan kategori yang Anda butuhkan.</p>
        </div>

        @if ($categories->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Belum Ada Kategori</h2>
                <p class="text-sm text-dark-400 mb-6">Kategori produk akan muncul di sini.</p>
                <a href="{{ route('home') }}" class="btn-primary inline-flex">Kembali ke Beranda</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="card card-hover p-6 text-center group animate-fade-in-up" style="animation-delay: {{ ($loop->iteration - 1) * 0.05 }}s">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            @if ($category->icon)
                                <span class="text-2xl">{{ $category->icon }}</span>
                            @else
                                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-dark-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $category->name }}</h3>
                        <p class="text-xs text-dark-400">{{ $category->products_count }} produk</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
