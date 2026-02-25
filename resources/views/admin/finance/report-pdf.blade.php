<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .summary { margin-top: 20px; padding: 10px; background: #f9f9f9; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PONDOK PESANTREN</h1>
        <p>{{ $title }}</p>
        <p>Periode: {{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Santri</th>
                <th>Jenis Pembayaran</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->tanggal_bayar->format('d/m/Y') }}</td>
                    <td>{{ $payment->tagihan->santri->nama_lengkap ?? '-' }}</td>
                    <td>{{ $payment->tagihan->paymentType->nama ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong>
        <br><br>
        <strong>Rincian per Jenis:</strong>
        <ul>
            @foreach($byType as $type => $total)
                <li>{{ $type }}: Rp {{ number_format($total, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>

    <div class="footer">
        Dicetak pada: {{ $generatedAt->format('d/m/Y H:i') }}
    </div>
</body>
</html>
