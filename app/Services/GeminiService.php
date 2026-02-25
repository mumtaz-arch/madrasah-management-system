<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY', ''));
    }

    /**
     * Check if API key is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && strlen($this->apiKey) > 10;
    }

    /**
     * Generate content using Gemini API
     */
    public function generate(string $prompt): ?string
    {
        if (!$this->isConfigured()) {
            Log::warning('Gemini API key not configured or invalid');
            return null;
        }

        try {
            $response = Http::timeout(120)->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 8192,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }

            Log::error('Gemini API error: ' . $response->status() . ' - ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini API exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate RPP (Rencana Pelaksanaan Pembelajaran)
     */
    public function generateRPP(string $mapel, string $topik, string $kelas, int $durasi = 90): ?string
    {
        $schoolName = 'MTs An Najah Reo';
        
        $prompt = <<<PROMPT
Buatkan Rencana Pelaksanaan Pembelajaran (RPP) untuk:
- Nama Sekolah: {$schoolName}
- Mata Pelajaran: {$mapel}
- Topik/Materi: {$topik}
- Kelas: {$kelas}
- Durasi: {$durasi} menit

Format RPP harus mencakup:
1. Identitas (Sekolah: {$schoolName}, Mata Pelajaran, Kelas, Alokasi Waktu)
2. Kompetensi Inti
3. Kompetensi Dasar dan Indikator Pencapaian
4. Tujuan Pembelajaran
5. Materi Pembelajaran
6. Metode Pembelajaran
7. Kegiatan Pembelajaran (Pendahuluan, Inti, Penutup)
8. Penilaian
9. Sumber Belajar

Gunakan format yang rapi dan profesional dalam Bahasa Indonesia.
PROMPT;

        return $this->generate($prompt);
    }

    /**
     * Generate exam questions
     */
    public function generateQuestions(string $mapel, string $topik, string $jenis = 'pilihan_ganda', int $jumlah = 10): ?string
    {
        $jenisText = $jenis === 'pilihan_ganda' ? 'pilihan ganda (dengan 4 pilihan A, B, C, D dan kunci jawaban)' : 'essay (dengan contoh jawaban)';
        
        $prompt = <<<PROMPT
Buatkan {$jumlah} soal {$jenisText} untuk:
- Mata Pelajaran: {$mapel}
- Topik/Materi: {$topik}

Kriteria soal:
1. Variasikan tingkat kesulitan (mudah, sedang, sulit)
2. Soal harus jelas dan tidak ambigu
3. Untuk pilihan ganda, pastikan hanya ada 1 jawaban benar
4. Sertakan nomor soal

Format output:
---
Soal [nomor]:
[isi soal]

A. [pilihan A]
B. [pilihan B]
C. [pilihan C]
D. [pilihan D]

Jawaban: [huruf jawaban benar]
---

Gunakan Bahasa Indonesia yang baik dan benar.
PROMPT;

        return $this->generate($prompt);
    }

    /**
     * Summarize text
     */
    public function summarize(string $text, int $maxWords = 200): ?string
    {
        $prompt = "Ringkas teks berikut dalam maksimal {$maxWords} kata, dalam Bahasa Indonesia:\n\n{$text}";
        return $this->generate($prompt);
    }
}
