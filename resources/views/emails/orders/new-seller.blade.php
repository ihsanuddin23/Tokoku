@component('mail::message')
# Pesanan Baru Masuk!

Halo {{ $orderItem->sellerProfile->store_name }},

Anda menerima pesanan baru untuk produk:

## Detail Pesanan
- **Produk:** {{ $orderItem->product_name }}
- **Jumlah:** {{ $orderItem->quantity }} pcs
- **Harga Satuan:** Rp {{ number_format($orderItem->product_price, 0, ',', '.') }}
- **Total:** Rp {{ number_format($orderItem->subtotal, 0, ',', '.') }}
- **Pembeli:** {{ $orderItem->order->user->name }}
- **No. Pesanan:** {{ $orderItem->order->order_number }}

## Alamat Pengiriman
{{ $orderItem->order->shipping_address }}

@component('mail::button', ['url' => route('seller.orders.index')])
Lihat Pesanan
@endcomponent

Segera proses pesanan ini ya!
@endcomponent
