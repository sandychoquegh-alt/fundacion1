<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notifications'; // nombre de la tabla
    protected $fillable = ['usuario_id', 'mensaje', 'leido', 'fecha'];

    public $timestamps = false; // si no tienes created_at / updated_at
}
