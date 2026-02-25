<?php

namespace App\Mail;

use App\Models\Tagihan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TagihanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tagihan $tagihan,
        public string $type = 'new' // 'new', 'reminder', 'paid'
    ) {}

    public function envelope(): Envelope
    {
        $subject = match($this->type) {
            'new' => 'Tagihan Baru - ' . $this->tagihan->paymentType->nama,
            'reminder' => 'Pengingat Tagihan - ' . $this->tagihan->paymentType->nama,
            'paid' => 'Konfirmasi Pembayaran - ' . $this->tagihan->paymentType->nama,
            default => 'Informasi Tagihan',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tagihan-notification',
            with: [
                'tagihan' => $this->tagihan,
                'type' => $this->type,
            ],
        );
    }
}
