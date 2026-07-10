<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #333; font-size: 14px; }
        .invoice { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #10b981; }
        .logo { font-size: 28px; font-weight: bold; color: #10b981; }
        .logo span { color: #333; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { font-size: 24px; color: #333; }
        .invoice-title p { color: #666; font-size: 12px; margin-top: 4px; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 1px; margin-bottom: 8px; }
        .info-grid { display: flex; gap: 40px; }
        .info-block { flex: 1; }
        .info-block p { line-height: 1.6; }
        .info-block .name { font-weight: 600; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        thead { background: #f9fafb; }
        th { text-align: left; padding: 12px 15px; font-size: 11px; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        td { padding: 12px 15px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals { margin-left: auto; width: 300px; }
        .totals .row { display: flex; justify-content: space-between; padding: 8px 0; }
        .totals .grand { border-top: 2px solid #10b981; margin-top: 8px; padding-top: 12px; font-size: 18px; font-weight: bold; color: #10b981; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-shipped { background: #dbeafe; color: #1e40af; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 12px; }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <div>
                <div class="logo">Toko<span>Ku</span></div>
                <p style="color: #666; font-size: 12px; margin-top: 4px;">Platform Belanja Online Terpercaya</p>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>{{ $order->order_number }}</p>
                <p style="margin-top: 8px;">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="section">
            <div class="info-grid">
                <div class="info-block">
                    <div class="section-title">Ditagihkan Kepada</div>
                    <p class="name">{{ $order->user->name }}</p>
                    <p style="color: #666;">{{ $order->user->email }}</p>
                    @if ($order->user->phone)
                        <p style="color: #666;">{{ $order->user->phone }}</p>
                    @endif
                </div>
                <div class="info-block">
                    <div class="section-title">Alamat Pengiriman</div>
                    <p style="white-space: pre-line; color: #666;">{{ $order->shipping_address }}</p>
                </div>
                <div class="info-block">
                    <div class="section-title">Status</div>
                    <p><span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span></p>
                    @if ($order->payment_status)
                        <p style="margin-top: 8px; color: #666;">Pembayaran: {{ ucfirst($order->payment_status) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}@if ($item->variant_name)<br><small style="color:#999;">Variasi: {{ $item->variant_name }}</small>@endif</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Ongkos Kirim</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="row grand">
                <span>Total</span>
                <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if ($order->notes)
            <div class="section" style="margin-top: 25px;">
                <div class="section-title">Catatan</div>
                <p style="color: #666;">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Terima kasih telah berbelanja di TokoKu!</p>
            <p style="margin-top: 4px;">Invoice ini dibuat secara otomatis dan tidak memerlukan tanda tangan basah.</p>
        </div>
    </div>
</body>
</html>
