# DESIGN.md — TokoKu Design System

> Panduan desain untuk konsistensi UI di seluruh halaman TokoKu.
> Wajib dibaca sebelum membuat atau memodifikasi komponen UI apapun.

---

## 1. Design Philosophy

- **Friendly & Playful** — Terasa hangat, mudah digunakan, tidak kaku
- **Rounded** — Semua elemen menggunakan border radius yang lembut
- **Colorful tapi tidak noisy** — Warna vivid hanya untuk aksen, background tetap bersih
- **Referensi:** Tokopedia — layout, card style, dan nuansa warna

---

## 2. Color Palette

### Primary (Hijau — Trust & Fresh)

| Token | Hex | Tailwind Class | Penggunaan |
|---|---|---|---|
| primary-50 | `#f0fdf4` | `bg-green-50` | Background section ringan |
| primary-100 | `#dcfce7` | `bg-green-100` | Badge background, hover ringan |
| primary-400 | `#4ade80` | `bg-green-400` | Ilustrasi, dekorasi |
| primary-500 | `#22c55e` | `bg-green-500` | **Warna utama — button, link aktif** |
| primary-600 | `#16a34a` | `bg-green-600` | Hover state button |
| primary-700 | `#15803d` | `bg-green-700` | Pressed state, teks di atas background terang |

### Secondary (Orange — Energik & CTA)

| Token | Hex | Tailwind Class | Penggunaan |
|---|---|---|---|
| secondary-400 | `#fb923c` | `bg-orange-400` | Badge promo, label diskon |
| secondary-500 | `#f97316` | `bg-orange-500` | **CTA penting — tombol Beli Sekarang** |
| secondary-600 | `#ea580c` | `bg-orange-600` | Hover CTA |

### Neutral

| Token | Hex | Tailwind Class | Penggunaan |
|---|---|---|---|
| white | `#ffffff` | `bg-white` | Background card, modal |
| gray-50 | `#f9fafb` | `bg-gray-50` | Background halaman utama |
| gray-100 | `#f3f4f6` | `bg-gray-100` | Background input, divider |
| gray-300 | `#d1d5db` | `border-gray-300` | Border input, card |
| gray-500 | `#6b7280` | `text-gray-500` | Teks sekunder, placeholder |
| gray-700 | `#374151` | `text-gray-700` | Teks body utama |
| gray-900 | `#111827` | `text-gray-900` | Heading, teks penting |

### Semantic

| Fungsi | Hex | Tailwind Class |
|---|---|---|
| Success | `#22c55e` | `text-green-500` |
| Warning | `#f59e0b` | `text-amber-500` |
| Danger / Error | `#ef4444` | `text-red-500` |
| Info | `#3b82f6` | `text-blue-500` |

---

## 3. Typography

### Font Family

```
Font Utama  : Inter (import dari Google Fonts)
Font Fallback: ui-sans-serif, system-ui, sans-serif
```

Tambahkan di `resources/css/app.css`:
```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

body {
  font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
}
```

### Type Scale

| Elemen | Class Tailwind | Berat | Penggunaan |
|---|---|---|---|
| Heading XL | `text-3xl` | `font-bold` | Judul halaman utama (hero) |
| Heading L | `text-2xl` | `font-bold` | Judul section |
| Heading M | `text-xl` | `font-semibold` | Judul card, sub-section |
| Heading S | `text-lg` | `font-semibold` | Nama produk di card |
| Body | `text-sm` | `font-normal` | Teks konten umum |
| Caption | `text-xs` | `font-normal` | Label, metadata, timestamp |

---

## 4. Spacing & Layout

### Border Radius (Rounded — ciri khas gaya Friendly)

| Elemen | Class Tailwind |
|---|---|
| Button | `rounded-full` |
| Card | `rounded-2xl` |
| Input / Select | `rounded-xl` |
| Badge / Tag | `rounded-full` |
| Modal | `rounded-2xl` |
| Avatar | `rounded-full` |
| Image produk | `rounded-xl` |

### Shadow

| Elemen | Class Tailwind |
|---|---|
| Card default | `shadow-sm` |
| Card hover | `shadow-md` |
| Modal / Dropdown | `shadow-xl` |
| Navbar | `shadow-sm` |

