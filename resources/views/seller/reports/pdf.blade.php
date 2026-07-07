<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #333; font-size: 12px; }
        .report { max-width: 900px; margin: 0 auto; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #10b981; }
        .logo { font-size: 24px; font-weight: bold; color: #10b981; }
        .logo span { color: #333; }
        .report-title h1 { font-size: 20px; }
        .report-title p { color: #666; font-size: 11px; margin-top: 4px; }
        .summary { display: flex; gap: 20px; margin-bottom: 25px; }
        .summary-card { flex: 1; background: #f9fafb; border-radius: 12px; padding: 16px; }
        .summary-card .label { font-size: 10px; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; }
        .summary-card .value { font-size: 18px; font-weight: bold; color: #333; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead { background: #f9fafb; }
        th { text-align: left; padding: 10px 12px; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .section-title { font-size: 14px; font-weight: 600; margin: 20px 0 10px; color: #333; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <div class="report">
        <div class="header">
            <div>
                <div class="logo">Toko<span>Ku</span></div>
                <p style="color: #666; font-size: 11px; margin-top: 4px;">{{ $sellerProfile->store_name }}</p>
            </div>
            <div class="report-title">
                <h1>LAPORAN PENJUALAN</h1>
                <p>Periode: {{ $fromDate }} s/d {{ $toDate }}</p>
                <p style="margin-top: 4px;">Dibuat: {{ now()->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="summary">
            <div class="summary-card">
                <div class="label">Total Revenue</div>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Transaksi</div>
                <div class="value">{{ $orderItems->count() }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Selesai</div>
                <div class="value">{{ $orderItems->where('status', 'completed')->count() }}</div>
            </div>
        </div>

        <div class="section-title">Produk Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-right">Terjual</th>
                    <th class="text-right">Stok</th>
                    <th class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="text-right">{{ $product->total_sold }}</td>
                        <td class="text-right">{{ $product->stock }}</td>
                        <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Detail Transaksi</div>
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Produk</th>
                    <th>Pembeli</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>{{ $item->order->order_number }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->order->user->name }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->updated_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem TokoKu.</p>
        </div>
    </div>
</body>
</html>
