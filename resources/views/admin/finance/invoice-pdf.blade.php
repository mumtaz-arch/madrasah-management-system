<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 3px solid #166534;
            padding-bottom: 20px;
        }
        .logo-section h1 {
            font-size: 24px;
            color: #166534;
            margin-bottom: 5px;
        }
        .logo-section p {
            color: #666;
            font-size: 11px;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h2 {
            font-size: 28px;
            color: #166534;
            margin-bottom: 10px;
        }
        .invoice-info .number {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .invoice-info .date {
            color: #666;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #166534;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 5px 0;
            width: 150px;
            color: #666;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            font-weight: 500;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background: #166534;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.items td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        table.items tr:last-child td {
            border-bottom: 2px solid #166534;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            display: inline-block;
            width: 250px;
            text-align: left;
            margin-bottom: 10px;
        }
        .total-row.grand {
            background: #166534;
            color: white;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        .status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
        }
        .status.pending {
            background: #fef3c7;
            color: #d97706;
        }
        .status.paid {
            background: #d1fae5;
            color: #059669;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; margin-bottom: 40px; border-bottom: 3px solid #166534; padding-bottom: 20px;">
            <tr>
                <td style="width: 60%;">
                    <h1 style="font-size: 24px; color: #166534; margin-bottom: 5px;">PONPES PANCASILA REO</h1>
                    <p style="color: #666; font-size: 11px;">Jl. Reo, Manggarai - NTT</p>
                </td>
                <td style="text-align: right;">
                    <h2 style="font-size: 28px; color: #166534; margin-bottom: 10px;">INVOICE</h2>
                    <p style="font-size: 14px; font-weight: bold;">{{ $invoiceNumber }}</p>
                    <p style="color: #666;">{{ $generatedAt->format('d F Y') }}</p>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%;">
                    <p style="font-size: 11px; font-weight: bold; color: #166534; text-transform: uppercase; margin-bottom: 10px;">Ditagihkan Kepada</p>
                    <p style="font-weight: bold; font-size: 14px;">{{ $tagihan->santri->nama_lengkap ?? '-' }}</p>
                    <p>NIS: {{ $tagihan->santri->nis ?? '-' }}</p>
                    <p>Kelas: {{ $tagihan->santri->kelas->nama_kelas ?? '-' }}</p>
                </td>
                <td style="width: 50%; text-align: right;">
                    <p style="font-size: 11px; font-weight: bold; color: #166534; text-transform: uppercase; margin-bottom: 10px;">Detail Tagihan</p>
                    <p>Bulan: {{ \Carbon\Carbon::create($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}</p>
                    <p>Jatuh Tempo: {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d F Y') }}</p>
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 50%;">Deskripsi</th>
                    <th style="text-align: center;">Periode</th>
                    <th style="text-align: right;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $tagihan->paymentType->nama ?? 'SPP' }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::create($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div style="width: 100%; text-align: right;">
            <table style="width: auto; margin-left: auto; border-collapse: collapse;">
                <tr style="background: #166534; color: white;">
                    <td style="padding: 15px; font-weight: bold;">TOTAL</td>
                    <td style="padding: 15px; font-weight: bold; font-size: 18px;">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                </tr>
            </table>
            <br>
            <div style="margin-top: 10px;">
                <span class="status {{ $tagihan->status }}">
                    {{ $tagihan->status === 'paid' ? 'LUNAS' : ($tagihan->status === 'overdue' ? 'JATUH TEMPO' : 'BELUM DIBAYAR') }}
                </span>
            </div>
        </div>

        <div class="footer">
            <p>Dokumen ini digenerate secara otomatis pada {{ $generatedAt->format('d F Y H:i') }}</p>
            <p>Pondok Pesantren Pancasila Reo - Manggarai, NTT</p>
        </div>
    </div>
</body>
</html>
