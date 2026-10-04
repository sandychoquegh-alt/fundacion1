<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\Producto;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'empresa_id',
        'producto_id',
        'producto_nombre',
        'marca',
        'descripcion',
        'diagrama',
        'imagen',
        'declaracion_jurada',
        'respaldos',
        'accion',
        'estado',
        'fecha_solicitud',
        'fecha_evaluacion',
        'evaluador_id'
    ];
    

    protected $casts = [
        'respaldos' => 'array',
        'fecha_solicitud' => 'datetime',
    ];

   public function empresa()
{
    return $this->belongsTo(Empresa::class, 'empresa_id');
}


    public function empresas()
    {
        return $this->belongsTo(Usuario::class,'empresa_id');
    }

   public function documentos()
{
    return $this->hasMany(Documento::class);
}

public function producto()
{
    return $this->belongsTo(Producto::class, 'producto_id');
}
public function productos()
{
    return $this->hasMany(Producto::class, 'solicitud_id');
}

public function comentarios()
{
    return $this->hasMany(ComentarioSolicitud::class);
}

//public function user()
//{
  //  return $this->belongsTo(User::class, 'user_id');
//}
public function evaluador()
{
    return $this->belongsTo(Usuario::class, 'evaluador_id');
}


public function visitas()
{
    return $this->hasMany(Visita::class);
}

}
