<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run()
    {
        // Insert roles if not exist
        $roles = ['admin','evaluador','empresa'];
        foreach ($roles as $r) {
            DB::table('roles')->updateOrInsert(['nombre' => $r], ['created_at' => now(), 'updated_at' => now()]);
        }

        // Create admin user if not exists
        $adminEmail = 'admin@vaon.com';
        $existing = DB::table('usuarios')->where('email', $adminEmail)->first();
        $adminRoleId = DB::table('roles')->where('nombre', 'admin')->value('id');

        if (!$existing) {
            DB::table('usuarios')->insert([
                'nombre' => 'Administrador VAON',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), // cambia contraseña si quieres
                'rol_id' => $adminRoleId,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
