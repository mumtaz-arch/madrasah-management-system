<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Tagihan PPDB</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16pt; }
        .header p { margin: 2px 0; font-size: 10pt; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 8pt; color: white; display: inline-block; }
        .bg-paid { background-color: #28a745; }
        .bg-pending { background-color: #ffc107; color: black; }
        .bg-overdue { background-color: #dc3545; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan {{ $tab === 'riwayat' ? 'Riwayat Pembayaran' : 'Tagihan Belum Lunas' }}</h1>
        <p>
            Periode: 
            {{ $filters['bulan'] ? 'Bulan '.$filters['bulan'] : 'Semua Bulan' }} 
            {{ $filters['tahun'] ? 'Tahun '.$filters['tahun'] : 'Semua Tahun' }}
        </p>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Santri / NIS</th>
                <th style="width: 20%">Jenis Pembayaran</th>
                <th style="width: 15%">Periode</th>
                <th style="width: 15%" class="text-right">Nominal</th>
                <th style="width: 15%">{{ $tab === 'riwayat' ? 'Tanggal Bayar' : 'Jatuh Tempo' }}</th>
                @if($tab === 'riwayat')
                    <th style="width: 5%">Metode</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($data as $index => $item)
                @php $total += ($tab === 'riwayat' ? $item->nominal_bayar : $item->nominal); @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $item->santri->nama_lengkap ?? '-' }}<br>
                        <small style="color: #777">{{ $item->santri->nis ?? '-' }}</small>
                    </td>
                    <td>{{ $item->paymentType->nama ?? '-' }}</td>
                    <td>{{ $item->bulan_nama }} {{ $item->tahun }}</td>
                    <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if($tab === 'riwayat')
                            {{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}
                        @else
                            {{ $item->jatuh_tempo ? $item->jatuh_tempo->format('d/m/Y') : '-' }}
                        @endif
                    </td>
                    @if($tab === 'riwayat')
                        <td>{{ ucfirst($item->metode_bayar) }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                <td colspan="{{ $tab === 'riwayat' ? 2 : 1 }}"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
