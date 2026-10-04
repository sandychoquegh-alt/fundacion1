<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudAsignadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this
            ->subject('Nueva solicitud asignada - Sistema VAON')
            ->view('emails.solicitud-asignada');
    }
}

