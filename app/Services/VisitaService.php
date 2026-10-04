<?php

namespace App\Services;

use App\Models\Visita;

class VisitaService
{

public function crearVisita($data)
    {
        return Visita::create($data);
    }
    public function programar($data, $evaluadorId)
    {
        return Visita::create([
            'solicitud_id' => $data['solicitud_id'],
            'empresa_id'   => $data['empresa_id'],
            'evaluador_id' => $evaluadorId,
            'fecha_visita' => $data['fecha_visita'],
        ]);
        
        return $visita;
    }
}