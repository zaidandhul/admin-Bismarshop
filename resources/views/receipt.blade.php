<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        :root {
            --primary: #e74c3c;
            --primary-soft: #fdecea;
            --text-main: #2c3e50;
            --text-muted: #7f8c8d;
            --border-soft: #ecf0f1;
            --success: #27ae60;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            margin: 40px;
            background: #f4f6f8;
            color: var(--text-main);
        }

        .receipt {
            max-width: 520px;
            margin: auto;
            background: #ffffff;
            padding: 32px 32px 28px;
            border-radius: 14px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            border: 1px solid var(--border-soft);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-logo span {
            color: #fff;
            font-weight: 700;
            font-size: 18px;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.04em;
        }

        .brand-text small {
            display: block;
            margin-top: 2px;
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .badge-status {
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            background: var(--primary-soft);
            color: var(--primary);
            border: 1px solid rgba(231, 76, 60, 0.25);
        }

        .meta {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px 18px;
            padding: 10px 0 14px;
            border-bottom: 1px dashed var(--border-soft);
            font-size: 12px;
        }

        .meta-item strong {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.09em;
            margin-bottom: 2px;
        }

        .meta-item span {
            font-weight: 500;
        }

        .info {
            margin: 16px 0 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #fafafa;
            font-size: 13px;
            line-height: 1.6;
        }

        .info strong {
            display: inline-block;
            width: 88px;
            color: var(--text-muted);
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .info-row span {
            flex: 1;
        }

        table {
            width: 100%;
            margin: 18px 0 8px;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 9px 8px;
            text-align: left;
            border-bottom: 1px solid var(--border-soft);
        }

        th {
            background: #fafbfc;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
        }

        th.text-right,
        td.text-right {
            text-align: right;
        }

        th.text-center,
        td.text-center {
            text-align: center;
        }

        .summary {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            font-size: 13px;
        }

        .summary table {
            width: auto;
            margin: 0;
        }

        .summary td {
            border: none;
            padding: 4px 0 2px 18px;
        }

        .summary td.label {
            color: var(--text-muted);
        }

        .summary td.value {
            text-align: right;
        }

        .summary .grand-total {
            font-size: 1.15em;
            font-weight: 700;
            color: var(--success);
        }

        .footer {
            text-align: center;
            margin-top: 28px;
            color: var(--text-muted);
            font-size: 11px;
        }

        .print-btn {
            margin-top: 14px;
            padding: 9px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 8px 16px rgba(231, 76, 60, 0.35);
        }

        .print-btn:hover {
            background: #d62c1a;
        }

        @media print {
            body {
                background: white;
                margin: 0;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
                border: none;
                max-width: 100%;
                padding: 16px 18px;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="header">
        <div class="brand">
            <div class="brand-logo">
                <img src="/uploads/logo.png" alt="IndoBismar" onerror="this.style.display='none'; this.parentElement.innerHTML='<span>IB</span>';">
            </div>
            <div class="brand-text">
                <h1>IndoBismar</h1>
                <small>Struk Pembelian</small>
            </div>
        </div>
        <div>
            <span class="badge-status">#{{ $order->id }}</span>
        </div>
    </div>

    <div class="meta">
        <div class="meta-item">
            <strong>Tanggal</strong>
            <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</span>
        </div>
        <div class="meta-item">
            <strong>Customer</strong>
            <span>{{ $order->customer_name ?? 'Guest' }}</span>
        </div>
        <div class="meta-item">
            <strong>Status</strong>
            <span>{{ ucfirst($order->status ?? $order->order_status ?? 'pending') }}</span>
        </div>
    </div>

    <div class="info">
        <div style="margin-bottom:6px; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted);">Informasi Toko</div>
        <div class="info-row"><strong>Nama</strong> <span>IndoBismar Store</span></div>
        <div class="info-row"><strong>Alamat</strong> <span>Jl. Bendul Merisi Selatan XI No.59-61, Bendul Merisi, Kec.Wonocolo, Surabaya, Jawa Timur 60239.</span></div>
        <div class="info-row"><strong>Kontak</strong> <span>+62-8233-596-6079 &bull; email@indobismar.com</span></div>
    </div>

    <div class="info">
        <div class="info-row"><strong>Email</strong> <span>{{ $order->customer_email ?? '-' }}</span></div>
        <div class="info-row"><strong>Alamat</strong> <span>{{ $order->shipping_address ?? $order->address ?? '-' }}</span></div>
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
            @foreach($items as $item)
            <tr>
                <td>{{ $item->product_name ?? 'Produk' }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Total</td>
                <td class="value grand-total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Terima kasih telah berbelanja di BismarShop!<br>
        <button onclick="window.print()" class="print-btn">
            🖨️ Cetak Struk
        </button>
    </div>
</div>
</body>
</html>