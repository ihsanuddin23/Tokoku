# TokoKu — E-Commerce Platform

[![Tests](https://github.com/ihsanuddin23/Tokoku/actions/workflows/tests.yml/badge.svg)](https://github.com/ihsanuddin23/Tokoku/actions/workflows/tests.yml)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.1-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Platform e-commerce **multi-role** (Buyer, Seller, Admin) dengan homepage modern, fitur transaksi lengkap, dan keamanan yang kuat. Dibangun sebagai proyek portofolio menggunakan Laravel 12, Tailwind CSS, dan Alpine.js.

**Status:** MVP Lengkap — Fase 1–6 selesai. Siap untuk demo dan deployment.

## Demo

- **Live Demo:** [https://tokoku-demo.example.com](https://tokoku-demo.example.com) *(ganti dengan URL Anda)*
- **Screenshots:** Lihat di bawah atau langsung ke folder [docs/screenshots/](docs/screenshots/)

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
- **Database:** MySQL (production) / SQLite (development)
- **Auth:** Laravel Breeze dengan multi-role (buyer, seller, admin)
- **Payment Gateway:** Midtrans Snap (sandbox)
- **PDF Export:** DomPDF (invoice & laporan)
- **Build Tool:** Vite

## Fitur MVP yang Tersedia

### Autentikasi & Pengguna
- Registrasi, login, logout dengan rate limiting
- Verifikasi email & reset password
- Multi-role: Buyer, Seller, Admin
- Middleware: role-based access, active user check, verified seller check
- Edit profil (nama, avatar, nomor HP)
- Ganti password
- Manajemen alamat pengiriman
- Daftar sebagai seller (dengan verifikasi admin)

### Katalog & Produk
- Homepage modern dengan banner slider, kategori, produk terlaris, flash sale, dan testimonial
- Katalog publik dengan filter (kategori, harga, kondisi, rating minimum) & sorting
- Halaman detail produk dengan produk terkait
- Halaman profil toko publik
- CRUD produk oleh seller dengan upload multiple foto (max 5)
- Bulk update stok oleh seller
- Filter & pencarian di tabel produk seller
- Aktifkan/nonaktifkan produk
- CRUD kategori oleh admin

### Transaksi
- Keranjang belanja (tambah, update qty, hapus)
- Checkout dengan pilihan alamat
- Integrasi Midtrans Snap (sandbox) — VA, QRIS, kartu kredit
- Webhook handler untuk konfirmasi pembayaran otomatis
- Manajemen pesanan (riwayat, detail, batalkan)
- Restorasi stok otomatis saat pesanan dibatalkan
- Seller dapat mengupdate status item pesanan (pending → paid → shipped → completed)
- Invoice PDF download per order

### Dashboard & Analytics
- **Seller Dashboard:** grafik penjualan 7 hari, stat cards (revenue harian/bulanan, total order, produk aktif), low stock alerts
- **Admin Dashboard:** grafik transaksi 7 hari, stat cards (total user, seller aktif, total transaksi, total revenue), transaksi & user terbaru
- Export laporan PDF untuk seller & admin dengan filter tanggal
- Notifikasi email: order baru ke seller, status update ke buyer, low stock alert

### Admin
- Verifikasi pendaftaran seller (approve/reject)
- Manajemen banner homepage
- Manajemen kategori
- Manajemen user (aktifkan/nonaktifkan)

### Keamanan
- CSRF protection di semua form
- XSS protection via Blade escaping
- Mass assignment protection yang ketat
- Ownership check di setiap resource sensitif
- File upload: tipe & ukuran dibatasi
- Rate limiting untuk auth & katalog produk

## Instalasi

```bash
# Clone repository
git clone https://github.com/ihsanuddin23/Tokoku.git
cd Tokoku

# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Database (MySQL via XAMPP — buat database 'tokoku' di phpMyAdmin terlebih dahulu)
php artisan migrate --seed

# Generate product images (opsional, butuh koneksi internet)
php artisan products:generate-images

# Jalankan server
php artisan serve
```

## Demo Credentials

| Role  | Email              | Password   |
|-------|--------------------|------------|
| Buyer | buyer@tokoku.test  | password   |
| Seller| seller@tokoku.test | password   |
| Admin | admin@tokoku.test  | password   |

## Testing

```bash
php artisan test
```

Saat ini tersedia **88 test** dengan **195 assertions** yang mencakup autentikasi, katalog, keranjang, pesanan, produk seller, banner admin, profil, payment gateway, invoice PDF, export laporan, dashboard analytics, dan notifikasi email.

## Screenshots

### Homepage

| ![Homepage 1](docs/screenshots/homepage1.png) | ![Homepage 2](docs/screenshots/homepage2.png) |
|---|---|
| ![Homepage 3](docs/screenshots/homepage3.png) | ![Homepage 4](docs/screenshots/homepage4.png) |
| ![Homepage 5](docs/screenshots/homepage5.png) | ![Homepage 6](docs/screenshots/homepage6.png) |

### Autentikasi

| Login | Register |
|-------|----------|
| ![Login](docs/screenshots/login.png) | ![Register](docs/screenshots/register.png) |

### Katalog & Produk

| Katalog 1 | Katalog 2 |
|-----------|----------|
| ![Katalog 1](docs/screenshots/products1.png) | ![Katalog 2](docs/screenshots/products2.png) |

| Detail Produk 1 | Detail Produk 2 |
|-----------------|-----------------|
| ![Detail 1](docs/screenshots/detailproducts1.png) | ![Detail 2](docs/screenshots/detailproducts2.png) |

### Transaksi (Buyer)

| Cart | Checkout | Riwayat Pesanan |
|------|----------|-----------------|
| ![Cart](docs/screenshots/cart.png) | ![Checkout](docs/screenshots/checkout.png) | ![Riwayat](docs/screenshots/riwayatpesanan.png) |

| Alamat Pengiriman | Profil Buyer |
|-------------------|---------------|
| ![Alamat](docs/screenshots/profilebuyeraddresses.png) | ![Profil](docs/screenshots/profileadmin.png) |

### Seller Panel

| Dashboard Seller | Kelola Produk | Tambah Produk |
|------------------|----------------|----------------|
| ![Dashboard](docs/screenshots/dashboardseller.png) | ![Kelola](docs/screenshots/kelolaprodukseller.png) | ![Tambah](docs/screenshots/tambahprodukseller.png) |

| Pesanan Masuk | Profil Toko |
|---------------|-------------|
| ![Pesanan](docs/screenshots/pesananmasukseller.png) | ![Toko](docs/screenshots/namatoko.png) |

### Admin Panel

| Dashboard Admin | Kategori | Manajemen User |
|-----------------|----------|----------------|
| ![Admin](docs/screenshots/dashboaradmin.png) | ![Kategori](docs/screenshots/kategoriprodukadmin.png) | ![User](docs/screenshots/manajemenuseradmin.png) |

| Verifikasi Seller | Manajemen Banner |
|-------------------|-------------------|
| ![Verifikasi](docs/screenshots/verifikasiselleradmin.png) | ![Banner](docs/screenshots/manajemenbanneradmin.png) |

## Arsitektur

```
User (Buyer/Seller/Admin)
    │
    ▼
Laravel Routes → Middleware (Auth, Role, Active, VerifiedSeller)
    │
    ▼
Controllers → Models → MySQL
    │
    ▼
Blade Views + Tailwind CSS + Alpine.js
    │
    ▼
Midtrans Snap (Payment) · DomPDF (Invoice/Reports) · SMTP (Email)
```

### ERD (Entity Relationship Diagram)

```
users ──< seller_profiles ──< products >── categories
  │           │                  │
  │           │                  ├──< product_images
  │           │                  │
  │           └──< order_items >── orders
  │                                    │
  ├──< addresses                     ├──< payments
  │                                    │
  ├──< carts ──< cart_items           └──< reviews
  │
  └──< seller_verifications

banners (standalone)
```

### Database Tables (14)

| # | Table | Description |
|---|-------|-------------|
| 1 | `users` | All users (buyer, seller, admin) |
| 2 | `seller_profiles` | Seller store profiles |
| 3 | `categories` | Product categories |
| 4 | `products` | Product listings |
| 5 | `product_images` | Product photos |
| 6 | `addresses` | Shipping addresses |
| 7 | `carts` | Shopping carts |
| 8 | `cart_items` | Items in carts |
| 9 | `orders` | Order transactions |
| 10 | `order_items` | Order line items |
| 11 | `payments` | Midtrans payment records |
| 12 | `reviews` | Product reviews & ratings |
| 13 | `banners` | Homepage banners |
| 14 | `seller_verifications` | Seller verification requests |

## Roadmap

- Fase 1 — Autentikasi & Profil ✅
- Fase 2 — Produk & Katalog ✅
- Fase 3 — Transaksi & Order ✅
- Fase 4 — Payment Gateway (Midtrans) ✅
- Fase 5 — Dashboard Analytics, Laporan & Notifikasi ✅
- Fase 6 — Polish & Deploy ✅

## Struktur Dokumentasi

- `docs/PRD_TokoKu_Ecommerce.md` — Product Requirements Document
- `docs/SITEMAP.md` — Sitemap & page hierarchy
- `docs/DESIGN.md` — Design system & guidelines

## License

MIT License
