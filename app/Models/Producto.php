<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Tabla asociada (opcional si sigue la convención)
    protected $table = 'productos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'empresa_id',
        'nombre',
        'solicitud_id',
        'marca',
        'codigo_interno',
        'descripcion',
    ];

    /**
     * Relación con la empresa propietaria del producto
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación con las solicitudes de este producto
     */

  
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
    public function solicitud()
{
    return $this->belongsTo(Solicitud::class, 'solicitud_id');
}
    public $timestamps = true; // Esto por defecto ya está habilitado si usas Model
     
    public function evaluaciones()
{
    return $this->hasMany(Evaluacion::class);
}
}
