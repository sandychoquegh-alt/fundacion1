<?php

namespace Tests\Feature\Empresa;

use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SolicitudTest extends TestCase
{
    use RefreshDatabase;

    public function test_solicitud_creation_page_can_be_displayed(): void
    {
        // Crear el rol de empresa para la prueba
        $rol = Role::create([
            'nombre' => 'Empresa',
        ]);

        // Crear usuario de prueba
        $usuario = Usuario::create([
            'nombre' => 'Empresa de Prueba',
            'email' => 'empresa@test.com',
            'password' => Hash::make('password'),
            'rol_id' => $rol->id,
            'activo' => 1,
        ]);

        // Autenticar al usuario y acceder al formulario
        $response = $this->actingAs($usuario)
            ->get('/empresa/solicitudes/crear');

        // Verificar que la página cargue correctamente
        $response->assertOk();
    }
}