### Container

```html
<!-- Gunakan selalu untuk konten utama -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  ...
</div>
```

### Grid Produk

```html
<!-- Katalog produk -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">

<!-- Dashboard / card statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
```

---

## 5. Komponen UI

### 5.1 Button

```html
<!-- Primary Button (aksi utama) -->
<button class="bg-green-500 hover:bg-green-600 active:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-full transition-colors duration-200">
  Tambah ke Keranjang
</button>

<!-- Secondary / CTA Button (Beli Sekarang) -->
<button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-full transition-colors duration-200">
  Beli Sekarang
</button>

<!-- Outline Button -->
<button class="border-2 border-green-500 text-green-600 hover:bg-green-50 font-semibold px-6 py-2.5 rounded-full transition-colors duration-200">
  Lihat Toko
</button>

<!-- Danger Button -->
<button class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2.5 rounded-full transition-colors duration-200">
  Hapus
</button>

<!-- Ghost / Text Button -->
<button class="text-green-600 hover:text-green-700 font-medium hover:underline transition-colors duration-200">
  Lihat Semua
</button>
```

### 5.2 Card Produk

```html
<div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden group cursor-pointer">
  <!-- Foto Produk -->
  <div class="relative overflow-hidden">
    <img src="..." alt="..." class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300 rounded-t-2xl">
    <!-- Badge (opsional) -->
    <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
      Terlaris
    </span>
  </div>
  <!-- Info Produk -->
  <div class="p-3">
    <p class="text-sm text-gray-800 font-medium line-clamp-2 leading-snug">Nama Produk</p>
    <p class="text-green-600 font-bold text-base mt-1">Rp 150.000</p>
    <div class="flex items-center gap-1 mt-1">
      <span class="text-yellow-400 text-xs">★</span>
      <span class="text-xs text-gray-500">4.8 · 120 terjual</span>
    </div>
    <p class="text-xs text-gray-400 mt-1">Jakarta Selatan</p>
  </div>
</div>
```

### 5.3 Navbar

```html
<nav class="bg-white shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 gap-4">
      <!-- Logo -->
      <a href="/" class="text-2xl font-bold text-green-500">TokoKu</a>

      <!-- Search Bar -->
      <div class="flex-1 max-w-xl">
        <div class="relative">
          <input type="text" placeholder="Cari produk, toko, kategori..."
            class="w-full bg-gray-100 rounded-full px-5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-400 transition">
          <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-500">
            🔍
          </button>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center gap-3">
        <a href="/cart" class="relative p-2 text-gray-600 hover:text-green-500">
          🛒
          <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
        </a>
        <a href="/login" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-full text-sm transition-colors">
          Masuk
        </a>
      </div>
    </div>
  </div>
</nav>
```

### 5.4 Badge / Label Status

```html
<!-- Status Order -->
<span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">Menunggu Pembayaran</span>
<span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">Diproses</span>
<span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">Dikirim</span>
<span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Selesai</span>
<span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">Dibatalkan</span>

<!-- Label Produk -->
<span class="bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-1 rounded-full">Terlaris</span>
<span class="bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">Baru</span>
<span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full">Bekas</span>
```

### 5.5 Input Form

```html
<!-- Input Text -->
<div class="flex flex-col gap-1">
  <label class="text-sm font-medium text-gray-700">Nama Produk</label>
  <input type="text"
    class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
    placeholder="Masukkan nama produk">
  <!-- Error state -->
  <p class="text-xs text-red-500">Nama produk wajib diisi.</p>
</div>

<!-- Select -->
<select class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-400 w-full">
  <option>Pilih Kategori</option>
</select>

<!-- Textarea -->
<textarea rows="4"
  class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-400 w-full resize-none transition">
</textarea>
```

### 5.6 Card Statistik Dashboard

```html
<div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
  <div class="bg-green-100 p-3 rounded-xl">
    <span class="text-2xl">💰</span>
  </div>
  <div>
    <p class="text-sm text-gray-500">Total Penjualan</p>
    <p class="text-2xl font-bold text-gray-900">Rp 4.250.000</p>
    <p class="text-xs text-green-500 font-medium">↑ 12% dari bulan lalu</p>
  </div>
</div>
```

