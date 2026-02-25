<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Nilai</title>
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
            <h2 style="color: #1f2937; margin: 0 0 16px 0;">📊 Nilai Baru Tersedia</h2>
            
            <p style="color: #4b5563; line-height: 1.6;">Yth. Bapak/Ibu Wali Santri,</p>
            <p style="color: #4b5563; line-height: 1.6;">Dengan hormat, kami informasikan bahwa nilai terbaru untuk anak Bapak/Ibu telah tersedia di sistem:</p>

            <!-- Info Box -->
            <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Nama Santri:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $santri->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Kelas:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $santri->kelas->nama_kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Semester:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ ucfirst($semester) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Tahun Ajaran:</td>
                        <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $tahunAjaran }}</td>
                    </tr>
                </table>
            </div>

            <p style="color: #4b5563; line-height: 1.6;">Silakan login ke Portal Wali untuk melihat detail nilai lengkap anak Bapak/Ibu.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/wali/nilai') }}" style="display: inline-block; background-color: #16a34a; color: #ffffff; padding: 12px 32px; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    Lihat Nilai Sekarang
                </a>
            </div>

            <p style="color: #4b5563; line-height: 1.6; margin-top: 24px;">Hormat kami,<br><strong>Tim Akademik PONSPES</strong></p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p style="color: #9ca3af; font-size: 12px; margin: 8px 0 0 0;">© {{ date('Y') }} PONSPES Pancasila Reo. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
