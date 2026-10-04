<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
     protected $table = 'evaluaciones'; //  Indicar tabla correcta
    protected $fillable = [
        
        'evaluador_id',
        'empresa_id',
        'codigo',
        'producto_nombre',
        'solicitud_id',
        'evaluador_id',
        'estado',
        'fecha_evaluacion',
        'informe',
        'resultado',
         'evidencia', // ESTO FALTABA
        'mano_obra_nacional',
        'insumo_nacional',
        'materia_prima_nacional',
        'observaciones'
      
    ];

    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

public function solicitud() {
    return $this->belongsTo(Solicitud::class, 'solicitud_id');
}


    // Relación con Evaluador (si lo tienes)
    public function evaluador()
    {
        return $this->belongsTo(Usuario::class, 'evaluador_id');
    }

}