### 5.7 Sidebar Dashboard (Seller & Admin)

```html
<aside class="w-64 bg-white shadow-sm h-screen sticky top-0 flex flex-col">
  <!-- Logo -->
  <div class="p-5 border-b border-gray-100">
    <span class="text-xl font-bold text-green-500">TokoKu</span>
    <p class="text-xs text-gray-400 mt-0.5">Seller Dashboard</p>
  </div>

  <!-- Menu -->
  <nav class="flex-1 p-4 flex flex-col gap-1">
    <!-- Active item -->
    <a href="/seller/dashboard"
      class="flex items-center gap-3 px-4 py-2.5 bg-green-50 text-green-600 font-semibold rounded-xl text-sm">
      📊 Dashboard
    </a>
    <!-- Inactive item -->
    <a href="/seller/products"
      class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl text-sm transition-colors">
      📦 Produk
    </a>
  </nav>
</aside>
```

---

## 6. Halaman Khusus — Style Guide

### Halaman Beranda (Guest)
- Background: `bg-gray-50`
- Hero section: background hijau gradient `from-green-500 to-green-600`, teks putih
- Section kategori: background putih, card kategori rounded-2xl dengan ikon emoji besar
- Section produk: grid 5 kolom di desktop

### Halaman Auth (Login/Register)
- Layout: 2 kolom — kiri ilustrasi/brand (bg-green-500), kanan form (bg-white)
- Di mobile: hanya tampilkan form
- Card form: `rounded-2xl shadow-lg p-8`

### Dashboard (Seller/Admin)
- Layout: sidebar kiri fixed + konten kanan scrollable
- Background konten: `bg-gray-50`
- Semua card: `bg-white rounded-2xl shadow-sm`

### Halaman Detail Produk
- Layout: 2 kolom — kiri foto gallery, kanan info + tombol beli
- Foto utama: `rounded-2xl`, foto thumbnail: `rounded-xl border-2`
- Sticky sidebar kanan di desktop saat scroll

---

## 7. Animasi & Transisi

Gunakan transisi ringan untuk kesan polished:

```html
<!-- Selalu tambahkan transition pada elemen interaktif -->
transition-colors duration-200   <!-- untuk perubahan warna -->
transition-shadow duration-200   <!-- untuk perubahan shadow -->
transition-transform duration-300 <!-- untuk scale/move -->

<!-- Hover card produk -->
group-hover:scale-105 transition-transform duration-300

<!-- Hover button -->
hover:bg-green-600 transition-colors duration-200
```

---

## 8. Responsif Breakpoint

| Breakpoint | Prefix Tailwind | Lebar |
|---|---|---|
| Mobile | (default) | < 640px |
| Small | `sm:` | ≥ 640px |
| Medium | `md:` | ≥ 768px |
| Large | `lg:` | ≥ 1024px |
| XL | `xl:` | ≥ 1280px |

### Aturan Responsif Utama:
- Navbar: hamburger menu di mobile, full di desktop
- Grid produk: 2 kolom mobile → 3 tablet → 5 desktop
- Sidebar dashboard: hidden di mobile (drawer/overlay), visible di `lg:`
- Detail produk: stack vertical di mobile, 2 kolom di `md:`

---

## 9. Icon

Gunakan **Heroicons** (sudah terintegrasi baik dengan Tailwind):

```bash
npm install @heroicons/vue  # atau pakai SVG langsung
```

Atau gunakan **emoji** untuk prototype cepat saat vibe coding — lebih cepat dan tidak perlu install.

---

## 10. Tailwind Config Tambahan

Tambahkan di `tailwind.config.js` untuk custom font:

```js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
      colors: {
        primary: {
          50:  '#f0fdf4',
          100: '#dcfce7',
          400: '#4ade80',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
        }
      }
    },
  },
  plugins: [],
}
```

---

*DESIGN.md TokoKu v1.0.0 — Update dokumen ini setiap ada perubahan design system*
