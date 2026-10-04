<?php

namespace App\Mail;

use App\Models\Certificado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificadoGeneradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificado;
    public $pdf;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct(Certificado $certificado, $pdf)
    {
        $this->certificado = $certificado;
        $this->pdf = $pdf;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this->subject(
            'Certificado VAON generado correctamente'
        )
        ->view('emails.certificado-generado')
        ->attachData(
            $this->pdf,
            'Certificado_VAON_' . $this->certificado->codigo . '.pdf',
            [
                'mime' => 'application/pdf',
            ]
        );
    }
}