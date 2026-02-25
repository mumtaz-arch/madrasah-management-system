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
        .stats { display: flex; justify-content: space-between; margin: 20px 0; }
        .stat-box { padding: 15px; background: #f9f9f9; border: 1px solid #ddd; text-align: center; width: 30%; }
        .stat-box h3 { margin: 0 0 5px; font-size: 11px; color: #666; }
        .stat-box p { margin: 0; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .section { margin-top: 25px; }
        .section h2 { font-size: 14px; border-bottom: 1px solid #333; padding-bottom: 5px; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PONDOK PESANTREN</h1>
        <p>{{ $title }}</p>
    </div>

    <table style="border: none;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 15px; text-align: center; width: 33%;">
                <small style="color: #666;">Total Tagihan</small><br>
                <strong style="font-size: 14px;">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</strong>
            </td>
            <td style="border: 1px solid #ddd; padding: 15px; text-align: center; width: 33%; background: #e8f5e9;">
                <small style="color: #666;">Total Terbayar</small><br>
                <strong style="font-size: 14px; color: #2e7d32;">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</strong>
            </td>
            <td style="border: 1px solid #ddd; padding: 15px; text-align: center; width: 33%; background: #ffebee;">
                <small style="color: #666;">Total Tunggakan</small><br>
                <strong style="font-size: 14px; color: #c62828;">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</strong>
            </td>
        </tr>
    </table>

    <div class="section">
        <h2>Status Tagihan</h2>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihanByStatus as $status)
                    <tr>
                        <td>{{ ucfirst($status->status) }}</td>
                        <td class="text-center">{{ $status->count }}</td>
                        <td class="text-right">Rp {{ number_format($status->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>20 Pembayaran Terakhir</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Santri</th>
                    <th>Jenis</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPayments as $payment)
                    <tr>
                        <td>{{ $payment->tanggal_bayar->format('d/m/Y') }}</td>
                        <td>{{ $payment->tagihan->santri->nama_lengkap ?? '-' }}</td>
                        <td>{{ $payment->tagihan->paymentType->nama ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ $generatedAt->format('d/m/Y H:i') }}
    </div>
</body>
</html>
