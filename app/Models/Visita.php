<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visita extends Model
{
    protected $table = 'visitas';

    protected $fillable = [
        'empresa_id',
        'solicitud_id',
        'evaluador_id',
        'fecha_visita',
        'estado',
        'observaciones',
        'hora'
    ];

    /*
    |--------------------------------------------------------------------------
    | EMPRESA
    |--------------------------------------------------------------------------
    */

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /*
    |--------------------------------------------------------------------------
    | EVALUADOR
    |--------------------------------------------------------------------------
    */

    public function evaluador()
    {
        return $this->belongsTo(Usuario::class, 'evaluador_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SOLICITUD
    |--------------------------------------------------------------------------
    */

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FECHA PRO
    |--------------------------------------------------------------------------
    */

    public function getFechaProAttribute()
    {
        $fecha = $this->created_at;

        if ($fecha->isToday()) {
            return 'Hoy a las ' . $fecha->format('H:i');
        }

        if ($fecha->isYesterday()) {
            return 'Ayer a las ' . $fecha->format('H:i');
        }

        return $fecha->translatedFormat('d \d\e F \d\e Y - H:i');
    }
}

