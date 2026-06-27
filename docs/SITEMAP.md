# SITEMAP.md — TokoKu

> Peta seluruh halaman TokoKu beserta akses role, URL, dan komponen utama.
> Gunakan dokumen ini sebagai referensi saat membuat halaman baru.

---

## Hierarki Halaman

```
TokoKu
│
├── 🌐 PUBLIC (Guest & Semua User)
│   ├── / ................................. Beranda
│   ├── /products ......................... Katalog Produk
│   ├── /products/{slug} .................. Detail Produk
│   ├── /stores/{slug} .................... Profil Toko
│   ├── /login ............................ Login
│   ├── /register ......................... Registrasi
│   └── /forgot-password .................. Lupa Password
│
├── 👤 BUYER (Auth: role = buyer atau seller)
│   ├── /cart ............................. Keranjang Belanja
│   ├── /checkout ......................... Checkout
│   ├── /checkout/payment ................. Halaman Pembayaran (Midtrans)
│   ├── /checkout/success ................. Konfirmasi Order Berhasil
│   ├── /orders ........................... Daftar Pesanan
│   ├── /orders/{code} .................... Detail Pesanan
│   ├── /reviews/{order_item_id} .......... Form Ulasan Produk
│   ├── /wishlist ......................... Daftar Wishlist (opsional)
│   ├── /profile .......................... Edit Profil
│   ├── /profile/password ................. Ganti Password
│   ├── /profile/addresses ................ Daftar Alamat
│   └── /become-seller .................... Form Pendaftaran Seller
│
├── 🏪 SELLER (Auth: role = seller + is_verified = true)
│   ├── /seller/dashboard ................. Dashboard Utama
│   ├── /seller/store ..................... Pengaturan Toko
│   ├── /seller/products .................. Daftar Produk
│   ├── /seller/products/create ........... Tambah Produk Baru
│   ├── /seller/products/{id}/edit ........ Edit Produk
│   ├── /seller/orders .................... Pesanan Masuk
│   ├── /seller/orders/{code} ............. Detail & Update Status Order
│   └── /seller/reports ................... Laporan Penjualan
│
└── 🔧 ADMIN (Auth: role = admin)
    ├── /admin/dashboard .................. Dashboard Platform
    ├── /admin/users ...................... Manajemen User
    ├── /admin/users/{id} ................. Detail User
    ├── /admin/sellers .................... Verifikasi Seller
    ├── /admin/sellers/{id} ............... Detail Pengajuan Seller
    ├── /admin/categories ................. Manajemen Kategori
    ├── /admin/banners .................... Manajemen Banner
    └── /admin/reports .................... Laporan Global Platform
```

---

## Detail Per Halaman

### 🌐 PUBLIC

---

#### `/` — Beranda
- **Akses:** Semua (guest & logged in)
- **Layout:** Navbar + Hero + Konten + Footer
- **Komponen:**
  - Hero section dengan banner slider (dari tabel `banners`)
  - Grid kategori produk dengan ikon
  - Section "Produk Terlaris" (sort by sold_count DESC, limit 10)
  - Section "Produk Terbaru" (sort by created_at DESC, limit 10)
  - Section "Toko Terpopuler" (sort by sold_count toko, limit 6)
- **Data:** banners, categories, products, seller_profiles

---

#### `/products` — Katalog Produk
- **Akses:** Semua
- **Layout:** Navbar + Sidebar Filter + Grid Produk + Footer
- **Komponen:**
  - Sidebar filter: kategori, range harga, kondisi (baru/bekas), rating minimum
  - Dropdown sort: terlaris, terbaru, harga terendah, harga tertinggi
  - Grid produk (card produk) dengan pagination
  - Search bar di atas grid
- **Query params:** `?category=`, `?min_price=`, `?max_price=`, `?condition=`, `?sort=`, `?q=`, `?page=`
- **Data:** products, categories

---

#### `/products/{slug}` — Detail Produk
- **Akses:** Semua
- **Layout:** Navbar + Konten 2 Kolom + Footer
- **Komponen:**
  - Kolom kiri: foto gallery (foto utama besar + thumbnail bawah)
  - Kolom kanan (sticky): nama, harga, rating, stok, tombol qty, tombol "Tambah Keranjang" + "Beli Sekarang", info pengiriman, info toko
  - Bawah: Tab deskripsi produk + Tab ulasan (rating bintang + komentar)
- **Data:** products, product_images, reviews, seller_profiles

---

#### `/stores/{slug}` — Profil Toko
- **Akses:** Semua
- **Layout:** Navbar + Header Toko + Grid Produk + Footer
- **Komponen:**
  - Header toko: banner, logo, nama, kota, jumlah produk, rating toko
  - Filter produk toko
  - Grid produk milik toko tersebut
- **Data:** seller_profiles, products

---

#### `/login` — Login
- **Akses:** Guest only (redirect jika sudah login)
- **Layout:** 2 kolom (ilustrasi kiri, form kanan) — mobile: form saja
- **Komponen:** Form email + password, remember me, link forgot password, link register

