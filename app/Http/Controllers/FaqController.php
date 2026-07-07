<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqCategories = [
            [
                'title' => 'Pembelian & Pesanan',
                'icon' => 'shopping',
                'questions' => [
                    [
                        'q' => 'Bagaimana cara membuat pesanan?',
                        'a' => 'Pilih produk yang ingin Anda beli, klik "Tambah ke Keranjang", lalu masuk ke halaman keranjang dan klik "Checkout". Pilih alamat pengiriman, kurir, dan metode pembayaran, kemudian konfirmasi pesanan Anda.',
                    ],
                    [
                        'q' => 'Berapa lama estimasi pengiriman?',
                        'a' => 'Estimasi pengiriman tergantung pada kurir yang dipilih dan lokasi tujuan. Umumnya 1-3 hari untuk wilayah yang sama, 2-5 hari untuk antar pulau, dan 3-7 hari untuk daerah terpencil.',
                    ],
                    [
                        'q' => 'Bagaimana cara melacak pesanan saya?',
                        'a' => 'Setelah pesanan dikirim, penjual akan memasukkan nomor pelacakan. Anda dapat melihat status pesanan dan nomor pelacakan di halaman "Pesanan Saya" pada dashboard akun Anda.',
                    ],
                    [
                        'q' => 'Bisakah saya membatalkan pesanan?',
                        'a' => 'Pesanan dapat dibatalkan selama status masih "Menunggu Pembayaran" atau "Dibayar" (sebelum dikirim). Masuk ke halaman detail pesanan dan klik "Batalkan Pesanan". Dana akan dikembalikan jika pembayaran sudah dilakukan.',
                    ],
                    [
                        'q' => 'Bisakah saya memesan ulang pesanan sebelumnya?',
                        'a' => 'Ya, pada halaman detail pesanan yang sudah selesai, tersedia tombol "Pesan Uang" yang akan menambahkan produk-produk dari pesanan tersebut ke keranjang Anda secara otomatis.',
                    ],
                ],
            ],
            [
                'title' => 'Pembayaran',
                'icon' => 'payment',
                'questions' => [
                    [
                        'q' => 'Metode pembayaran apa saja yang tersedia?',
                        'a' => 'Kami mendukung pembayaran melalui Midtrans (kartu kredit/debit, transfer bank, e-wallet seperti GoPay dan OVO) serta Cash on Delivery (COD) untuk pesanan tertentu.',
                    ],
                    [
                        'q' => 'Apakah pembayaran saya aman?',
                        'a' => 'Ya, semua pembayaran non-COD diproses melalui Midtrans dengan enkripsi dan standar keamanan yang tinggi. TokoKu tidak menyimpan data kartu kredit Anda.',
                    ],
                    [
                        'q' => 'Bagaimana jika pembayaran gagal?',
                        'a' => 'Jika pembayaran gagal, pesanan Anda tetap berstatus "Menunggu Pembayaran". Anda dapat mencoba membayar kembali melalui halaman detail pesanan sebelum pesanan dibatalkan otomatis (24 jam).',
                    ],
                    [
                        'q' => 'Apakah ada voucher atau diskon?',
                        'a' => 'Ya, TokoKu menyediakan voucher platform dan voucher dari penjual. Anda dapat memasukkan kode voucher saat checkout untuk mendapatkan diskon. Voucher memiliki syarat minimal pembelian dan masa berlaku.',
                    ],
                ],
            ],
            [
                'title' => 'Pengiriman & Retur',
                'icon' => 'shipping',
                'questions' => [
                    [
                        'q' => 'Kurir apa saja yang tersedia?',
                        'a' => 'Kami mendukung berbagai kurir seperti JNE, J&T, SiCepat, POS Indonesia, Tiki, dan Anteraja. Pilihan kurir dapat berbeda tergantung lokasi penjual dan tujuan.',
                    ],
                    [
                        'q' => 'Bagaimana cara mengajukan retur/pengembalian?',
                        'a' => 'Pengembalian dapat diajukan untuk pesanan dengan status "Dikirim" atau "Selesai". Buka halaman detail pesanan, klik "Ajukan Pengembalian", isi alasan dan deskripsi, lalu submit. Admin akan meninjau pengajuan Anda.',
                    ],
                    [
                        'q' => 'Berapa lama proses retur?',
                        'a' => 'Proses retur biasanya membutuhkan 3-5 hari kerja sejak pengajuan diajukan. Anda akan menerima notifikasi saat status retur diperbarui (disetujui, ditolak, atau dikembalikan).',
                    ],
                    [
                        'q' => 'Apakah ongkos kirim bisa direfund?',
                        'a' => 'Ongkos kirim dapat direfund jika pengembalian disebabkan oleh kesalahan penjual (produk rusak, salah kirim, atau tidak sesuai deskripsi). Refund ongkir tidak berlaku untuk perubahan keputusan pembeli.',
                    ],
                ],
            ],
            [
                'title' => 'Akun & Keamanan',
                'icon' => 'account',
                'questions' => [
                    [
                        'q' => 'Bagaimana cara mendaftar akun?',
                        'a' => 'Klik tombol "Daftar" di halaman utama, isi nama, email, dan kata sandi. Anda akan menerima email verifikasi untuk mengaktifkan akun. Setelah terverifikasi, Anda dapat mulai berbelanja.',
                    ],
                    [
                        'q' => 'Bagaimana cara mengubah kata sandi?',
                        'a' => 'Masuk ke halaman "Profil" → "Ubah Kata Sandi". Masukkan kata sandi saat ini dan kata sandi baru, lalu konfirmasi. Pastikan kata sandi baru memenuhi standar keamanan yang ditentukan.',
                    ],
                    [
                        'q' => 'Apa yang harus dilakukan jika lupa kata sandi?',
                        'a' => 'Klik "Lupa Kata Sandi?" di halaman login. Masukkan email Anda, dan kami akan mengirimkan tautan reset kata sandi. Tautan ini berlaku selama 60 menit.',
                    ],
                    [
                        'q' => 'Bagaimana cara mendaftar sebagai penjual?',
                        'a' => 'Setelah memiliki akun sebagai pembeli, masuk ke halaman "Jadi Seller" dari dashboard. Isi nama toko, kota, dan deskripsi toko. Admin akan meninjau pendaftaran Anda dalam 1-3 hari kerja.',
                    ],
                ],
            ],
            [
                'title' => 'Penjualan (Seller)',
                'icon' => 'seller',
                'questions' => [
                    [
                        'q' => 'Bagaimana cara menambahkan produk?',
                        'a' => 'Setelah akun Anda disetujui sebagai seller, masuk ke Dashboard Seller → Produk → "Tambah Produk". Isi nama, kategori, harga, stok, deskripsi, dan unggah foto produk (maksimal 5 foto).',
                    ],
                    [
                        'q' => 'Bagaimana cara mengelola pesanan?',
                        'a' => 'Masuk ke Dashboard Seller → Pesanan. Anda dapat melihat semua pesanan untuk produk Anda, memperbarui status (bayar → kirim → selesai), dan memasukkan nomor pelacakan.',
                    ],
                    [
                        'q' => 'Bagaimana cara menarik penghasilan (payout)?',
                        'a' => 'Masuk ke Dashboard Seller → Pencairan. Pastikan penghasilan Anda sudah melebihi minimum pencairan (Rp 100.000). Isi data rekening bank dan ajukan pencairan. Admin akan memproses dalam 3-5 hari kerja.',
                    ],
                    [
                        'q' => 'Apakah seller bisa membuat voucher?',
                        'a' => 'Ya, seller dapat membuat voucher khusus untuk produk mereka. Masuk ke Dashboard Seller → Voucher → "Buat Voucher". Voucher seller hanya berlaku untuk produk dari toko tersebut.',
                    ],
                    [
                        'q' => 'Bagaimana cara melihat laporan penjualan?',
                        'a' => 'Dashboard Seller → Laporan menyediakan ringkasan pendapatan, jumlah pesanan, produk terlaris, dan grafik penjualan. Anda juga dapat mengunduh laporan dalam format PDF atau CSV.',
                    ],
                ],
            ],
        ];

        return view('faq.index', compact('faqCategories'));
    }
}
