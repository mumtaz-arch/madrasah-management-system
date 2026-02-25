<?php

namespace App\Livewire\Admin\Ai;

use App\Services\GeminiService;
use App\Models\Mapel;
use App\Models\Kelas;
use Livewire\Component;

class RppGenerator extends Component
{
    public ?int $mapel_id = null;
    public ?int $kelas_id = null;
    public string $topik = '';
    public int $durasi = 90;
    public string $result = '';
    public bool $loading = false;
    public ?string $error = null;

    public function generate()
    {
        $this->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'topik' => 'required|string|min:3',
            'durasi' => 'required|integer|min:30|max:180',
        ]);

        $this->loading = true;
        $this->error = null;
        $this->result = '';

        $mapel = Mapel::find($this->mapel_id);
        $kelas = Kelas::find($this->kelas_id);

        try {
            $service = new GeminiService();
            
            if (!$service->isConfigured()) {
                $this->loading = false;
                $this->error = 'Gemini API key belum dikonfigurasi. Tambahkan GEMINI_API_KEY di file .env';
                return;
            }
            
            $result = $service->generateRPP(
                $mapel->nama,
                $this->topik,
                $kelas->nama_kelas,
                $this->durasi
            );

            $this->loading = false;

            if ($result) {
                $this->result = $result;
            } else {
                $this->error = 'Gagal generate RPP. Silakan cek log untuk detail error.';
            }
        } catch (\Exception $e) {
            $this->loading = false;
            $this->error = 'Error: ' . $e->getMessage();
            \Log::error('RPP Generator Error: ' . $e->getMessage());
        }
    }

    public function clearResult()
    {
        $this->result = '';
        $this->error = null;
    }

    public function exportPdf()
    {
        if (empty($this->result)) {
            return;
        }

        $mapel = Mapel::find($this->mapel_id);
        $kelas = Kelas::find($this->kelas_id);
        
        $filename = 'RPP_' . ($mapel->nama ?? 'Mapel') . '_' . ($kelas->nama_kelas ?? 'Kelas') . '_' . date('Y-m-d') . '.pdf';
        
        // Format content for PDF
        $content = nl2br(e($this->result));
        
        // Use DomPDF logic via Facade if available, or manual instance if preferred
        // Since barryvdh/laravel-dompdf is installed:
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML('
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <style>
                    body { font-family: sans-serif; line-height: 1.6; }
                    h1 { text-align: center; margin-bottom: 20px; }
                    .content { white-space: pre-wrap; }
                </style>
            </head>
            <body>
                <h1>RENCANA PELAKSANAAN PEMBELAJARAN (RPP)</h1>
                <div class="content">
                    ' . $content . '
                </div>
            </body>
            </html>
        ');
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function exportDocx()
    {
        if (empty($this->result)) {
            return;
        }

        $mapel = Mapel::find($this->mapel_id);
        $kelas = Kelas::find($this->kelas_id);
        
        $filename = 'RPP_' . ($mapel->nama ?? 'Mapel') . '_' . ($kelas->nama_kelas ?? 'Kelas') . '_' . date('Y-m-d') . '.doc';
        
        $content = nl2br(e($this->result));

        // Create HTML content with Word-specific headers
        // xmlns:w="urn:schemas-microsoft-com:office:word" helps Word recognize it
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="utf-8">
            <title>RPP</title>
            <style>
                body { font-family: "Times New Roman", serif; font-size: 12pt; line-height: 1.5; }
                h1 { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <h1>RENCANA PELAKSANAAN PEMBELAJARAN (RPP)</h1>
            ' . $content . '
        </body>
        </html>';
        
        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.ai.rpp-generator', [
            'mapels' => Mapel::orderBy('nama')->get(),
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
        ]);
    }
}