---

#### `/register` — Registrasi
- **Akses:** Guest only
- **Layout:** 2 kolom — mobile: form saja
- **Komponen:** Form nama, email, password, konfirmasi password

---

#### `/forgot-password` — Lupa Password
- **Akses:** Guest only
- **Komponen:** Form input email, kirim link reset

---

### 👤 BUYER

---

#### `/cart` — Keranjang Belanja
- **Akses:** Auth (buyer/seller)
- **Layout:** Navbar + Konten + Footer
- **Komponen:**
  - Tabel item keranjang: foto, nama, harga satuan, qty (increment/decrement), subtotal, tombol hapus
  - Card ringkasan: subtotal, estimasi ongkir, total, tombol Checkout
- **Data:** carts, cart_items, products

---

#### `/checkout` — Checkout
- **Akses:** Auth (buyer/seller), keranjang tidak kosong
- **Layout:** Navbar + Konten 2 Kolom + Footer
- **Komponen:**
  - Kolom kiri: pilih/tambah alamat pengiriman, pilih kurir (simulasi)
  - Kolom kanan: ringkasan order (produk, qty, harga), subtotal, ongkir, total
  - Tombol "Lanjut Bayar"
- **Data:** addresses, cart_items, products

---

#### `/checkout/payment` — Pembayaran
- **Akses:** Auth, order sudah dibuat
- **Komponen:**
  - Ringkasan order
  - Tombol "Bayar Sekarang" (trigger Midtrans Snap popup)
  - Midtrans Snap modal (library eksternal Midtrans)
- **Data:** orders, payments

---

#### `/checkout/success` — Konfirmasi Berhasil
- **Akses:** Auth, setelah bayar sukses
- **Komponen:**
  - Ikon sukses + pesan konfirmasi
  - Kode order
  - Tombol "Lihat Detail Pesanan" + "Lanjut Belanja"

---

#### `/orders` — Daftar Pesanan
- **Akses:** Auth
- **Komponen:**
  - Tab filter status: Semua, Menunggu Bayar, Diproses, Dikirim, Selesai, Dibatalkan
  - Card per order: kode, toko, produk (thumbnail), total, status badge, tombol aksi
- **Data:** orders, order_items, seller_profiles

---

#### `/orders/{code}` — Detail Pesanan
- **Akses:** Auth (pemilik order)
- **Komponen:**
  - Info order: kode, tanggal, status
  - Daftar produk dipesan
  - Info pengiriman: kurir, nomor resi
  - Info pembayaran: metode, waktu bayar
  - Tombol: "Pesanan Diterima" (jika status Dikirim) / "Batalkan" (jika pending_payment) / "Beri Ulasan" (jika Selesai)
- **Data:** orders, order_items, payments, addresses

---

#### `/reviews/{order_item_id}` — Form Ulasan
- **Akses:** Auth, order status = completed, belum pernah review item ini
- **Komponen:**
  - Info produk yang diulas
  - Rating bintang (1–5, klik interaktif dengan Alpine.js)
  - Textarea komentar (opsional)
  - Tombol Submit
- **Data:** order_items, products

---

#### `/profile` — Edit Profil
- **Akses:** Auth
- **Komponen:**
  - Upload/ganti foto avatar
  - Form: nama, nomor HP
  - Tombol Simpan

---

#### `/profile/password` — Ganti Password
- **Akses:** Auth
- **Komponen:** Form: password lama, password baru, konfirmasi password baru

---

#### `/profile/addresses` — Manajemen Alamat
- **Akses:** Auth
- **Komponen:**
  - Daftar kartu alamat tersimpan (label, nama penerima, alamat, badge "Utama")
  - Tombol tambah alamat baru
  - Modal form tambah/edit alamat
  - Tombol set sebagai alamat utama + hapus
- **Data:** addresses

---

#### `/become-seller` — Daftar Seller
- **Akses:** Auth (role = buyer, belum pernah apply)
- **Komponen:**
  - Form pengajuan: nama toko, kota, deskripsi
  - Info syarat & ketentuan
  - Tombol Ajukan
  - Halaman status (jika sudah apply: "Menunggu Verifikasi Admin")
- **Data:** seller_verifications

---

### 🏪 SELLER

> Semua halaman seller menggunakan layout: Sidebar + Konten

---

#### `/seller/dashboard` — Dashboard
- **Komponen:**
  - 4 card statistik: penjualan hari ini, bulan ini, total order, produk aktif
  - Line chart penjualan 7 hari terakhir (Chart.js)
  - Bar chart penjualan per bulan (Chart.js)
  - Tabel 5 order terbaru yang masuk
- **Data:** orders, order_items, products

---

#### `/seller/store` — Pengaturan Toko
- **Komponen:**
  - Upload logo toko
  - Upload banner toko
  - Form: nama toko, deskripsi, kota
  - Tombol Simpan
