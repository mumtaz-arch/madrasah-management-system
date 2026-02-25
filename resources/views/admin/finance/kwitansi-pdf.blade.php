<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi {{ $receiptNumber }}</title>
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
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #166534;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 20px;
            color: #166534;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 28px;
            color: #333;
            letter-spacing: 5px;
            margin-top: 15px;
        }
        .header p {
            color: #666;
            font-size: 11px;
        }
        .receipt-number {
            text-align: center;
            margin-bottom: 30px;
        }
        .receipt-number span {
            background: #166534;
            color: white;
            padding: 8px 30px;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .info-label {
            display: table-cell;
            width: 180px;
            padding: 5px 0;
            color: #666;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            font-weight: 500;
        }
        .amount-box {
            background: #f0fdf4;
            border: 2px solid #166534;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .amount-box .label {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .amount-box .amount {
            font-size: 32px;
            font-weight: bold;
            color: #166534;
        }
        .amount-box .terbilang {
            color: #666;
            font-style: italic;
            margin-top: 10px;
            font-size: 11px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature .place-date {
            margin-bottom: 60px;
        }
        .signature .name {
            font-weight: bold;
            border-top: 1px solid #333;
            display: inline-block;
            padding-top: 5px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .paid-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 60px;
            font-weight: bold;
            color: rgba(22, 101, 52, 0.15);
            letter-spacing: 10px;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container" style="position: relative;">
        <div class="paid-stamp">LUNAS</div>
        
        <div class="header">
            <h1>PONPES PANCASILA REO</h1>
            <p>Jl. Reo, Manggarai - NTT</p>
            <h2>KWITANSI</h2>
        </div>

        <div class="receipt-number">
            <span>{{ $receiptNumber }}</span>
        </div>

        <div style="margin-bottom: 20px;">
            <div class="info-row">
                <div class="info-label">Telah Diterima Dari</div>
                <div class="info-value">: <strong>{{ $tagihan->santri->nama_lengkap ?? '-' }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">NIS</div>
                <div class="info-value">: {{ $tagihan->santri->nis ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kelas</div>
                <div class="info-value">: {{ $tagihan->santri->kelas->nama_kelas ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Untuk Pembayaran</div>
                <div class="info-value">: {{ $tagihan->paymentType->nama ?? 'SPP' }} - {{ \Carbon\Carbon::create($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">: {{ ucfirst($tagihan->metode_bayar ?? 'Cash') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Bayar</div>
                <div class="info-value">: {{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d F Y') : '-' }}</div>
            </div>
        </div>

        <div class="amount-box">
            <div class="label">Jumlah Yang Dibayarkan</div>
            <div class="amount">Rp {{ number_format($tagihan->nominal_bayar ?? $tagihan->nominal, 0, ',', '.') }}</div>
            <div class="terbilang"># {{ ucwords(\App\Helpers\Terbilang::make($tagihan->nominal_bayar ?? $tagihan->nominal)) }} Rupiah #</div>
        </div>

        <div class="signature">
            <div class="place-date">Reo, {{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</div>
            <div class="name">Bendahara</div>
        </div>

        <div class="footer">
            <p>Dokumen ini adalah bukti pembayaran yang sah</p>
            <p>Digenerate pada {{ $generatedAt->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
