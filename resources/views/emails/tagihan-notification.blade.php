<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Tagihan</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #16a34a; padding: 32px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">PONSPES Pancasila Reo</h1>
            <p style="color: #bbf7d0; margin: 8px 0 0 0; font-size: 14px;">Sistem Informasi Pesantren</p>
        </div>

        <!-- Content -->
        <div style="padding: 32px;">
            @if($type === 'new')
                <h2 style="color: #1f2937; margin: 0 0 16px 0;">Tagihan Baru</h2>
                <p style="color: #4b5563; line-height: 1.6;">Yth. Bapak/Ibu Wali Santri,</p>
                <p style="color: #4b5563; line-height: 1.6;">Dengan hormat, kami informasikan bahwa terdapat tagihan baru untuk anak Bapak/Ibu:</p>
            @elseif($type === 'reminder')
                <h2 style="color: #f59e0b; margin: 0 0 16px 0;">⚠️ Pengingat Tagihan</h2>
                <p style="color: #4b5563; line-height: 1.6;">Yth. Bapak/Ibu Wali Santri,</p>
                <p style="color: #4b5563; line-height: 1.6;">Kami mengingatkan bahwa terdapat tagihan yang mendekati jatuh tempo:</p>
            @else
                <h2 style="color: #16a34a; margin: 0 0 16px 0;">✅ Pembayaran Diterima</h2>
                <p style="color: #4b5563; line-height: 1.6;">Yth. Bapak/Ibu Wali Santri,</p>
                <p style="color: #4b5563; line-height: 1.6;">Terima kasih, pembayaran Anda telah kami terima:</p>
            @endif

            <!-- Info Box -->
            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Nama Santri:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $tagihan->santri->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Jenis Tagihan:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $tagihan->paymentType->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Jumlah:</td>
                        <td style="padding: 8px 0; color: #16a34a; font-weight: 700; font-size: 18px;">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Jatuh Tempo:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>

            @if($type !== 'paid')
            <p style="color: #4b5563; line-height: 1.6;">Silakan melakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda keterlambatan.</p>
            @endif

            <p style="color: #4b5563; line-height: 1.6; margin-top: 24px;">Hormat kami,<br><strong>Tim Administrasi PONSPES</strong></p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p style="color: #9ca3af; font-size: 12px; margin: 8px 0 0 0;">© {{ date('Y') }} PONSPES Pancasila Reo. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
