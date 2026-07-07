<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-xs text-dark-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-dark-600 font-medium">Kebijakan Privasi</span>
        </div>

        <div class="card p-8 sm:p-10">
            <h1 class="text-3xl font-bold font-display text-dark-900 mb-2">Kebijakan Privasi</h1>
            <p class="text-sm text-dark-400 mb-8">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

            <div class="prose prose-sm max-w-none text-dark-600 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">1. Pendahuluan</h2>
                    <p>TokoKu ("kami") berkomitmen melindungi privasi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi Anda sesuai dengan Undang-Undang Perlindungan Data Pribadi (UU PDP) Republik Indonesia.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">2. Data yang Kami Kumpulkan</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><strong>Data akun:</strong> Nama, email, nomor telepon, kata sandi (terenkripsi), foto profil.</li>
                        <li><strong>Data alamat:</strong> Alamat pengiriman, penerima, nomor telepon penerima.</li>
                        <li><strong>Data transaksi:</strong> Riwayat pesanan, metode pembayaran, status pembayaran.</li>
                        <li><strong>Data toko (penjual):</strong> Nama toko, deskripsi, logo, banner, kota.</li>
                        <li><strong>Data teknis:</strong> Alamat IP, user agent, cookies, log aktivitas.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">3. Penggunaan Data</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Memproses pesanan dan pembayaran.</li>
                        <li>Mengirim notifikasi status pesanan via email dan notifikasi in-app.</li>
                        <li>Mengelola akun pengguna dan verifikasi penjual.</li>
                        <li>Meningkatkan layanan, keamanan, dan pengalaman pengguna.</li>
                        <li>Memenuhi kewajiban hukum dan regulasi yang berlaku.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">4. Pembagian Data kepada Pihak Ketiga</h2>
                    <p>Kami tidak menjual data pribadi Anda. Data dapat dibagikan kepada:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><strong>Penyedia pembayaran (Midtrans):</strong> Untuk memproses transaksi.</li>
                        <li><strong>Kurir pengiriman:</strong> Untuk mengirim pesanan (nama penerima, alamat, telepon).</li>
                        <li><strong>Otoritas hukum:</strong> Jika diwajibkan oleh hukum.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">5. Keamanan Data</h2>
                    <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data Anda, termasuk enkripsi kata sandi, HTTPS, CSRF protection, dan pembatasan akses internal. Namun, tidak ada metode transmisi internet yang 100% aman.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">6. Hak Pengguna</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Hak untuk mengakses data pribadi Anda.</li>
                        <li>Hak untuk memperbaiki data yang tidak akurat.</li>
                        <li>Hak untuk menghapus akun dan data terkait.</li>
                        <li>Hak untuk menolak pemrosesan data tertentu.</li>
                    </ul>
                    <p class="mt-2">Untuk menggunakan hak-hak ini, silakan hubungi kami melalui email.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">7. Cookies</h2>
                    <p>Platform menggunakan cookies untuk menjaga sesi login, preferensi pengguna, dan analitik. Anda dapat mengatur browser untuk menolak cookies, namun beberapa fitur mungkin tidak berfungsi optimal.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">8. Penyimpanan Data</h2>
                    <p>Data pribadi disimpan selama akun Anda aktif. Data transaksi disimpan sesuai ketentuan hukum yang berlaku. Setelah akun dihapus, data akan dihapus permanen dalam waktu 30 hari, kecuali data yang diwajibkan disimpan oleh hukum.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">9. Perubahan Kebijakan</h2>
                    <p>Kami dapat memperbarui Kebijakan Privasi ini sewaktu-waktu. Perubahan akan diberitahukan melalui email atau notifikasi in-app.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-dark-900 mb-2">10. Kontak</h2>
                    <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami melalui email yang tersedia di halaman kontak.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
