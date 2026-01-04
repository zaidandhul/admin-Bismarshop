<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analytics Penjualan</title>
</head>
<body>
<table border="0">
    <tr>
        <td colspan="5"><strong>Laporan Analytics Penjualan</strong></td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>{{ $periodLabel }}</td>
        <td></td>
        <td>Dibuat</td>
        <td>{{ $generatedAt }}</td>
    </tr>
</table>

<table border="1" cellspacing="0" cellpadding="4" style="margin-top:10px; border-collapse:collapse;">
    <thead>
        <tr>
            <th colspan="2" style="background:#f2f2f2;">Ringkasan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Omzet</td>
            <td>{{ $summary['totalSales']['amount'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Total Unit Terjual</td>
            <td>{{ $summary['totalSales']['count'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Total Pengunjung (perkiraan)</td>
            <td>{{ $summary['totalVisitors'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Rata-rata Pengunjung /hari</td>
            <td>{{ $avgVisitors ?? 0 }}</td>
        </tr>
        <tr>
            <td>Conversion Rate (%)</td>
            <td>{{ $summary['conversionRate'] ?? 0 }}</td>
        </tr>
    </tbody>
</table>

<table border="1" cellspacing="0" cellpadding="4" style="margin-top:15px; border-collapse:collapse;">
    <thead>
        <tr style="background:#f2f2f2;">
            <th>No</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Terjual</th>
            <th>Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($topProducts as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p['name'] ?? '-' }}</td>
                <td>{{ $p['category'] ?? '-' }}</td>
                <td>{{ $p['sold'] ?? 0 }}</td>
                <td>{{ $p['revenue'] ?? 0 }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Tidak ada data produk untuk periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
