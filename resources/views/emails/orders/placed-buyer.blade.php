@component('mail::message')
# Pesanan Berhasil Dibuat!

Halo {{ $order->user->name }},

Pesanan Anda dengan nomor **{{ $order->order_number }}** telah berhasil dibuat.

## Detail Pesanan

@foreach ($order->items as $item)
- {{ $item->product_name }} ({{ $item->quantity }}x) — Rp {{ number_format($item->subtotal, 0, ',', '.') }}
@endforeach

**Subtotal:** Rp {{ number_format($order->subtotal, 0, ',', '.') }}
**Ongkos Kirim:** Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
**Total:** Rp {{ number_format($order->grand_total, 0, ',', '.') }}

## Alamat Pengiriman
{{ $order->shipping_address }}

Silakan selesaikan pembayaran untuk memproses pesanan Anda.

@component('mail::button', ['url' => route('payment.show', $order)])
Bayar Sekarang
@endcomponent

Terima kasih telah berbelanja di TokoKu!
@endcomponent
