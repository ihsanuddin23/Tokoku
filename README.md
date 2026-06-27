# TokoKu — E-Commerce Platform

Platform e-commerce multi-role (Buyer, Seller, Admin) dibangun dengan Laravel 12, Tailwind CSS, dan Alpine.js. Mendukung manajemen produk, keranjang, checkout, manajemen pesanan, dan dashboard untuk setiap role.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
- **Database:** MySQL (production) / SQLite (development)
- **Auth:** Laravel Breeze dengan multi-role (buyer, seller, admin)

## Fitur yang Tersedia

### Fase 1 — Setup & Autentikasi ✅
- Registrasi & login dengan rate limiting
- Reset password via email
- Multi-role: Buyer, Seller, Admin
- Middleware: role-based access, active user check, verified seller check
- Edit profil (nama, avatar, nomor HP)
- Ganti password
- Manajemen alamat pengiriman
- Daftar sebagai seller (dengan verifikasi admin)

### Fase 2 — Modul Produk ✅
- CRUD kategori (Admin)
- CRUD produk seller dengan upload multiple foto (max 5)
- Bulk update stok
- Filter & pencarian di tabel produk seller
- Halaman katalog publik dengan filter (kategori, harga, kondisi, rating) & sorting
- Halaman detail produk dengan produk terkait
- Aktifkan/nonaktifkan produk
- Halaman profil toko publik

### Fase 3 — Modul Pembeli ✅
- Keranjang belanja (add, update qty, remove)
- Checkout flow dengan pilihan alamat
- Manajemen pesanan (riwayat, detail, batalkan)
- Restorasi stok otomatis saat pesanan dibatalkan

### Fase 4 — Payment Gateway (Planned)
- Integrasi Midtrans Snap sandbox
- Webhook handler untuk konfirmasi pembayaran otomatis

### Fase 5 — Dashboard & Laporan (Planned)
- Dashboard seller dengan statistik
- Dashboard admin dengan Chart.js
- Export laporan PDF & Excel

## Instalasi

```bash
# Clone repository
git clone https://github.com/USERNAME/tokoku.git
cd tokoku

# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Database (SQLite untuk development)
php artisan migrate --seed

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

## Struktur Dokumentasi

- `docs/PRD_TokoKu_Ecommerce.md` — Product Requirements Document
- `docs/SITEMAP.md` — Sitemap & page hierarchy
- `docs/DESIGN.md` — Design system & guidelines

## License

MIT License
