<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card p-16 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-primary-500/5 rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h2 class="text-lg font-semibold font-display text-dark-900 mb-2">Keranjang Kosong</h2>
                <p class="text-sm text-dark-400 max-w-md mx-auto mb-6">Tambahkan produk ke keranjang sebelum checkout.</p>
                <a href="{{ route('products.index') }}" class="btn-primary inline-flex">Mulai Belanja</a>
            </div>
        </div>
    </div>
</x-app-layout>
