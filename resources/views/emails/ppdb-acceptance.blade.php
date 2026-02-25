<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Anda Diterima!</title>
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
        .celebration {
            text-align: center;
            font-size: 48px;
            margin: 20px 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .content h2 {
            color: #16a34a;
            font-size: 22px;
            margin-bottom: 15px;
            text-align: center;
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
        .accepted-badge {
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
            color: white;
            text-align: center;
            padding: 25px;
            border-radius: 12px;
            margin: 25px 0;
        }
        .accepted-badge h3 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .accepted-badge p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .steps {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .steps h3 {
            color: #1e40af;
            margin-top: 0;
        }
        .steps ol {
            margin: 0;
            padding-left: 20px;
        }
        .steps li {
            margin: 10px 0;
            color: #1e3a8a;
        }
        .contact-box {
            background-color: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .contact-box h3 {
            color: #92400e;
            margin-top: 0;
        }
        .contact-box p {
            color: #78350f;
            margin: 5px 0;
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
        
        <div class="celebration">🎉🎊</div>
        
        <div class="content">
            <h2>SELAMAT!</h2>
            
            <p>Yth. Bapak/Ibu Orang Tua/Wali dari:</p>
            
            <div class="info-box">
                <p><strong>Nama Lengkap:</strong> {{ $registration->nama_lengkap }}</p>
                <p><strong>No. Registrasi:</strong></p>
                <div class="highlight">{{ $registration->no_pendaftaran }}</div>
            </div>
            
            <div class="accepted-badge">
                <h3>✓ DITERIMA</h3>
                <p>Sebagai Santri Baru Pondok Pesantren Pancasila Reo</p>
            </div>
            
            <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
            
            <p>Dengan penuh rasa syukur dan kebahagiaan, kami mengabarkan bahwa putra/putri Bapak/Ibu <strong style="color: #16a34a;">DINYATAKAN DITERIMA</strong> sebagai santri baru di Pondok Pesantren Pancasila Reo Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.</p>
            
            <p>Kami mengucapkan selamat bergabung dengan keluarga besar Pondok Pesantren Pancasila Reo. Semoga putra/putri Bapak/Ibu dapat menimba ilmu dengan baik dan menjadi generasi yang berakhlak mulia serta bermanfaat bagi agama, bangsa, dan negara.</p>
            
            <div class="steps">
                <h3>📋 Langkah Selanjutnya:</h3>
                <ol>
                    <li>Melakukan pembayaran biaya pendaftaran dan uang pangkal</li>
                    <li>Menyiapkan perlengkapan santri sesuai ketentuan</li>
                    <li>Hadir pada hari pertama masuk sesuai jadwal yang akan diinformasikan</li>
                    <li>Membawa dokumen asli untuk verifikasi ulang</li>
                </ol>
            </div>
            
            <div class="contact-box">
                <h3>📞 Hubungi Kami</h3>
                <p>Untuk informasi lebih lanjut, silakan hubungi Panitia PPDB melalui WhatsApp.</p>
                <p>Tim kami siap membantu menjawab pertanyaan Anda.</p>
            </div>
            
            <p>Sekali lagi, selamat bergabung dan semoga Allah SWT senantiasa memberkahi langkah putra/putri Bapak/Ibu dalam menuntut ilmu.</p>
            
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
