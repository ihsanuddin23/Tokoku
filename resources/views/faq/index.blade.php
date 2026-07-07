<x-app-layout>
    @section('meta_title', 'FAQ & Pusat Bantuan — TokoKu')
    @section('meta_description', 'Temukan jawaban atas pertanyaan umum seputar pembelian, pembayaran, pengiriman, retur, akun, dan penjualan di TokoKu.')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">FAQ & Pusat Bantuan</span>
        </div>

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 text-white shadow-glow mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold font-display text-dark-900 mb-3">FAQ & Pusat Bantuan</h1>
            <p class="text-dark-500 max-w-2xl mx-auto">Temukan jawaban atas pertanyaan umum seputar TokoKu. Pilih kategori di bawah untuk mempersempit pencarian.</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8" x-data="{ search: '' }">
            <div class="relative max-w-xl mx-auto">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Cari pertanyaan atau kata kunci..."
                    class="w-full pl-12 pr-4 py-3.5 bg-white border border-dark-200 rounded-2xl text-sm text-dark-900 placeholder-dark-400 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all shadow-sm"
                >
            </div>

            <!-- FAQ Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                @foreach ($faqCategories as $category)
                    <div class="card p-6" x-data="{ open: null }">
                        <!-- Category Header -->
                        <div class="flex items-center gap-3 mb-4">
                            @switch($category['icon'])
                                @case('shopping')
                                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    </div>
                                    @break
                                @case('payment')
                                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H5a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    </div>
                                    @break
                                @case('shipping')
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 17h6V5H4v12h2m8 0h2m-4 0V5" /></svg>
                                    </div>
                                    @break
                                @case('account')
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    @break
                                @case('seller')
                                    <div class="w-10 h-10 rounded-xl bg-secondary-100 text-secondary-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    @break
                            @endswitch
                            <h2 class="text-lg font-bold font-display text-dark-900">{{ $category['title'] }}</h2>
                        </div>

                        <!-- Questions -->
                        <div class="space-y-2">
                            @foreach ($category['questions'] as $item)
                                <div
                                    x-show="search === '' || '{{ strtolower($item['q'] . ' ' . $item['a']) }}'.includes(search.toLowerCase())"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                >
                                    <button
                                        @click="open === {{ $loop->index }} ? open = null : open = {{ $loop->index }}"
                                        class="w-full flex items-center justify-between gap-3 text-left px-4 py-3 rounded-xl hover:bg-dark-50 transition-colors"
                                        :class="open === {{ $loop->index }} ? 'bg-dark-50' : ''"
                                    >
                                        <span class="text-sm font-medium text-dark-700">{{ $item['q'] }}</span>
                                        <svg
                                            class="w-4 h-4 text-dark-400 shrink-0 transition-transform duration-200"
                                            :class="open === {{ $loop->index }} ? 'rotate-180' : ''"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        ><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <div
                                        x-show="open === {{ $loop->index }}"
                                        x-collapse
                                        x-cloak
                                        style="display: none;"
                                    >
                                        <p class="text-sm text-dark-500 leading-relaxed px-4 pb-3 pt-1">{{ $item['a'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results -->
            <div x-show="search !== ''" x-cloak class="text-center py-12 hidden">
                <p class="text-dark-400 text-sm">Tidak ada hasil untuk pencarian Anda. Coba kata kunci lain.</p>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="card p-8 mt-10 text-center">
            <h2 class="text-xl font-bold font-display text-dark-900 mb-2">Masih Butuh Bantuan?</h2>
            <p class="text-sm text-dark-500 mb-6 max-w-lg mx-auto">Jika pertanyaan Anda tidak terjawab di atas, jangan ragu untuk menghubungi tim dukungan kami.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:support@tokoku.id" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <span>Email Support</span>
                </a>
                <a href="{{ route('legal.terms') }}" class="btn-secondary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span>Syarat & Ketentuan</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
