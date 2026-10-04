<?php

namespace App\Mail;

use App\Models\Visita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitaProgramadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visita;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct(Visita $visita)
    {
        $this->visita = $visita;

        // Cargar las relaciones necesarias para el correo
        $this->visita->load([
            'empresa',
            'evaluador',
            'solicitud.producto'
        ]);
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this
            ->subject('Visita programada - Sistema VAON')
            ->view('emails.visita-programada');
    }
}

