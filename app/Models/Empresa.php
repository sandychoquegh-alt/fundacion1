<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


use Illuminate\Database\Eloquent\Model;

class Empresa extends Authenticatable
{
    use Notifiable;
    protected $table = 'empresas'; // tu tabla

    protected $fillable = [
    'razon_social',
    'nit',
    'representante',
    'telefono',
    'email',
    'direccion',
    'rubro',
    'sector',
    'fecha_registro',
    'usuario_id',
    'estado',
     'persona_contacto',
    'cargo',
    'celular',
     ];
     public $timestamps = true;

     public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
        return $this->belongsTo(Usuario::class);
        return $this->hasMany(Usuario::class);

    }
    public function usuarios()
{
    return $this->hasMany(Usuario::class, 'empresa_id');
}
    
     public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'empresa_id');
    }
    
    public function routeNotificationForMail()
{
    return $this->email;
}
public function certificados()
{
    return $this->hasMany(Certificado::class, 'empresa_id');
}

    
}



