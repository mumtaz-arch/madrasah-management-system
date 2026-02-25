<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jadwal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DataExportController extends Controller
{
    protected function getExportStyles()
    {
        return '
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
                .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 15px; }
                .header-content { text-align: center; flex: 1; }
                .header h1 { font-size: 18px; margin: 0 0 5px 0; color: #000; }
                .header h2 { font-size: 14px; margin: 0 0 5px 0; font-weight: normal; color: #333; }
                .header p { font-size: 11px; margin: 0; color: #666; }
                .logo { width: 60px; height: 60px; }
                .report-title { text-align: center; margin: 20px 0; }
                .report-title h3 { font-size: 16px; margin: 0; color: #000; text-transform: uppercase; }
                table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                th { background-color: #333; color: white; padding: 10px 8px; text-align: left; font-size: 11px; }
                td { padding: 8px; border-bottom: 1px solid #ddd; font-size: 11px; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }
                .meta { font-size: 10px; color: #666; margin-bottom: 20px; }
            </style>
        ';
    }

    protected function getHeader($title)
    {
        return '
            <div class="header">
                <img src="' . public_path('img/logo-ponpes.png') . '" class="logo" alt="Logo">
                <div class="header-content">
                    <h1>Pondok Pesantren Pancasila Reo</h1>
                    <h2>' . $title . '</h2>
                    <p>Jl. Reo, Kec. Reok, Kab. Manggarai, Nusa Tenggara Timur</p>
                </div>
                <img src="' . public_path('img/logo-4-rb.png') . '" class="logo" alt="Logo">
            </div>
        ';
    }

    protected function getFooter()
    {
        return '
            <div class="footer">
                <p>Dicetak pada: ' . now()->format('d/m/Y H:i') . ' | Dokumen ini digenerate secara otomatis oleh sistem.</p>
                <p>&copy; ' . date('Y') . ' Pondok Pesantren Pancasila Reo</p>
            </div>
        ';
    }

    // Export Data Santri
    public function exportSantri(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $santris = Santri::with('kelas')->orderBy('nama_lengkap')->get();

        if ($format === 'excel') {
            return $this->exportSantriExcel($santris);
        }

        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Santri');
        $html .= '<div class="report-title"><h3>Daftar Santri</h3></div>';
        $html .= '<p class="meta">Total: ' . $santris->count() . ' santri</p>';
        
        $html .= '<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>Kelas</th>
                    <th>TTL</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($santris as $i => $s) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . ($s->nis ?? '-') . '</td>
                <td>' . $s->nama_lengkap . '</td>
                <td>' . $s->jenis_kelamin . '</td>
                <td>' . ($s->kelas->nama_kelas ?? '-') . '</td>
                <td>' . ($s->tempat_lahir ? $s->tempat_lahir . ', ' : '') . ($s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-') . '</td>
                <td>' . ucfirst($s->status ?? 'aktif') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= $this->getFooter();
        $html .= '</body></html>';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('data-santri-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportSantriExcel($santris)
    {
        $filename = 'data-santri-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() use ($santris) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($file, ['No', 'NIS', 'Nama Lengkap', 'Jenis Kelamin', 'Kelas', 'Tempat Lahir', 'Tanggal Lahir', 'Status']);
            
            foreach ($santris as $i => $s) {
                fputcsv($file, [
                    $i + 1,
                    $s->nis ?? '-',
                    $s->nama_lengkap,
                    $s->jenis_kelamin,
                    $s->kelas->nama_kelas ?? '-',
                    $s->tempat_lahir ?? '-',
                    $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-',
                    ucfirst($s->status ?? 'aktif'),
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // Export Data Guru
    public function exportGuru(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $gurus = Guru::orderBy('nama_lengkap')->get();

        if ($format === 'excel') {
            return $this->exportGuruExcel($gurus);
        }

        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Guru');
        $html .= '<div class="report-title"><h3>Daftar Guru</h3></div>';
        $html .= '<p class="meta">Total: ' . $gurus->count() . ' guru</p>';
        
        $html .= '<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>Bidang Studi</th>
                    <th>No. Telp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($gurus as $i => $g) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . ($g->nip ?? '-') . '</td>
                <td>' . $g->nama_lengkap . '</td>
                <td>' . ($g->jenis_kelamin ?? '-') . '</td>
                <td>' . ($g->bidang_studi ?? '-') . '</td>
                <td>' . ($g->no_telp ?? '-') . '</td>
                <td>' . ucfirst($g->status ?? 'aktif') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= $this->getFooter();
        $html .= '</body></html>';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('data-guru-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportGuruExcel($gurus)
    {
        $filename = 'data-guru-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() use ($gurus) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'NIP', 'Nama Lengkap', 'Jenis Kelamin', 'Bidang Studi', 'No. Telp', 'Email', 'Status']);
            
            foreach ($gurus as $i => $g) {
                fputcsv($file, [
                    $i + 1,
                    $g->nip ?? '-',
                    $g->nama_lengkap,
                    $g->jenis_kelamin ?? '-',
                    $g->bidang_studi ?? '-',
                    $g->no_telp ?? '-',
                    $g->email ?? '-',
                    ucfirst($g->status ?? 'aktif'),
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // Export Data Kelas
    public function exportKelas(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $kelas = Kelas::withCount('santris')->with('waliKelas')->orderBy('nama_kelas')->get();

        if ($format === 'excel') {
            return $this->exportKelasExcel($kelas);
        }

        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Kelas');
        $html .= '<div class="report-title"><h3>Daftar Kelas</h3></div>';
        $html .= '<p class="meta">Total: ' . $kelas->count() . ' kelas</p>';
        
        $html .= '<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Wali Kelas</th>
                    <th>Jumlah Santri</th>
                    <th>Kapasitas</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($kelas as $i => $k) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $k->nama_kelas . '</td>
                <td>' . ($k->tingkat ?? '-') . '</td>
                <td>' . ($k->waliKelas->nama_lengkap ?? '-') . '</td>
                <td>' . $k->santris_count . '</td>
                <td>' . ($k->kapasitas ?? '-') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= $this->getFooter();
        $html .= '</body></html>';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('data-kelas-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportKelasExcel($kelas)
    {
        $filename = 'data-kelas-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() use ($kelas) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'Nama Kelas', 'Tingkat', 'Wali Kelas', 'Jumlah Santri', 'Kapasitas']);
            
            foreach ($kelas as $i => $k) {
                fputcsv($file, [
                    $i + 1,
                    $k->nama_kelas,
                    $k->tingkat ?? '-',
                    $k->waliKelas->nama_lengkap ?? '-',
                    $k->santris_count,
                    $k->kapasitas ?? '-',
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // Export Data Jadwal
    public function exportJadwal(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $jadwals = Jadwal::with(['kelas', 'mapel', 'guru'])->orderBy('hari')->orderBy('jam_mulai')->get();

        if ($format === 'excel') {
            return $this->exportJadwalExcel($jadwals);
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Jadwal Mengajar');
        $html .= '<div class="report-title"><h3>Jadwal Pelajaran</h3></div>';
        $html .= '<p class="meta">Total: ' . $jadwals->count() . ' jadwal</p>';
        
        $html .= '<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Guru</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($jadwals as $i => $j) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . ($days[$j->hari - 1] ?? $j->hari) . '</td>
                <td>' . ($j->jam_mulai ? substr($j->jam_mulai, 0, 5) : '-') . ' - ' . ($j->jam_selesai ? substr($j->jam_selesai, 0, 5) : '-') . '</td>
                <td>' . ($j->mapel->nama_mapel ?? '-') . '</td>
                <td>' . ($j->kelas->nama_kelas ?? '-') . '</td>
                <td>' . ($j->guru->nama_lengkap ?? '-') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= $this->getFooter();
        $html .= '</body></html>';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('jadwal-mengajar-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportJadwalExcel($jadwals)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $filename = 'jadwal-mengajar-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() use ($jadwals, $days) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'Hari', 'Jam Mulai', 'Jam Selesai', 'Mata Pelajaran', 'Kelas', 'Guru']);
            
            foreach ($jadwals as $i => $j) {
                fputcsv($file, [
                    $i + 1,
                    $days[$j->hari - 1] ?? $j->hari,
                    $j->jam_mulai ? substr($j->jam_mulai, 0, 5) : '-',
                    $j->jam_selesai ? substr($j->jam_selesai, 0, 5) : '-',
                    $j->mapel->nama_mapel ?? '-',
                    $j->kelas->nama_kelas ?? '-',
                    $j->guru->nama_lengkap ?? '-',
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
