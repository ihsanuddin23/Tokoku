# TokoKu — E-Commerce Platform

[![Tests](https://github.com/ihsanuddin23/Tokoku/actions/workflows/tests.yml/badge.svg)](https://github.com/ihsanuddin23/Tokoku/actions/workflows/tests.yml)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.1-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

TokoKu merupakan platform e-commerce **multi-role** (Buyer, Seller, Admin) yang menghubungkan pembeli dan penjual dalam satu ekosistem belanja online. Pembeli dapat berbelanja produk dari berbagai kategori, checkout dengan payment gateway Midtrans, dan melacak pesanan. Seller dapat membuka toko sendiri, mengelola produk, menerima pesanan, dan mencairkan saldo. Admin mengelola verifikasi seller, kategori, banner, voucher, dan seluruh aktivitas platform.

Dibangun sebagai **proyek portofolio** menggunakan Laravel 12, Tailwind CSS, Alpine.js, dan MySQL. Alur proses bisnis aplikasi ini sama dengan layaknya toko online pada umumnya — customer memilih produk, menambahkan ke keranjang, checkout, memilih metode pembayaran Midtrans (VA, QRIS, kartu kredit), dan jika pembayaran sukses maka pesanan diproses oleh seller untuk dikirim. Customer akan menerima notifikasi email berupa invoice dan update status pesanan secara real-time.

**Status:** MVP Lengkap — Fase 1–6 selesai + fitur tambahan + comprehensive test suite (331 tests). Siap untuk demo dan deployment.

## Demo

- **Live Demo:** [https://tokoku-demo.up.railway.app](https://tokoku-demo.up.railway.app)
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
- **Live search** dengan Fetch API + Alpine.js (dropdown hasil real-time di navbar)
- Katalog publik dengan filter (kategori, harga, kondisi, rating minimum) & sorting
- **Halaman kategori terpisah** — daftar semua kategori & detail kategori dengan filter produk
- Halaman detail produk dengan produk terkait, ulasan & rating
- Halaman profil toko publik dengan follow/unfollow
- CRUD produk oleh seller dengan upload multiple foto (max 5)
- Bulk update stok oleh seller
- Filter & pencarian di tabel produk seller
- Aktifkan/nonaktifkan produk
- CRUD kategori oleh admin

### Transaksi
- Keranjang belanja (tambah, update qty, hapus)
- Checkout dengan pilihan alamat & kurir
- Integrasi Midtrans Snap (sandbox) — VA, QRIS, kartu kredit
- Webhook handler untuk konfirmasi pembayaran otomatis
- **Voucher diskon** — seller & admin bisa buat voucher (persen/fixed, min belanja, max penggunaan)
- Manajemen pesanan (riwayat, detail, batalkan)
- Restorasi stok otomatis saat pesanan dibatalkan
- **Sistem retur/refund** — buyer bisa ajukan retur, seller/admin proses
- Seller dapat mengupdate status item pesanan (pending → paid → shipped → completed)
- **Payout/pencairan** — seller tarik saldo, admin approve/reject
- Invoice PDF download per order

### Dashboard & Analytics
- **Seller Dashboard:** grafik penjualan 7 hari, stat cards (revenue harian/bulanan, total order, produk aktif), low stock alerts
- **Admin Dashboard:** grafik transaksi 7 hari, stat cards (total user, seller aktif, total transaksi, total revenue), transaksi & user terbaru
- Export laporan PDF & CSV untuk seller & admin dengan filter tanggal
- Notifikasi email: order baru ke seller, status update ke buyer, low stock alert
- **Notifikasi in-app** — order status, produk baru dari toko yang di-follow
- **Manajemen review** oleh seller (balas ulasan pembeli)

### Admin
- Verifikasi pendaftaran seller (approve/reject)
- Manajemen banner homepage
- Manajemen kategori
- Manajemen user (aktifkan/nonaktifkan)
- Manajemen voucher global
- Manajemen pembayaran & payout
- Manajemen retur/refund
- Activity logs (audit trail)
- Pengaturan aplikasi (nama, email, phone, alamat)

### Halaman Publik & SEO
- Halaman **About Us** dengan statistik & cerita brand
- Halaman **Contact Us** dengan form & info kontak dinamis dari settings
- Halaman **FAQ/Bantuan** dengan kategori pertanyaan
- Halaman **Terms & Privacy Policy**
- **Sitemap.xml** & **robots.txt** dinamis
- URL SEO-friendly (slug-based untuk kategori & produk)
- Cookie consent banner
- Mobile bottom navigation

### Keamanan
- CSRF protection di semua form
- XSS protection via Blade escaping
- Mass assignment protection yang ketat
- **Policy-based authorization** (Cart, Order, OrderItem, Product, Review, Voucher)
- Ownership check di setiap resource sensitif
- File upload: tipe & ukuran dibatasi
- Rate limiting untuk auth, katalog, contact form & search API
- **Soft deletes** pada model utama (user, product, order, dll)
- Open redirect & filter bypass protection

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

Saat ini tersedia **331 test** dengan **712 assertions** yang mencakup autentikasi, katalog, keranjang, pesanan, produk seller, banner admin, profil, payment gateway (Midtrans + webhook), invoice PDF, export laporan, dashboard analytics (buyer/seller/admin), notifikasi email & in-app, voucher, wishlist, review, store follow, alamat (CRUD), pendaftaran seller, retur/refund, notifikasi mark-read, admin management (user, verifikasi seller, kategori, order, return, product), seller management (product, voucher, order, store settings, reviews), shipping, stock notification, dan chat.

## Screenshots

### Homepage

| Homepage 1 | Homepage 2 |
|---|---|
| ![Homepage 1](docs/screenshots/homepage1.png) | ![Homepage 2](docs/screenshots/homepage2.png) |

| Homepage 3 | Homepage 4 |
|---|---|
| ![Homepage 3](docs/screenshots/homepage3.png) | ![Homepage 4](docs/screenshots/homepage4.png) |

| Homepage 5 | Homepage 6 |
|---|---|
| ![Homepage 5](docs/screenshots/homepage5.png) | ![Homepage 6](docs/screenshots/homepage6.png) |

| Homepage (terbaru) |
|---|
| ![Homepage Terbaru](docs/screenshots/Homepage%20terbaru%20(1).png) |

### Live Search

| Live Search Dropdown |
|---|
| ![Live Search](docs/screenshots/Live%20Search%20Dropdown.png) |

### Halaman Publik

| About Us | Contact Us |
|---|---|
| ![About 1](docs/screenshots/About%20Page%201.png) | ![Contact](docs/screenshots/Contact%20Page.png) |

| About Us (section 2) |
|---|
| ![About 2](docs/screenshots/About%20Page%202.png) |

### Halaman Kategori

| Daftar Kategori | Detail Kategori |
|---|---|
| ![Categories](docs/screenshots/Categories%20Index.png) | ![Category Detail](docs/screenshots/Category%20Detail%20-%20Elektronik.png) |

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
  │           │                  ├── (images: JSON column)
  │           │                  │
  │           └──< order_items >── orders
  │                                    │
  ├──< addresses                     ├──< payments
  │                                    │
  ├──< carts                          └──< reviews
  │
  ├──< seller_verifications
  ├──< wishlists
  ├──< store_followers
  └──< notifications

banners (standalone) · vouchers ──< voucher_usages
settings (standalone) · return_requests · payouts · activity_logs
```

### Database Tables (22)

| # | Table | Description |
|---|-------|-------------|
| 1 | `users` | All users (buyer, seller, admin) |
| 2 | `seller_profiles` | Seller store profiles |
| 3 | `categories` | Product categories |
| 4 | `products` | Product listings (images stored as JSON column) |
| 5 | `addresses` | Shipping addresses |
| 6 | `carts` | Shopping cart items (product_id FK) |
| 7 | `orders` | Order transactions |
| 8 | `order_items` | Order line items |
| 9 | `payments` | Midtrans payment records |
| 10 | `product_reviews` | Product reviews & ratings |
| 11 | `banners` | Homepage banners |
| 12 | `seller_verifications` | Seller verification requests |
| 13 | `wishlists` | User wishlist items |
| 14 | `notifications` | In-app notifications |
| 15 | `settings` | App configuration (email, phone, address) |
| 16 | `return_requests` | Return/refund requests |
| 17 | `payouts` | Seller payout/withdrawal requests |
| 18 | `activity_logs` | Admin audit trail |
| 19 | `vouchers` | Discount vouchers (seller & admin) |
| 20 | `voucher_usages` | Voucher usage tracking |
| 21 | `store_followers` | Store follow relationships |
| 22 | `jobs` | Queue jobs |

## Roadmap

- Fase 1 — Autentikasi & Profil ✅
- Fase 2 — Produk & Katalog ✅
- Fase 3 — Transaksi & Order ✅
- Fase 4 — Payment Gateway (Midtrans) ✅
- Fase 5 — Dashboard Analytics, Laporan & Notifikasi ✅
- Fase 6 — Polish & Deploy ✅

### Fitur Tambahan (di luar PRD)
- ✅ Halaman Contact & About Us
- ✅ Halaman FAQ/Bantuan
- ✅ Halaman Kategori Terpisah (slug-based)
- ✅ Live Search (Fetch API + Alpine.js)
- ✅ Voucher diskon (seller & admin)
- ✅ Sistem retur/refund
- ✅ Payout/pencairan saldo seller
- ✅ Wishlist
- ✅ Follow/unfollow toko
- ✅ Notifikasi in-app
- ✅ Activity logs (audit trail)
- ✅ Soft deletes
- ✅ Policy-based authorization
- ✅ Sitemap.xml & robots.txt
- ✅ Cookie consent banner
- ✅ Mobile bottom navigation
- ✅ Security hardening (open redirect, filter bypass)
- ✅ Chat buyer-seller (real-time messaging)
- ✅ Variasi produk (ukuran, warna)
- ✅ Stock notification (restock alert)
- ✅ Shipping management (kurir & tracking)
- ✅ Comprehensive test suite (331 tests, 712 assertions)

### Belum Diimplementasi
- ⬜ Integrasi API kurir (RajaOngkir/Komerce)
- ⬜ Notifikasi real-time (WebSocket/Broadcast)
- ⬜ Halaman lacak pesanan tanpa login
- ⬜ Stock reservation saat checkout

## Struktur Dokumentasi

- `docs/PRD_TokoKu_Ecommerce.md` — Product Requirements Document
- `docs/SITEMAP.md` — Sitemap & page hierarchy
- `docs/DESIGN.md` — Design system & guidelines

## License

MIT License
