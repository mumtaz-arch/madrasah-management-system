<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor - {{ $santri->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #1a5f2d;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            color: #1a5f2d;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 14px;
            font-weight: normal;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .title {
            text-align: center;
            margin: 20px 0;
        }
        .title h3 {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
        }
        .info-table .label {
            width: 120px;
            font-weight: bold;
        }
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .nilai-table th, .nilai-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        .nilai-table th {
            background-color: #1a5f2d;
            color: white;
            font-weight: bold;
        }
        .nilai-table td.left {
            text-align: left;
        }
        .nilai-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 30px;
            text-align: right;
        }
        .summary-box {
            display: inline-block;
            border: 2px solid #1a5f2d;
            padding: 10px 20px;
            text-align: center;
        }
        .summary-box .label {
            font-size: 10px;
            color: #666;
        }
        .summary-box .value {
            font-size: 24px;
            font-weight: bold;
            color: #1a5f2d;
        }
        .signatures {
            margin-top: 50px;
            width: 100%;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 150px;
            margin: 60px auto 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PONDOK PESANTREN PONSPES</h1>
            <h2>Lembaga Pendidikan Islam Terpadu</h2>
            <p>Jl. Pesantren No. 123, Kota, Provinsi | Telp: (021) 12345678</p>
        </div>

        <div class="title">
            <h3>LAPORAN HASIL BELAJAR</h3>
            <p>Semester {{ $semester }} - Tahun Ajaran {{ $tahunAjaran }}</p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Nama Santri</td>
                <td>: {{ $santri->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td>: {{ $santri->nis }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: {{ $santri->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: {{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
        </table>

        <table class="nilai-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th class="left">Mata Pelajaran</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Rata-rata</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $index => $nilai)
                    @php
                        $avg = ($nilai->nilai_tugas + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
                        $predikat = match(true) {
                            $avg >= 90 => 'A',
                            $avg >= 80 => 'B',
                            $avg >= 70 => 'C',
                            $avg >= 60 => 'D',
                            default => 'E',
                        };
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="left">{{ $nilai->mapel->nama ?? '-' }}</td>
                        <td>{{ $nilai->nilai_tugas }}</td>
                        <td>{{ $nilai->nilai_uts }}</td>
                        <td>{{ $nilai->nilai_uas }}</td>
                        <td><strong>{{ number_format($avg, 1) }}</strong></td>
                        <td><strong>{{ $predikat }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada nilai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;">
                        <strong>Keterangan Predikat:</strong><br>
                        A = 90-100 (Sangat Baik)<br>
                        B = 80-89 (Baik)<br>
                        C = 70-79 (Cukup)<br>
                        D = 60-69 (Kurang)<br>
                        E = < 60 (Sangat Kurang)
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        <div style="border: 2px solid #1a5f2d; padding: 10px 20px; display: inline-block;">
                            <div style="font-size: 10px; color: #666;">Nilai Rata-rata</div>
                            <div style="font-size: 24px; font-weight: bold; color: #1a5f2d;">{{ $rataRata }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="signatures">
            <tr>
                <td>
                    <p>Wali Santri,</p>
                    <div class="signature-line"></div>
                    <p>( ........................... )</p>
                </td>
                <td>
                    <p>Kepala Madrasah,</p>
                    <div class="signature-line"></div>
                    <p>( ........................... )</p>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
            <p>Dokumen ini sah tanpa tanda tangan basah</p>
        </div>
    </div>
</body>
</html>
