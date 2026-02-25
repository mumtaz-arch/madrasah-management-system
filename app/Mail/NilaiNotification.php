<?php

namespace App\Mail;

use App\Models\Santri;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NilaiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Santri $santri,
        public string $semester,
        public string $tahunAjaran
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nilai Baru Tersedia - ' . $this->santri->nama_lengkap,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nilai-notification',
            with: [
                'santri' => $this->santri,
                'semester' => $this->semester,
                'tahunAjaran' => $this->tahunAjaran,
            ],
        );
    }
}
