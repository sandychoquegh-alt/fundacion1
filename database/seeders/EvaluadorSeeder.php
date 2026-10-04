<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class EvaluadorSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si ya existe el usuario evaluador
        if (!Usuario::where('email', 'evaluador@vaon.com')->exists()) {
            Usuario::create([
                'nombre' => 'Evaluador Sistema',
                'email' => 'evaluador@vaon.com',
                'password' => Hash::make('evaluador123'), // contraseña inicial
                'rol_id' => 2, // 👈 Este debe ser el rol del evaluador
                'activo' => 1
            ]);
        }
    }
}
