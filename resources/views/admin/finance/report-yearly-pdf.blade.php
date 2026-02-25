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
        .text-center { text-align: center; }
        .summary { margin-top: 20px; padding: 10px; background: #f9f9f9; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PONDOK PESANTREN</h1>
        <p>{{ $title }}</p>
        <p>Tahun: {{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="text-center">Jumlah Transaksi</th>
                <th class="text-right">Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $data)
                <tr>
                    <td>{{ $data['month'] }}</td>
                    <td class="text-center">{{ $data['count'] }}</td>
                    <td class="text-right">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Tahunan</th>
                <th class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ $generatedAt->format('d/m/Y H:i') }}
    </div>
</body>
</html>
