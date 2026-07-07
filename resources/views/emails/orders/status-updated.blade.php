@component('mail::message')
# Update Status Pesanan

Halo {{ $order->user->name }},

Status pesanan Anda **{{ $order->order_number }}** telah diperbarui.

## Perubahan Status
- **Sebelumnya:** {{ ucfirst($oldStatus) }}
- **Sekarang:** {{ ucfirst($newStatus) }}

@php
    $statusMessages = [
        'paid' => 'Pembayaran telah dikonfirmasi. Pesanan sedang diproses oleh penjual.',
        'shipped' => 'Pesanan telah dikirim. Mohon tunggu dan konfirmasi jika sudah diterima.',
        'completed' => 'Pesanan telah selesai. Terima kasih telah berbelanja!',
        'cancelled' => 'Pesanan telah dibatalkan.',
    ];
@endphp

@if (isset($statusMessages[$newStatus]))
{{ $statusMessages[$newStatus] }}
@endif

@component('mail::button', ['url' => route('orders.show', $order)])
Lihat Detail Pesanan
@endcomponent

Terima kasih telah berbelanja di TokoKu!
@endcomponent
