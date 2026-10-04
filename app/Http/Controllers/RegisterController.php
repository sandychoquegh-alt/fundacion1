<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\EnviarPasswordNotificacion;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Exception;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }


    public function store(Request $request)
{
    $request->validate([
        'nombre'       => 'required|string|max:255',
        'email'        => 'required|email|unique:usuarios,email',
        'razon_social' => 'required|string|max:255',
        'nit'          => 'required|unique:empresas,nit',
        'telefono'     => 'nullable|string|max:20',
    ]);

    try {

        DB::beginTransaction();

        // 🔐 Generar contraseña automática
        $passwordPlano = Str::random(10);

        // 👤 Crear usuario (SIN empresa_id todavía)
        $usuario = Usuario::create([
            'nombre'  => $request->nombre,
            'email'   => $request->email,
            'password'=> Hash::make($passwordPlano),
            'rol_id'  => 3, // 🔥 EMPRESA
        ]);

        // 🏢 Crear empresa
        $empresa = Empresa::create([
            'usuario_id'  => $usuario->id,
            'razon_social'=> $request->razon_social,
            'nit'         => $request->nit,
            'telefono'    => $request->telefono,
        ]);

        // 🔥 AHORA sí asignamos la empresa al usuario
        $usuario->empresa_id = $empresa->id;
        $usuario->save();

        DB::commit();

        return redirect()->route('auth.register')
            ->with('success', 'Registro realizado correctamente. Revise su correo electrónico para su contraseña.');

    } catch (Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', 'No se pudo registrar, inténtelo nuevamente.');
    }
}
}

