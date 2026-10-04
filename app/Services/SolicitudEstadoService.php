<?php

namespace App\Services;

class SolicitudEstadoService
{
    public function determinar($accion)
    {
        return $accion === 'enviar'
            ? 'pendiente'
            : 'borrador';
    }
}