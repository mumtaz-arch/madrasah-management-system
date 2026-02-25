<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #1e40af; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 20px; color: #1e40af; }
        .header p { margin: 5px 0; color: #666; }
        .section { margin-bottom: 25px; }
        .section h2 { font-size: 14px; color: #1e40af; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; margin-bottom: 10px; }
        .stats-grid { display: table; width: 100%; }
        .stats-row { display: table-row; }
        .stat-box { display: table-cell; width: 25%; padding: 10px; text-align: center; border: 1px solid #e5e7eb; }
        .stat-box h3 { margin: 0; font-size: 18px; color: #1e40af; }
        .stat-box p { margin: 5px 0 0; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PONDOK PESANTREN</h1>
        <p>{{ $title }}</p>
        <p>Periode: {{ $periode }}</p>
    </div>

    {{-- Summary Statistics --}}
    <div class="section">
        <h2>Ringkasan Statistik</h2>
        <table>
            <tr>
                <td style="width: 25%; text-align: center; background: #eff6ff;">
                    <strong style="font-size: 20px; color: #1e40af;">{{ number_format($santri['total']) }}</strong>
                    <br><small>Total Santri</small>
                </td>
                <td style="width: 25%; text-align: center; background: #f0fdf4;">
                    <strong style="font-size: 20px; color: #166534;">{{ number_format($guru['total']) }}</strong>
                    <br><small>Total Guru</small>
                </td>
                <td style="width: 25%; text-align: center; background: #fefce8;">
                    <strong style="font-size: 20px; color: #854d0e;">{{ number_format($akademik['totalKelas']) }}</strong>
                    <br><small>Total Kelas</small>
                </td>
                <td style="width: 25%; text-align: center; background: #fdf2f8;">
                    <strong style="font-size: 20px; color: #9d174d;">{{ $akademik['attendanceRate'] }}%</strong>
                    <br><small>Tingkat Kehadiran</small>
                </td>
            </tr>
        </table>
    </div>

    {{-- Financial Summary --}}
    <div class="section">
        <h2>Ringkasan Keuangan</h2>
        <table>
            <tr>
                <th>Kategori</th>
                <th class="text-right">Jumlah</th>
            </tr>
            <tr>
                <td>Total Tagihan</td>
                <td class="text-right">Rp {{ number_format($keuangan['totalTagihan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Terbayar</td>
                <td class="text-right" style="color: #166534;">Rp {{ number_format($keuangan['totalTerbayar'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Tunggakan</td>
                <td class="text-right" style="color: #991b1b;">Rp {{ number_format($keuangan['totalTunggakan'], 0, ',', '.') }}</td>
            </tr>
            <tr style="background: #f3f4f6;">
                <td><strong>Pemasukan Bulan Ini</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($keuangan['thisMonth'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    {{-- Santri per Kelas --}}
    <div class="section">
        <h2>Distribusi Santri per Kelas</h2>
        <table>
            <tr>
                <th>Kelas</th>
                <th class="text-center">Jumlah Santri</th>
            </tr>
            @foreach($santri['byKelas'] as $kelas)
            <tr>
                <td>{{ $kelas->nama_kelas }}</td>
                <td class="text-center">{{ $kelas->santris_count }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    {{-- PPDB Statistics --}}
    <div class="section">
        <h2>Statistik PPDB Tahun Ini</h2>
        <table>
            <tr>
                <th>Status</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Persentase</th>
            </tr>
            <tr>
                <td>Total Pendaftar</td>
                <td class="text-center"><strong>{{ $ppdb['total'] }}</strong></td>
                <td class="text-center">100%</td>
            </tr>
            <tr>
                <td>Diterima</td>
                <td class="text-center" style="color: #166534;">{{ $ppdb['diterima'] }}</td>
                <td class="text-center">{{ $ppdb['total'] > 0 ? round(($ppdb['diterima'] / $ppdb['total']) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td>Pending</td>
                <td class="text-center" style="color: #854d0e;">{{ $ppdb['pending'] }}</td>
                <td class="text-center">{{ $ppdb['total'] > 0 ? round(($ppdb['pending'] / $ppdb['total']) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td>Ditolak</td>
                <td class="text-center" style="color: #991b1b;">{{ $ppdb['ditolak'] }}</td>
                <td class="text-center">{{ $ppdb['total'] > 0 ? round(($ppdb['ditolak'] / $ppdb['total']) * 100, 1) : 0 }}%</td>
            </tr>
        </table>
    </div>

    {{-- Monthly Trends --}}
    <div class="section">
        <h2>Tren 6 Bulan Terakhir</h2>
        <table>
            <tr>
                <th>Bulan</th>
                <th class="text-center">Santri Baru</th>
                <th class="text-right">Pemasukan</th>
            </tr>
            @foreach($trends as $trend)
            <tr>
                <td>{{ $trend['month'] }}</td>
                <td class="text-center">{{ $trend['santri'] }}</td>
                <td class="text-right">Rp {{ number_format($trend['payments'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="footer">
        <p>Laporan digenerate pada: {{ $generatedAt->format('d/m/Y H:i') }}</p>
        <p>Sistem Informasi Pondok Pesantren</p>
    </div>
</body>
</html>
