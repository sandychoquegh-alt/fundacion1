<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documentos';
    protected $fillable = [
        'solicitud_id',
        'nombre_original',
        'tipo',
        'ruta',
        'archivo',
        'fecha_subida',
        'valido_hasta',
        'validado'
    ];

    public function solicitud()
{
    return $this->belongsTo(Solicitud::class);
}

}
