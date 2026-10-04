<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarPassword;

class RegistroEmpresaController extends Controller
{
    // Mostrar formulario
    public function showForm()
    {
        return view('auth.register');
    }

    
// Registrar empresa
public function registrar(Request $request)
{
    $request->validate([
        'razon_social' => 'required',
        'nit' => 'required',
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email',
        'telefono' => 'nullable'
    ]);

    // Generar contraseña automática
    $password = substr(
        str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ123456789'),
        0,
        8
    );

    /*
    |--------------------------------------------------------------------------
    | 1. CREAR EMPRESA
    |--------------------------------------------------------------------------
    */

    $empresa = Empresa::create([
        'razon_social' => $request->razon_social,
        'nit' => $request->nit,
        'representante' => $request->nombre,
        'telefono' => $request->telefono,
        'email' => $request->email,
    ]);

    /*
    |--------------------------------------------------------------------------
    | 2. CREAR USUARIO ASOCIADO A LA EMPRESA
    |--------------------------------------------------------------------------
    */

    $usuario = Usuario::create([
        'nombre' => $request->nombre,
        'email' => $request->email,
        'password' => Hash::make($password),
        'rol_id' => 3, // Rol empresa
        'activo' => 1,
        'empresa_id' => $empresa->id,
    ]);

    /*
    |--------------------------------------------------------------------------
    | 3. ENVIAR CONTRASEÑA AL CORREO
    |--------------------------------------------------------------------------
    */

    Mail::to($usuario->email)->send(
        new EnviarPassword($password)
    );

    /*
    |--------------------------------------------------------------------------
    | 4. REDIRECCIONAR AL LOGIN
    |--------------------------------------------------------------------------
    */

    return redirect()->route('login')
        ->with(
            'success',
            'Empresa registrada correctamente. Revisa tu correo para la contraseña.'
        );
}


}



