<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Services\CacheService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\View\View;

class ExportData extends Component
{
    public string $activeTab = 'santri';
    
    // Santri Filters
    public ?int $santriKelasId = null;
    public string $santriStatus = '';
    public string $santriJenisKelamin = '';
    
    // Guru Filters
    public string $guruStatus = '';
    public string $guruBidangStudi = '';
    
    // Kelas Filters
    public string $kelasTingkat = '';
    
    // Jadwal Filters
    public ?int $jadwalKelasId = null;
    public ?int $jadwalGuruId = null;
    public string $jadwalHari = '';
    
    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
    
    protected function getExportStyles(): string
    {
        return '
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1a5c35; padding-bottom: 15px; }
                .header-table { width: 100%; border-collapse: collapse; }
                .header-table td { vertical-align: middle; }
                .logo-left { width: 80px; text-align: left; }
                .logo-right { width: 80px; text-align: right; }
                .header-center { text-align: center; padding: 0 10px; }
                .header-center h1 { font-size: 14px; margin: 0; color: #000; font-weight: bold; }
                .header-center h2 { font-size: 11px; margin: 3px 0; color: #000; font-weight: normal; }
                .header-center h3 { font-size: 18px; margin: 5px 0; color: #1a5c35; font-weight: bold; }
                .header-center h4 { font-size: 14px; margin: 3px 0; color: #000; font-weight: bold; }
                .header-center p { font-size: 10px; margin: 5px 0 0 0; color: #333; }
                .header-center .address { font-size: 9px; color: #333; }
                .logo { width: 70px; height: 70px; }
                .report-title { text-align: center; margin: 20px 0; background-color: #f3f4f6; padding: 10px; border-radius: 5px; }
                .report-title h3 { font-size: 16px; margin: 0; color: #000; text-transform: uppercase; font-weight: bold; }
                table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                th { background-color: #1a5c35; color: white; padding: 10px 8px; text-align: left; font-size: 11px; }
                td { padding: 8px; border: 1px solid #ddd; font-size: 11px; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }
                .meta { font-size: 10px; color: #666; margin-bottom: 20px; }
            </style>
        ';
    }

    protected function getHeader(string $title): string
    {
        return '
            <div class="header">
                <table class="header-table">
                    <tr>
                        <td class="logo-left">
                            <img src="' . public_path('img/logo.jpeg') . '" class="logo" alt="Logo">
                        </td>
                        <td class="header-center">
                            <h1>YAYASAN AMAL INSANI HAJI DAUD</h1>
                            <h2>PONDOK PESANTREN PANCASILA REO</h2>
                            <h3>MADRASAH TSANAWIYAH AN-NAJAH</h3>
                            <h4>REOK - MANGGARAI - NTT</h4>
                            <p class="address">Alamat : Kompleks Pondok Pesantren Pancasila Reo</p>
                            <p class="address">Jl. Raya Reo - Ruteng km.01, Kel. Mata Air Kec. Reok Kab. Manggarai Prov. NTT</p>
                        </td>
                        <td class="logo-right">
                            <img src="' . public_path('img/logo-4-rb.png') . '" class="logo" alt="Logo">
                        </td>
                    </tr>
                </table>
            </div>
        ';
    }

    protected function getFooter(): string
    {
        return '
            <div class="footer">
                <p>Dicetak pada: ' . now()->format('d/m/Y H:i') . ' | Dokumen ini digenerate secara otomatis oleh sistem.</p>
                <p>&copy; ' . date('Y') . ' Pondok Pesantren Pancasila Reo</p>
            </div>
        ';
    }

    // Export Santri
    public function exportSantriPdf()
    {
        $santris = $this->getSantriQuery()->limit(500)->get(); // Limit for PDF to prevent timeout
        $filterDesc = $this->getSantriFilterDescription();
        
        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Santri');
        $html .= '<div class="report-title"><h3>Daftar Santri</h3></div>';
        $html .= '<p class="meta">Total: ' . $santris->count() . ' santri' . ($filterDesc ? ' | Filter: ' . $filterDesc : '') . '</p>';
        
        $html .= '<table><thead><tr>
            <th>No</th><th>NIS</th><th>Nama Lengkap</th><th>L/P</th><th>Kelas</th><th>TTL</th><th>Status</th>
        </tr></thead><tbody>';
        
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
        
        $html .= '</tbody></table>' . $this->getFooter() . '</body></html>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return response()->streamDownload(fn() => print($pdf->output()), 'data-santri-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportSantriExcel()
    {
        $filename = 'data-santri-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'NIS', 'Nama Lengkap', 'Jenis Kelamin', 'Kelas', 'Tempat Lahir', 'Tanggal Lahir', 'Status']);
            
            $i = 0;
            // Use cursor() for memory efficiency
            foreach ($this->getSantriQuery()->cursor() as $s) {
                fputcsv($file, [
                    ++$i, $s->nis ?? '-', $s->nama_lengkap, $s->jenis_kelamin,
                    $s->kelas->nama_kelas ?? '-', $s->tempat_lahir ?? '-',
                    $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-', ucfirst($s->status ?? 'aktif'),
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    protected function getSantriQuery()
    {
        return Santri::with('kelas:id,nama_kelas')
            ->select('id', 'nis', 'nama_lengkap', 'jenis_kelamin', 'kelas_id', 'tempat_lahir', 'tanggal_lahir', 'status')
            ->when($this->santriKelasId, fn($q) => $q->where('kelas_id', $this->santriKelasId))
            ->when($this->santriStatus, fn($q) => $q->where('status', $this->santriStatus))
            ->when($this->santriJenisKelamin, fn($q) => $q->where('jenis_kelamin', $this->santriJenisKelamin))
            ->orderBy('nama_lengkap');
    }

    protected function getSantriFilterDescription()
    {
        $filters = [];
        if ($this->santriKelasId) {
            $kelas = Kelas::find($this->santriKelasId);
            if ($kelas) $filters[] = 'Kelas: ' . $kelas->nama_kelas;
        }
        if ($this->santriStatus) $filters[] = 'Status: ' . ucfirst($this->santriStatus);
        if ($this->santriJenisKelamin) $filters[] = 'Jenis Kelamin: ' . ($this->santriJenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan');
        return implode(', ', $filters);
    }

    // Export Guru
    public function exportGuruPdf()
    {
        $gurus = $this->getGuruQuery()->limit(500)->get();
        
        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Guru');
        $html .= '<div class="report-title"><h3>Daftar Guru</h3></div>';
        $html .= '<p class="meta">Total: ' . $gurus->count() . ' guru</p>';
        
        $html .= '<table><thead><tr>
            <th>No</th><th>NIP</th><th>Nama Lengkap</th><th>L/P</th><th>Bidang Studi</th><th>No. Telp</th><th>Status</th>
        </tr></thead><tbody>';
        
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
        
        $html .= '</tbody></table>' . $this->getFooter() . '</body></html>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return response()->streamDownload(fn() => print($pdf->output()), 'data-guru-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportGuruExcel()
    {
        $filename = 'data-guru-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'NIP', 'Nama Lengkap', 'Jenis Kelamin', 'Bidang Studi', 'No. Telp', 'Email', 'Status']);
            
            $i = 0;
            foreach ($this->getGuruQuery()->cursor() as $g) {
                fputcsv($file, [
                    ++$i, $g->nip ?? '-', $g->nama_lengkap, $g->jenis_kelamin ?? '-',
                    $g->bidang_studi ?? '-', $g->no_telp ?? '-', $g->email ?? '-', ucfirst($g->status ?? 'aktif'),
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    protected function getGuruQuery()
    {
        return Guru::query()
            ->select('id', 'nip', 'nama_lengkap', 'jenis_kelamin', 'bidang_studi', 'no_telp', 'email', 'status')
            ->when($this->guruStatus, fn($q) => $q->where('status', $this->guruStatus))
            ->when($this->guruBidangStudi, fn($q) => $q->where('bidang_studi', 'like', '%' . $this->guruBidangStudi . '%'))
            ->orderBy('nama_lengkap');
    }

    // Export Kelas
    public function exportKelasPdf()
    {
        $kelas = $this->getKelasQuery()->get();
        
        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Data Kelas');
        $html .= '<div class="report-title"><h3>Daftar Kelas</h3></div>';
        $html .= '<p class="meta">Total: ' . $kelas->count() . ' kelas</p>';
        
        $html .= '<table><thead><tr>
            <th>No</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th><th>Jumlah Santri</th><th>Kapasitas</th>
        </tr></thead><tbody>';
        
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
        
        $html .= '</tbody></table>' . $this->getFooter() . '</body></html>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
        return response()->streamDownload(fn() => print($pdf->output()), 'data-kelas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportKelasExcel()
    {
        $filename = 'data-kelas-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'Nama Kelas', 'Tingkat', 'Wali Kelas', 'Jumlah Santri', 'Kapasitas']);
            
            // Kelas is usually small, standard get() is fine
            $i = 0;
            foreach ($this->getKelasQuery()->get() as $k) {
                fputcsv($file, [
                    ++$i, $k->nama_kelas, $k->tingkat ?? '-',
                    $k->waliKelas->nama_lengkap ?? '-', $k->santris_count, $k->kapasitas ?? '-',
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    protected function getKelasQuery()
    {
        return Kelas::withCount('santris')->with('waliKelas:id,nama_lengkap')
            ->select('id', 'nama_kelas', 'tingkat', 'wali_id', 'kapasitas')
            ->when($this->kelasTingkat, fn($q) => $q->where('tingkat', $this->kelasTingkat))
            ->orderBy('nama_kelas');
    }

    // Export Jadwal
    public function exportJadwalPdf()
    {
        $jadwals = $this->getJadwalQuery()->limit(500)->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $html = '<!DOCTYPE html><html><head>' . $this->getExportStyles() . '</head><body>';
        $html .= $this->getHeader('Jadwal Mengajar');
        $html .= '<div class="report-title"><h3>Jadwal Pelajaran</h3></div>';
        $html .= '<p class="meta">Total: ' . $jadwals->count() . ' jadwal</p>';
        
        $html .= '<table><thead><tr>
            <th>No</th><th>Hari</th><th>Jam</th><th>Mata Pelajaran</th><th>Kelas</th><th>Guru</th>
        </tr></thead><tbody>';
        
        foreach ($jadwals as $i => $j) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . ($days[$j->hari - 1] ?? $j->hari) . '</td>
                <td>' . ($j->jam_mulai ? substr($j->jam_mulai, 0, 5) : '-') . ' - ' . ($j->jam_selesai ? substr($j->jam_selesai, 0, 5) : '-') . '</td>
                <td>' . ($j->mapel->nama ?? '-') . '</td>
                <td>' . ($j->kelas->nama_kelas ?? '-') . '</td>
                <td>' . ($j->guru->nama_lengkap ?? '-') . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>' . $this->getFooter() . '</body></html>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return response()->streamDownload(fn() => print($pdf->output()), 'jadwal-mengajar-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportJadwalExcel()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $filename = 'jadwal-mengajar-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];
        
        $callback = function() use ($days) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['No', 'Hari', 'Jam Mulai', 'Jam Selesai', 'Mata Pelajaran', 'Kelas', 'Guru']);
            
            $i = 0;
            foreach ($this->getJadwalQuery()->get() as $j) {
                fputcsv($file, [
                    ++$i, $days[$j->hari - 1] ?? $j->hari,
                    $j->jam_mulai ? substr($j->jam_mulai, 0, 5) : '-',
                    $j->jam_selesai ? substr($j->jam_selesai, 0, 5) : '-',
                    $j->mapel->nama ?? '-', 
                    $j->kelas->nama_kelas ?? '-', 
                    $j->guru->nama_lengkap ?? '-',
                ]);
            }
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    protected function getJadwalQuery()
    {
        return Jadwal::with(['kelas:id,nama_kelas', 'mapel:id,nama,kode', 'guru:id,nama_lengkap'])
            ->select('id', 'kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai')
            ->when($this->jadwalKelasId, fn($q) => $q->where('kelas_id', $this->jadwalKelasId))
            ->when($this->jadwalGuruId, fn($q) => $q->where('guru_id', $this->jadwalGuruId))
            ->when($this->jadwalHari, fn($q) => $q->where('hari', $this->jadwalHari))
            ->orderBy('hari')->orderBy('jam_mulai');
    }

    public function render(): View
    {
        // Use CacheService for static dropdown data
        $kelasList = CacheService::getKelasWithCounts();
        $guruList = CacheService::getGuruList();

        return view('livewire.admin.export-data', [
            'kelasList' => $kelasList,
            'guruList' => $guruList,
            'santriPreview' => $this->getSantriQuery()->limit(5)->get(),
            'guruPreview' => $this->getGuruQuery()->limit(5)->get(),
            'kelasPreview' => $this->getKelasQuery()->limit(5)->get(),
            'jadwalPreview' => $this->getJadwalQuery()->limit(5)->get(),
            'santriCount' => Santri::count(),
            'guruCount' => Guru::count(),
            'kelasCount' => Kelas::count(),
            'jadwalCount' => Jadwal::count(),
        ]);
    }
}
