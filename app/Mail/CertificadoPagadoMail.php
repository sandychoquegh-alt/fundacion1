<?php

namespace App\Mail;

use App\Models\Certificado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificadoPagadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificado;

    public function __construct(Certificado $certificado)
    {
        $this->certificado = $certificado;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificado VAON disponible',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificado-pagado',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}