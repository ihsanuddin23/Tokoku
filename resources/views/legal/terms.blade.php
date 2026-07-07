<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Syarat & Ketentuan</span>
        </div>

        <div class="card p-8 sm:p-10">
            <h1 class="text-3xl font-bold font-display text-dark-900 mb-2">Syarat & Ketentuan</h1>
            <p class="text-sm text-dark-400 mb-8">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

            <div class="prose prose-sm max-w-none text-dark-600 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">1. Penerimaan Ketentuan</h2>
                    <p>Dengan mengakses dan menggunakan platform TokoKu, Anda menyetujui untuk terikat oleh Syarat & Ketentuan ini. Jika Anda tidak menyetujui salah satu bagian dari ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">2. Definisi</h2>
                    <p>"Platform" merujuk pada aplikasi TokoKu. "Pengguna" merujuk pada setiap individu yang mengakses platform, termasuk pembeli dan penjual. "Penjual" adalah pengguna terverifikasi yang menjual produk. "Pembeli" adalah pengguna yang membeli produk.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">3. Akun Pengguna</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Pengguna wajib mendaftar dengan data yang benar, akurat, dan terkini.</li>
                        <li>Pengguna bertanggung jawab menjaga keamanan akun dan kata sandi.</li>
                        <li>Akun yang terdeteksi melakukan aktivitas penipuan akan dinonaktifkan tanpa pemberitahuan.</li>
                        <li>Penjual wajib melalui proses verifikasi sebelum dapat berjualan.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">4. Transaksi & Pembayaran</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Semua transaksi dilakukan melalui metode pembayaran yang tersedia di platform (Midtrans atau COD).</li>
                        <li>Harga produk ditentukan oleh penjual. Platform tidak bertanggung jawab atas kesalahan harga akibat kelalaian penjual.</li>
                        <li>Pembayaran melalui Midtrans akan diproses sesuai ketentuan penyedia layanan pembayaran.</li>
                        <li>Pesanan yang tidak dibayar dalam 24 jam akan dibatalkan secara otomatis.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">5. Pengiriman</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Pengiriman dilakukan oleh penjual menggunakan kurir yang dipilih pembeli.</li>
                        <li>Estimasi waktu pengiriman tergantung pada kurir dan lokasi tujuan.</li>
                        <li>Platform tidak bertanggung jawab atas keterlambatan pengiriman yang disebabkan oleh pihak kurir.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">6. Pembatalan & Pengembalian</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Pembeli dapat membatalkan pesanan selama status masih "Menunggu Pembayaran" atau "Dibayar" (sebelum dikirim).</li>
                        <li>Pengembalian dana untuk pesanan yang sudah dibayar akan diproses melalui Midtrans.</li>
                        <li>Produk yang diterima rusak atau tidak sesuai dapat diajukan komplain kepada penjual melalui platform.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">7. Tanggung Jawab Penjual</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Penjual bertanggung jawab atas kualitas, deskripsi, dan ketersediaan produk yang dijual.</li>
                        <li>Penjual wajib mengirim produk tepat waktu setelah pesanan dibayar.</li>
                        <li>Penjual dilarang menjual produk terlarang, produk palsu, atau produk yang melanggar hak kekayaan intelektual.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">8. Ulasan & Rating</h2>
                    <p>Pembeli dapat memberikan ulasan dan rating setelah pesanan selesai. Ulasan harus jujur dan tidak mengandung ujaran kebencian, SARA, atau konten yang melanggar hukum. Platform berhak menghapus ulasan yang melanggar ketentuan ini.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">9. Perubahan Ketentuan</h2>
                    <p>Platform berhak mengubah Syarat & Ketentuan ini sewaktu-waktu. Perubahan akan berlaku efektif sejak dipublikasikan di halaman ini. Pengguna disarankan untuk meninjau halaman ini secara berkala.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">10. Kontak</h2>
                    <p>Untuk pertanyaan terkait Syarat & Ketentuan ini, silakan hubungi kami melalui email yang tersedia di halaman kontak.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
