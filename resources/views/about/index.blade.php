<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Tentang Kami</span>
        </div>

        <!-- Hero -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-2xl shadow-glow">
                    T
                </div>
                <span class="text-3xl font-bold font-display text-dark-900">TokoKu</span>
            </div>
            <p class="text-lg text-dark-500 max-w-2xl mx-auto leading-relaxed">
                Platform e-commerce yang menghubungkan pembeli dan penjual dalam satu ekosistem yang simpel, modern, dan terpercaya.
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mb-12">
            <div class="card p-6 text-center">
                <p class="text-3xl font-bold font-display text-primary-600">{{ number_format($stats['products']) }}</p>
                <p class="text-sm text-dark-400 mt-1">Produk Aktif</p>
            </div>
            <div class="card p-6 text-center">
                <p class="text-3xl font-bold font-display text-primary-600">{{ number_format($stats['sellers']) }}</p>
                <p class="text-sm text-dark-400 mt-1">Toko Terdaftar</p>
            </div>
            <div class="card p-6 text-center">
                <p class="text-3xl font-bold font-display text-primary-600">{{ number_format($stats['users']) }}</p>
                <p class="text-sm text-dark-400 mt-1">Pengguna</p>
            </div>
        </div>

        <!-- Story -->
        <div class="card p-8 sm:p-10 mb-8">
            <h2 class="text-2xl font-bold font-display text-dark-900 mb-4">Cerita Kami</h2>
            <div class="prose prose-sm max-w-none text-dark-600 space-y-4">
                <p>TokoKu lahir dari visi sederhana: membuat jual beli online menjadi mudah untuk semua orang di Indonesia. Kami percaya bahwa teknologi seharusnya menjadi jembatan, bukan penghalang.</p>
                <p>Sebagai platform e-commerce yang fokus pada UMKM dan penjual lokal, TokoKu menyediakan alat yang dibutuhkan untuk memulai dan mengembangkan bisnis online — dari manajemen produk, pemrosesan pesanan, hingga pencairan penghasilan yang transparan.</p>
                <p>Kami berkomitmen untuk terus berinovasi dan memberikan pengalaman terbaik bagi setiap pembeli dan penjual di platform kami.</p>
            </div>
        </div>

        <!-- Values -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6">
                <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.062-.18-2.087-.514-3.043z" /></svg>
                </div>
                <h3 class="text-base font-semibold text-dark-900 mb-2">Terpercaya</h3>
                <p class="text-sm text-dark-500">Setiap transaksi dilindungi dengan sistem keamanan berstandar tinggi dan pembayaran terenkripsi.</p>
            </div>
            <div class="card p-6">
                <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-base font-semibold text-dark-900 mb-2">Cepat & Mudah</h3>
                <p class="text-sm text-dark-500">Antarmuka yang intuitif dan proses checkout yang mulus untuk pengalaman belanja terbaik.</p>
            </div>
            <div class="card p-6">
                <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-base font-semibold text-dark-900 mb-2">Untuk Semua</h3>
                <p class="text-sm text-dark-500">Dari pembeli individu hingga UMKM, TokoKu dirancang untuk semua kalangan di Indonesia.</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="card p-8 text-center bg-gradient-to-br from-primary-50 to-secondary-50 border-primary-100">
            <h2 class="text-xl font-bold font-display text-dark-900 mb-2">Siap Bergabung?</h2>
            <p class="text-dark-500 mb-6">Mulai berbelanja atau berjualan di TokoKu hari ini.</p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
                <a href="{{ route('contact.index') }}" class="btn-secondary">Hubungi Kami</a>
            </div>
        </div>
    </div>
</x-app-layout>
