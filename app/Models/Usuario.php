<?php

namespace App\Models;



// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
    'nombre',
    'email',
    'password',
    'rol_id',
    'activo',
    'empresa_id'
];



    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }
    

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'usuario_id');
   
    return $this->hasOne(Empresa::class);
    return $this->belongsTo(Empresa::class);
    return $this->belongsTo(Empresa::class, 'empresa_id');



    }
 
    // app/Models/Usuario.php

public function notificaciones()
{
    return $this->hasMany(\App\Models\Notificacion::class, 'usuario_id', 'id');
}

public function evaluaciones()
{
    return $this->hasMany(Evaluacion::class, 'evaluador_id');
}

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    
}









