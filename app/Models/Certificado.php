<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificados';

    protected $fillable = [
    'solicitud_id',
    'empresa_id',
    'codigo',
    'producto',
    'marca_comercial',
    'motivos_cert',
    'porcentaje_vaon',
    'imagen',
    'lugar_fabricacion',
    'fecha_emision',
    'fecha_vencimiento',
    'descripcion',
    'codigo',
    'archivo_pdf',
    'qr_texto',
    'archivo_pdf',
        'estado'
];

    // Relación: un certificado pertenece a una solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    // Relación indirecta: un certificado pertenece a una empresa a través de la solicitud
    public function empresa()
{
    return $this->belongsTo(Empresa::class, 'empresa_id');
}
   
public function producto()
{
    return $this->belongsTo(Producto::class, 'producto_id');
}


     /** CALCULO AUTOMÁTICO DEL ESTADO REAL */
    public function getEstadoCalculadoAttribute()
{
    $hoy = Carbon::today();
    $vencimiento = Carbon::parse($this->fecha_vencimiento);

    if ($hoy->gt($vencimiento)) {
        return 'Vencido';
    }

    if ($hoy->diffInDays($vencimiento) <= 30) {
        return 'Por_Expirar';
    }

    return 'Activo';
}
}
