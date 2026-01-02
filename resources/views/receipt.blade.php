<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f8f9fa; }
        .receipt { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2c3e50; }
        .info { margin: 15px 0; line-height: 1.6; }
        .info strong { display: inline-block; width: 120px; }
        table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .total { font-size: 1.3em; font-weight: bold; text-align: right; margin-top: 20px; color: #27ae60; }
        .footer { text-align: center; margin-top: 40px; color: #7f8c8d; font-size: 0.9em; }
        @media print {
            body { background: white; margin: 0; }
            .receipt { box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="header">
        <h1>BismarShop</h1>
        <p>Struk Pembelian</p>
    </div>

    <div class="info">
        <strong>Order ID:</strong> #{{ $order->id }}<br>
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}<br>
        <strong>Customer:</strong> {{ $order->customer_name ?? 'Guest' }}<br>
        <strong>Email:</strong> {{ $order->customer_email ?? '-' }}<br>
        <strong>Alamat:</strong> {{ $order->shipping_address ?? $order->address ?? '-' }}
    </div>

    <table>
        <thead>
            <tr><th>Produk</th><th class="text-right">Harga</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->product_name ?? 'Produk' }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
    </div>

    <div class="footer">
        Terima kasih telah berbelanja di BismarShop!<br>
        <button onclick="window.print()" style="margin-top:15px;padding:10px 20px;background:#3498db;color:white;border:none;border-radius:5px;cursor:pointer;">
            🖨️ Cetak Struk
        </button>
    </div>
</div>
</body>
</html>