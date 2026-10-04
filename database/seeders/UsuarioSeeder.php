<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si ya existe el usuario admin
        if (!Usuario::where('email', 'empresa@vaon.com')->exists()) {
            Usuario::create([
                'nombre' => 'empresa',
                'email' => 'empresa@vaon.com',
                'password' => Hash::make('admin123'),
                'rol_id' => '2'
            ]);
        }
    }
}

