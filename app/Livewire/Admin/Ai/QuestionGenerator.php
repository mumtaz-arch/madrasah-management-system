<?php

namespace App\Livewire\Admin\Ai;

use App\Services\GeminiService;
use App\Models\Mapel;
use Livewire\Component;

class QuestionGenerator extends Component
{
    public ?int $mapel_id = null;
    public string $topik = '';
    public string $jenis = 'pilihan_ganda';
    public int $jumlah = 10;
    public string $result = '';
    public bool $loading = false;
    public ?string $error = null;

    public function generate()
    {
        $this->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'topik' => 'required|string|min:3',
            'jenis' => 'required|in:pilihan_ganda,essay',
            'jumlah' => 'required|integer|min:5|max:30',
        ]);

        $this->loading = true;
        $this->error = null;
        $this->result = '';

        $mapel = Mapel::find($this->mapel_id);

        $service = new GeminiService();
        $result = $service->generateQuestions(
            $mapel->nama,
            $this->topik,
            $this->jenis,
            $this->jumlah
        );

        $this->loading = false;

        if ($result) {
            $this->result = $result;
        } else {
            $this->error = 'Gagal generate soal. Pastikan API key sudah dikonfigurasi dengan benar.';
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
        
        $filename = 'Soal_' . ($mapel->nama ?? 'Mapel') . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $this->topik) . '_' . date('Y-m-d') . '.pdf';
        
        // Format content for PDF
        $content = nl2br(e($this->result));
        
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
                <h1>LATIHAN SOAL - ' . strtoupper($mapel->nama ?? '') . '</h1>
                <h3 style="text-align:center;">Topik: ' . htmlspecialchars($this->topik) . '</h3>
                <hr>
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
        
        $filename = 'Soal_' . ($mapel->nama ?? 'Mapel') . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $this->topik) . '_' . date('Y-m-d') . '.doc';
        
        $content = nl2br(e($this->result));

        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="utf-8">
            <title>Latihan Soal</title>
            <style>
                body { font-family: "Times New Roman", serif; font-size: 12pt; line-height: 1.5; }
                h1 { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 5px; }
                h3 { text-align: center; font-size: 12pt; font-weight: bold; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <h1>LATIHAN SOAL - ' . strtoupper($mapel->nama ?? '') . '</h1>
            <h3>Topik: ' . htmlspecialchars($this->topik) . '</h3>
            <hr>
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
        return view('livewire.admin.ai.question-generator', [
            'mapels' => Mapel::orderBy('nama')->get(),
        ]);
    }
}
