<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Telah Diverifikasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #16a34a;
        }
        .header h1 {
            color: #16a34a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
            font-size: 14px;
        }
        .content {
            margin-bottom: 30px;
        }
        .content h2 {
            color: #16a34a;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .info-box {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 5px 0;
        }
        .info-box strong {
            color: #166534;
        }
        .highlight {
            font-size: 24px;
            font-weight: bold;
            color: #16a34a;
            text-align: center;
            padding: 15px;
            background-color: #dcfce7;
            border-radius: 8px;
            margin: 20px 0;
        }
        .steps {
            background-color: #fefce8;
            border: 1px solid #fef08a;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .steps h3 {
            color: #854d0e;
            margin-top: 0;
        }
        .steps ol {
            margin: 0;
            padding-left: 20px;
        }
        .steps li {
            margin: 10px 0;
            color: #713f12;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pondok Pesantren Pancasila Reo</h1>
            <p>Penerimaan Peserta Didik Baru (PPDB)</p>
        </div>
        
        <div class="content">
            <h2>Assalamu'alaikum Warahmatullahi Wabarakatuh</h2>
            
            <p>Yth. Bapak/Ibu Orang Tua/Wali dari:</p>
            
            <div class="info-box">
                <p><strong>Nama Lengkap:</strong> {{ $registration->nama_lengkap }}</p>
                <p><strong>No. Registrasi:</strong></p>
                <div class="highlight">{{ $registration->no_pendaftaran }}</div>
            </div>
            
            <p>Dengan hormat,</p>
            
            <p>Kami informasikan bahwa pendaftaran calon santri atas nama tersebut di atas <strong style="color: #16a34a;">telah berhasil diverifikasi</strong>.</p>
            
            <p>Tim Panitia PPDB telah melakukan pengecekan terhadap kelengkapan dokumen yang Anda kirimkan. Berkas pendaftaran Anda dinyatakan lengkap dan memenuhi syarat untuk diproses ke tahap selanjutnya.</p>
            
            <div class="steps">
                <h3>📋 Langkah Selanjutnya:</h3>
                <ol>
                    <li>Menunggu proses seleksi oleh Tim Panitia PPDB</li>
                    <li>Anda akan menerima email kembali mengenai status penerimaan</li>
                    <li>Jika ada pertanyaan, silakan hubungi panitia melalui WhatsApp</li>
                </ol>
            </div>
            
            <p>Terima kasih telah mempercayakan pendidikan putra/putri Anda kepada Pondok Pesantren Pancasila Reo.</p>
            
            <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh</p>
        </div>
        
        <div class="footer">
            <p><strong>Panitia PPDB Pondok Pesantren Pancasila Reo</strong></p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>© {{ date('Y') }} Ponpes Pancasila Reo. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
