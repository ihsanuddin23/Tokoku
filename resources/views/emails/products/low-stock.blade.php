@component('mail::message')
# Peringatan Stok Menipis

Halo {{ $product->sellerProfile->store_name }},

Stok produk Anda saat ini menipis:

## Detail Produk
- **Nama Produk:** {{ $product->name }}
- **Stok Tersisa:** {{ $product->stock }} pcs
- **Batas Peringatan:** {{ $threshold }} pcs

Segera lakukan restock agar produk tetap tersedia untuk pembeli.

@component('mail::button', ['url' => route('seller.products.index')])
Kelola Produk
@endcomponent

Terima kasih.
@endcomponent