- **Data:** seller_profiles

---

#### `/seller/products` — Daftar Produk
- **Komponen:**
  - Tombol "Tambah Produk Baru"
  - Search produk
  - Filter: kategori, status (aktif/nonaktif)
  - Tabel: foto, nama, kategori, harga, stok, status toggle, aksi (edit/hapus)
  - Pagination
- **Data:** products, categories

---

#### `/seller/products/create` — Tambah Produk
- **Komponen:**
  - Upload foto produk (multiple, drag & drop, preview, set foto utama)
  - Form: nama, kategori, harga, stok, berat, kondisi, deskripsi (rich text atau textarea)
  - Toggle aktif/nonaktif
  - Tombol Simpan
- **Data:** categories

---

#### `/seller/products/{id}/edit` — Edit Produk
- **Komponen:** Sama dengan create, data ter-prefill
- **Data:** products, product_images, categories

---

#### `/seller/orders` — Pesanan Masuk
- **Komponen:**
  - Tab filter status: Semua, Dibayar, Diproses, Dikirim, Selesai
  - Tabel: kode order, pembeli, produk, total, tanggal, status, aksi
  - Pagination
- **Data:** orders, order_items, users

---

#### `/seller/orders/{code}` — Detail & Update Order
- **Komponen:**
  - Info lengkap order dan pembeli
  - Daftar produk yang dipesan
  - Tombol "Proses Pesanan" (jika status paid)
  - Form input nomor resi + tombol "Tandai Dikirim" (jika status processing)
- **Data:** orders, order_items, users, addresses

---

#### `/seller/reports` — Laporan Penjualan
- **Komponen:**
  - Filter rentang tanggal (date picker)
  - Card ringkasan: total pendapatan, total order, rata-rata order
  - Line chart pendapatan harian (Chart.js)
  - Tabel transaksi detail (kode, pembeli, produk, total, tanggal)
  - Tombol Export PDF + Export Excel
- **Data:** orders, order_items

---

### 🔧 ADMIN

> Semua halaman admin menggunakan layout: Sidebar + Konten

---

#### `/admin/dashboard` — Dashboard Platform
- **Komponen:**
  - 4 card: total user, total seller aktif, total transaksi, total revenue platform
  - Line chart transaksi harian (Chart.js)
  - Bar chart revenue bulanan (Chart.js)
  - Tabel aktivitas terbaru (user baru, seller baru, transaksi terbaru)
- **Data:** users, orders, seller_profiles

---

#### `/admin/users` — Manajemen User
- **Komponen:**
  - Search user (nama/email)
  - Filter: role, status (aktif/banned)
  - Tabel: nama, email, role, status, tanggal daftar, aksi (detail, ban/unban)
  - Pagination
- **Data:** users

---

#### `/admin/users/{id}` — Detail User
- **Komponen:**
  - Info profil user
  - Riwayat aktivitas (order, review)
  - Tombol Ban / Unban akun
- **Data:** users, orders

---

#### `/admin/sellers` — Verifikasi Seller
- **Komponen:**
  - Tab: Pending, Disetujui, Ditolak
  - Tabel: nama user, nama toko, kota, tanggal apply, status, aksi
  - Modal detail pengajuan dengan tombol Setujui / Tolak (+ form alasan penolakan)
- **Data:** seller_verifications, users

---

#### `/admin/categories` — Manajemen Kategori
- **Komponen:**
  - Tombol "Tambah Kategori"
  - Tabel: ikon, nama, slug, jumlah produk, status toggle, aksi (edit/hapus)
  - Modal form tambah/edit kategori
- **Data:** categories, products (count)

---

#### `/admin/banners` — Manajemen Banner
- **Komponen:**
  - Tombol "Tambah Banner"
  - Tabel: preview gambar, judul, link, urutan, status toggle, aksi
  - Modal form tambah/edit banner (upload gambar, judul, link, urutan)
- **Data:** banners

---

#### `/admin/reports` — Laporan Global
- **Komponen:**
  - Filter rentang tanggal
  - Card ringkasan platform
  - Line chart dan bar chart (Chart.js)
  - Tabel transaksi seluruh platform
  - Tombol Export PDF + Export Excel
- **Data:** orders, order_items, users, seller_profiles

---

## Middleware & Guard

```
Route::middleware('guest')          → /login, /register, /forgot-password
Route::middleware('auth')           → semua halaman buyer
Route::middleware('auth', 'role:seller', 'verified.seller')  → /seller/*
Route::middleware('auth', 'role:admin')   → /admin/*
```

---

## Redirect Logic Setelah Login

| Role | Redirect ke |
|---|---|
| buyer | `/` (beranda) |
| seller (verified) | `/seller/dashboard` |
| seller (belum verified) | `/` + flash info "toko dalam proses verifikasi" |
| admin | `/admin/dashboard` |

---

*SITEMAP.md TokoKu v1.0.0*
