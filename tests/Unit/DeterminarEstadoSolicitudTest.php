<?php

namespace Tests\Unit;

use App\Services\SolicitudEstadoService;
use Tests\TestCase;

class DeterminarEstadoSolicitudTest extends TestCase
{
    public function test_una_solicitud_enviada_queda_pendiente(): void
    {
        $service = new SolicitudEstadoService();

        $estado = $service->determinar('enviar');

        $this->assertEquals('pendiente', $estado);
    }
}