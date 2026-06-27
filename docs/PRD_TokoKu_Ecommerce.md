# PRD — TokoKu: Platform E-Commerce

> **Stack:** Laravel 12 · Tailwind CSS · MySQL · Midtrans · Chart.js  
> **Versi:** 1.0.0 | **Tujuan:** Proyek Portofolio Fresh Graduate

---

## Daftar Isi

1. [Overview Proyek](#1-overview-proyek)
2. [Stack Teknologi](#2-stack-teknologi)
3. [User Roles & Hak Akses](#3-user-roles--hak-akses)
4. [Rencana Fitur Lengkap](#4-rencana-fitur-lengkap)
5. [Struktur Database](#5-struktur-database)
6. [Daftar Halaman & Routing](#6-daftar-halaman--routing)
7. [Timeline Pengembangan](#7-timeline-pengembangan)
8. [Catatan Teknis Penting](#8-catatan-teknis-penting)

---

## 1. Overview Proyek

### 1.1 Latar Belakang

TokoKu adalah platform e-commerce berbasis web yang dirancang sebagai proyek portofolio untuk mendemonstrasikan kemampuan full-stack development menggunakan Laravel 12 dan Tailwind CSS. Proyek ini mensimulasikan ekosistem jual-beli online nyata dengan tiga peran pengguna: Pembeli, Penjual, dan Admin.

Proyek ini dibuat untuk menunjukkan penguasaan teknologi modern yang relevan dengan industri, termasuk integrasi payment gateway (Midtrans), manajemen state kompleks, dashboard analitik, dan desain sistem database relasional.

### 1.2 Tujuan Proyek

- Membangun sistem e-commerce yang fungsional sebagai portofolio
- Mendemonstrasikan kemampuan full-stack: backend Laravel + frontend Tailwind CSS
- Mengimplementasikan integrasi Midtrans payment gateway (sandbox)
- Menampilkan kemampuan desain database relasional yang terstruktur
- Menunjukkan pemahaman terhadap multi-role authentication dan authorization

### 1.3 Lingkup Proyek

Proyek ini mencakup tiga modul utama yang saling terintegrasi:

- **Modul Pembeli** — Browsing produk, keranjang, checkout, pembayaran, riwayat order
- **Modul Penjual (Seller)** — Manajemen toko, produk, stok, dan laporan penjualan
- **Modul Admin** — Pengawasan platform, manajemen user, verifikasi seller, laporan global

---

## 2. Stack Teknologi

### 2.1 Backend

| Teknologi | Versi | Fungsi |
|---|---|---|
| Laravel | 12.x | Framework utama PHP (MVC, Eloquent ORM, Middleware) |
| PHP | 8.2+ | Bahasa pemrograman server-side |
| MySQL | 8.0+ | Database relasional utama |
| Laravel Sanctum | 3.x | Autentikasi berbasis session/token |
| Midtrans PHP SDK | Latest | Integrasi payment gateway Indonesia |
| DomPDF | Latest | Export laporan ke PDF |
| Maatwebsite Excel | 3.x | Export laporan ke Excel (.xlsx) |

### 2.2 Frontend

| Teknologi | Versi | Fungsi |
|---|---|---|
| Tailwind CSS | 3.x | Utility-first CSS framework, styling responsif |
| Alpine.js | 3.x | Interaktivitas ringan tanpa jQuery (dropdown, modal, toggle) |
| Chart.js | 4.x | Visualisasi data: grafik penjualan, statistik |
| Vanilla JavaScript | ES6+ | Fetch API, async/await, manipulasi DOM |
| Blade (Laravel) | — | Template engine server-side rendering |

### 2.3 Tools & DevOps

| Tool | Fungsi |
|---|---|
| Git + GitHub | Version control, branching, pull request |
| Laragon / XAMPP | Environment development lokal |
| Composer | Dependency manager PHP |
| NPM + Vite | Asset bundling dan kompilasi Tailwind CSS |
| Postman | Testing REST API endpoint |
| Railway / Render | Deployment gratis untuk demo live |

---

## 3. User Roles & Hak Akses

| Fitur / Aksi | Pembeli | Penjual | Admin |
|---|:---:|:---:|:---:|
| Registrasi & Login | ✓ | ✓ | ✓ |
| Browse & Search Produk | ✓ | ✓ | ✓ |
| Keranjang Belanja | ✓ | — | — |
| Checkout & Pembayaran | ✓ | — | — |
| Riwayat Pesanan | ✓ | — | — |
| Ulasan Produk | ✓ | — | — |
| Manajemen Toko | — | ✓ | — |
| Manajemen Produk | — | ✓ | — |
| Laporan Penjualan Toko | — | ✓ | — |
| Manajemen Semua User | — | — | ✓ |
| Verifikasi Seller | — | — | ✓ |
| Laporan Platform Global | — | — | ✓ |
| Manajemen Kategori | — | — | ✓ |
| Pengaturan Banner/Promo | — | — | ✓ |

---

## 4. Rencana Fitur Lengkap

### 4.1 Autentikasi & Manajemen Akun

> Berlaku untuk semua role

- Registrasi akun dengan validasi email unik
  - Form: nama lengkap, email, password, konfirmasi password
- Login dengan email dan password
  - Remember me (session panjang)
  - Redirect otomatis berdasarkan role setelah login
- Forgot password via email (Laravel built-in Password Reset)
- Edit profil: nama, foto avatar, nomor HP, alamat default
- Ganti password dari halaman profil
- Daftar sebagai Seller dari akun Pembeli (form pengajuan toko)

---

### 4.2 Modul Pembeli

#### 4.2.1 Halaman Beranda

- Banner/slider promosi (dikontrol Admin)
- Kategori produk dengan ikon
- Produk unggulan (featured products)
- Produk terbaru
- Toko-toko terpopuler

#### 4.2.2 Browse & Search Produk

- Halaman katalog produk dengan pagination
- Filter produk: kategori, harga (range slider), rating, kondisi (baru/bekas)
- Sort produk: terlaris, terbaru, harga terendah/tertinggi, rating
- Search bar dengan live search (Fetch API + Alpine.js)
- Halaman detail produk: foto gallery, deskripsi, spesifikasi, stok, info toko
- Rating dan ulasan dari pembeli lain

#### 4.2.3 Keranjang Belanja

- Tambah produk ke keranjang dari halaman detail atau katalog
- Update jumlah produk (increment/decrement)
- Hapus produk dari keranjang
- Kalkulasi subtotal, ongkir, dan total otomatis
- Keranjang tersimpan di database (bukan hanya session)

#### 4.2.4 Checkout & Pembayaran

- Pilih atau input alamat pengiriman
- Pilih kurir (JNE, J&T, Sicepat — simulasi tanpa API real)
- Review order sebelum pembayaran
- Integrasi Midtrans Snap (sandbox):
  - Transfer bank (BCA, Mandiri, BNI virtual account)
  - QRIS
  - Kartu kredit (sandbox)
- Halaman konfirmasi order setelah pembayaran sukses
- Notifikasi status pembayaran via Midtrans webhook

#### 4.2.5 Manajemen Pesanan

- Daftar semua pesanan dengan status: Menunggu Pembayaran, Dibayar, Diproses, Dikirim, Selesai, Dibatalkan
- Detail pesanan: produk, jumlah, harga, status, resi pengiriman
- Konfirmasi pesanan diterima (ubah status ke Selesai)
- Batalkan pesanan (hanya jika masih Menunggu Pembayaran)
- Beri ulasan dan rating setelah pesanan selesai

---

### 4.3 Modul Penjual (Seller)

#### 4.3.1 Dashboard Seller

- Statistik ringkasan: total penjualan hari ini, bulan ini, total order, produk aktif
- Grafik penjualan mingguan dan bulanan (Chart.js — line & bar chart)
- Daftar order terbaru yang perlu diproses
- Notifikasi: order baru, stok menipis

#### 4.3.2 Manajemen Toko

- Edit informasi toko: nama, deskripsi, logo, banner, kota asal
- Halaman profil toko publik yang bisa dilihat pembeli

#### 4.3.3 Manajemen Produk

- Tambah produk: nama, deskripsi, kategori, harga, stok, kondisi, berat, foto (multiple)
- Edit dan hapus produk
- Bulk update stok
- Aktifkan/nonaktifkan produk
- Tabel produk dengan filter dan pencarian

#### 4.3.4 Manajemen Pesanan Seller

- Daftar order yang masuk ke toko
- Update status order: Proses → Kirim (input nomor resi)
- Detail order per transaksi

#### 4.3.5 Laporan Toko

- Laporan penjualan harian, mingguan, bulanan
- Tabel detail transaksi berhasil
- Export laporan ke PDF (DomPDF)
- Export laporan ke Excel (Maatwebsite Excel)

---

### 4.4 Modul Admin

#### 4.4.1 Dashboard Admin

- Statistik platform: total user, seller aktif, total transaksi, total revenue
- Grafik transaksi dan pendapatan platform (Chart.js)
- Daftar aktivitas terbaru (log transaksi, user baru, seller baru)

#### 4.4.2 Manajemen User

- Tabel semua user dengan filter role dan status
- Detail profil user
- Aktifkan / nonaktifkan (ban) akun user

#### 4.4.3 Verifikasi Seller

- Daftar pengajuan seller yang belum diverifikasi
- Review informasi pengajuan toko
- Setujui atau tolak pengajuan seller

#### 4.4.4 Manajemen Kategori

- CRUD kategori produk (nama, ikon, slug)
- Nonaktifkan kategori

#### 4.4.5 Manajemen Banner & Promosi

- CRUD banner untuk halaman beranda
- Upload gambar banner, set urutan tampil, aktif/nonaktif

#### 4.4.6 Laporan Global

- Laporan transaksi seluruh platform dalam rentang waktu tertentu
- Export PDF dan Excel

---

## 5. Struktur Database

### 5.1 Daftar Tabel

| No | Nama Tabel | Deskripsi |
|---|---|---|
| 1 | `users` | Data semua pengguna (buyer, seller, admin) |
| 2 | `seller_profiles` | Profil dan informasi toko seller |
| 3 | `categories` | Kategori produk |
| 4 | `products` | Data produk |
| 5 | `product_images` | Foto-foto produk (relasi ke products) |
| 6 | `addresses` | Alamat pengiriman user |
| 7 | `carts` | Keranjang belanja user |
| 8 | `cart_items` | Item dalam keranjang belanja |
| 9 | `orders` | Data pesanan/transaksi |
| 10 | `order_items` | Detail produk dalam satu pesanan |
| 11 | `payments` | Data pembayaran dan status Midtrans |
| 12 | `reviews` | Ulasan dan rating produk |
| 13 | `banners` | Banner/slider halaman beranda |
| 14 | `seller_verifications` | Pengajuan verifikasi seller |

---

### 5.2 Detail Struktur Tabel

#### `users`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| name | VARCHAR(100) | Nama lengkap user |
| email | VARCHAR(100) UNIQUE | Email login |
| email_verified_at | TIMESTAMP NULL | Waktu verifikasi email |
| password | VARCHAR(255) | Password ter-hash (bcrypt) |
| role | ENUM('buyer','seller','admin') | Peran user |
| phone | VARCHAR(20) NULL | Nomor telepon |
| avatar | VARCHAR(255) NULL | Path foto profil |
| is_active | TINYINT(1) DEFAULT 1 | Status akun (1=aktif, 0=banned) |
| remember_token | VARCHAR(100) NULL | Token remember me |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `seller_profiles`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| user_id | BIGINT UNSIGNED FK | Relasi ke users.id |
| store_name | VARCHAR(100) | Nama toko |
| store_slug | VARCHAR(100) UNIQUE | Slug URL toko |
| description | TEXT NULL | Deskripsi toko |
| logo | VARCHAR(255) NULL | Path logo toko |
| banner | VARCHAR(255) NULL | Path banner toko |
| city | VARCHAR(100) | Kota asal toko |
| is_verified | TINYINT(1) DEFAULT 0 | Status verifikasi admin |
| is_active | TINYINT(1) DEFAULT 1 | Toko aktif atau tidak |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `categories`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| name | VARCHAR(100) | Nama kategori |
| slug | VARCHAR(100) UNIQUE | Slug URL |
| icon | VARCHAR(100) NULL | Nama ikon (Heroicons) |
| is_active | TINYINT(1) DEFAULT 1 | Status aktif |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `products`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| seller_id | BIGINT UNSIGNED FK | Relasi ke seller_profiles.id |
| category_id | BIGINT UNSIGNED FK | Relasi ke categories.id |
| name | VARCHAR(200) | Nama produk |
| slug | VARCHAR(200) UNIQUE | Slug URL produk |
| description | TEXT | Deskripsi lengkap |
| price | DECIMAL(15,2) | Harga produk |
| stock | INT UNSIGNED DEFAULT 0 | Jumlah stok |
| weight | INT UNSIGNED | Berat dalam gram |
| condition | ENUM('new','used') | Kondisi produk |
| is_active | TINYINT(1) DEFAULT 1 | Tampil di katalog atau tidak |
| sold_count | INT UNSIGNED DEFAULT 0 | Jumlah terjual |
| average_rating | DECIMAL(3,2) DEFAULT 0 | Rating rata-rata |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `product_images`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| product_id | BIGINT UNSIGNED FK | Relasi ke products.id |
| image_path | VARCHAR(255) | Path gambar |
| is_primary | TINYINT(1) DEFAULT 0 | Foto utama produk |
| order | INT DEFAULT 0 | Urutan tampil |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `addresses`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| user_id | BIGINT UNSIGNED FK | Relasi ke users.id |
| label | VARCHAR(50) | Label alamat (Rumah, Kantor, dll) |
| recipient_name | VARCHAR(100) | Nama penerima |
| phone | VARCHAR(20) | Nomor HP penerima |
| province | VARCHAR(100) | Provinsi |
| city | VARCHAR(100) | Kota/Kabupaten |
| district | VARCHAR(100) | Kecamatan |
| postal_code | VARCHAR(10) | Kode pos |
| full_address | TEXT | Alamat lengkap |
| is_default | TINYINT(1) DEFAULT 0 | Alamat utama |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `carts`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| user_id | BIGINT UNSIGNED FK UNIQUE | Relasi ke users.id (1 user = 1 cart) |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `cart_items`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| cart_id | BIGINT UNSIGNED FK | Relasi ke carts.id |
| product_id | BIGINT UNSIGNED FK | Relasi ke products.id |
| quantity | INT UNSIGNED | Jumlah item |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `orders`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| order_code | VARCHAR(50) UNIQUE | Kode order (misal: ORD-20250601-001) |
| buyer_id | BIGINT UNSIGNED FK | Relasi ke users.id |
| seller_id | BIGINT UNSIGNED FK | Relasi ke seller_profiles.id |
| address_id | BIGINT UNSIGNED FK | Relasi ke addresses.id |
| subtotal | DECIMAL(15,2) | Total harga produk |
| shipping_cost | DECIMAL(15,2) DEFAULT 0 | Biaya pengiriman |
| total_amount | DECIMAL(15,2) | Total pembayaran |
| courier | VARCHAR(50) NULL | Kurir yang dipilih |
| tracking_number | VARCHAR(100) NULL | Nomor resi |
| status | ENUM('pending_payment','paid','processing','shipped','completed','cancelled') | Status pesanan |
| notes | TEXT NULL | Catatan pembeli |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `order_items`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| order_id | BIGINT UNSIGNED FK | Relasi ke orders.id |
| product_id | BIGINT UNSIGNED FK | Relasi ke products.id |
| product_name | VARCHAR(200) | Snapshot nama produk saat order |
| product_price | DECIMAL(15,2) | Snapshot harga saat order |
| quantity | INT UNSIGNED | Jumlah dipesan |
| subtotal | DECIMAL(15,2) | price × quantity |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `payments`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| order_id | BIGINT UNSIGNED FK UNIQUE | Relasi ke orders.id |
| midtrans_order_id | VARCHAR(100) UNIQUE | ID order yang dikirim ke Midtrans |
| midtrans_transaction_id | VARCHAR(255) NULL | Transaction ID dari Midtrans |
| payment_type | VARCHAR(50) NULL | Metode bayar (bank_transfer, qris, dll) |
| gross_amount | DECIMAL(15,2) | Total yang dibayar |
| transaction_status | VARCHAR(50) | Status Midtrans (pending, settlement, dll) |
| snap_token | VARCHAR(255) NULL | Token Midtrans Snap |
| paid_at | TIMESTAMP NULL | Waktu pembayaran berhasil |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `reviews`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| order_item_id | BIGINT UNSIGNED FK UNIQUE | Relasi ke order_items.id (1 review/item) |
| buyer_id | BIGINT UNSIGNED FK | Relasi ke users.id |
| product_id | BIGINT UNSIGNED FK | Relasi ke products.id |
| rating | TINYINT UNSIGNED | Rating 1–5 bintang |
| comment | TEXT NULL | Komentar ulasan |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `banners`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| title | VARCHAR(100) | Judul banner |
| image_path | VARCHAR(255) | Path gambar banner |
| link | VARCHAR(255) NULL | URL tujuan klik banner |
| order | INT DEFAULT 0 | Urutan tampil |
| is_active | TINYINT(1) DEFAULT 1 | Aktif atau tidak |
| created_at / updated_at | TIMESTAMP | Timestamp |

#### `seller_verifications`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED PK AI | Primary key |
| user_id | BIGINT UNSIGNED FK | Relasi ke users.id |
| store_name | VARCHAR(100) | Nama toko yang diajukan |
| city | VARCHAR(100) | Kota asal toko |
| description | TEXT NULL | Deskripsi toko |
| status | ENUM('pending','approved','rejected') DEFAULT 'pending' | Status verifikasi |
| admin_note | TEXT NULL | Catatan/alasan dari admin |
| reviewed_at | TIMESTAMP NULL | Waktu review admin |
| created_at / updated_at | TIMESTAMP | Timestamp |

---

## 6. Daftar Halaman & Routing

### 6.1 Halaman Publik (Guest & Semua User)

| URL | Halaman | Keterangan |
|---|---|---|
| `/` | Beranda | Banner, kategori, produk unggulan, toko populer |
| `/products` | Katalog Produk | Grid produk dengan filter dan pagination |
| `/products/{slug}` | Detail Produk | Foto, deskripsi, ulasan, tombol add to cart |
| `/stores/{slug}` | Profil Toko | Info toko dan daftar produknya |
| `/login` | Login | Form login |
| `/register` | Registrasi | Form registrasi akun baru |
| `/forgot-password` | Lupa Password | Form reset password via email |

### 6.2 Halaman Pembeli (Auth: buyer/seller)

| URL | Halaman | Keterangan |
|---|---|---|
| `/cart` | Keranjang Belanja | Daftar item, update qty, kalkulasi total |
| `/checkout` | Checkout | Pilih alamat, kurir, review order |
| `/checkout/payment` | Pembayaran | Midtrans Snap popup payment |
| `/orders` | Daftar Pesanan | Semua riwayat order dengan status |
| `/orders/{code}` | Detail Pesanan | Detail produk, status, resi |
| `/profile` | Profil | Edit data diri dan foto |
| `/profile/addresses` | Alamat | CRUD alamat pengiriman |
| `/become-seller` | Daftar Seller | Form pengajuan membuka toko |

### 6.3 Halaman Seller Dashboard

| URL | Halaman | Keterangan |
|---|---|---|
| `/seller/dashboard` | Dashboard | Statistik dan grafik penjualan |
| `/seller/products` | Produk | Tabel CRUD produk |
| `/seller/products/create` | Tambah Produk | Form tambah produk baru |
| `/seller/products/{id}/edit` | Edit Produk | Form edit produk |
| `/seller/orders` | Pesanan Masuk | Daftar order yang perlu diproses |
| `/seller/orders/{code}` | Detail Order | Detail dan update status/resi |
| `/seller/reports` | Laporan | Grafik + tabel + export PDF/Excel |
| `/seller/store` | Pengaturan Toko | Edit info toko, logo, banner |

### 6.4 Halaman Admin Dashboard

| URL | Halaman | Keterangan |
|---|---|---|
| `/admin/dashboard` | Dashboard | Statistik platform dan grafik global |
| `/admin/users` | Manajemen User | Tabel user, ban/aktifkan akun |
| `/admin/sellers` | Verifikasi Seller | Daftar pengajuan dan status verifikasi |
| `/admin/categories` | Kategori | CRUD kategori produk |
| `/admin/banners` | Banner | CRUD banner halaman beranda |
| `/admin/reports` | Laporan Global | Laporan seluruh transaksi platform |

---

## 7. Timeline Pengembangan

| Fase | Estimasi | Scope |
|---|---|---|
| **Fase 1:** Setup & Auth | 3–4 hari | Install Laravel 12 + Tailwind, setup DB, CRUD user, multi-role auth, middleware |
| **Fase 2:** Modul Produk | 5–7 hari | CRUD kategori, CRUD produk seller, upload foto multiple, halaman katalog + detail publik |
| **Fase 3:** Modul Pembeli | 5–7 hari | Keranjang belanja, checkout flow, manajemen alamat, riwayat order |
| **Fase 4:** Payment Gateway | 3–4 hari | Integrasi Midtrans Snap sandbox, webhook handler, konfirmasi bayar otomatis |
| **Fase 5:** Dashboard & Laporan | 4–5 hari | Dashboard seller + admin, Chart.js, export PDF/Excel |
| **Fase 6:** Polish & Deploy | 2–3 hari | UI refinement, testing, deployment ke Railway/Render, README GitHub |

> **Total estimasi:** 22–30 hari kerja

---

## 8. Catatan Teknis Penting

### 8.1 Struktur Folder Laravel (Rekomendasi)

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/
│       ├── Buyer/
│       ├── Seller/
│       └── Admin/
├── Models/
└── Services/
    ├── OrderService.php
    └── PaymentService.php

resources/
└── views/
    ├── layouts/
    ├── components/
    ├── buyer/
    ├── seller/
    └── admin/

routes/
└── web.php  → pakai Route::prefix() + middleware group
```

### 8.2 Midtrans Integration

- Gunakan mode **Sandbox** (tidak perlu uang nyata)
- Daftar akun gratis di [dashboard.midtrans.com](https://dashboard.midtrans.com)
- Install: `composer require midtrans/midtrans-php`
- Simpan Server Key dan Client Key di `.env` — **jangan di-commit ke GitHub**
- Implementasikan webhook endpoint untuk update status order otomatis

### 8.3 Tips Portofolio

- Buat **README.md** yang lengkap dengan screenshot tiap halaman utama
- Sertakan **ERD** (Entity Relationship Diagram) di README
- Deploy ke **Railway atau Render** agar bisa diakses interviewer secara live
- Buat **akun demo** untuk setiap role:
  - `demo_buyer@tokoku.test`
  - `demo_seller@tokoku.test`
  - `demo_admin@tokoku.test`
- Pastikan `.env` tidak ter-upload; sertakan `.env.example` dengan panduan pengisian

---

*PRD TokoKu v1.0.0 — Dibuat sebagai panduan proyek portofolio*
