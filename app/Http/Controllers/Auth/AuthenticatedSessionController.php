<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        // Autenticación mediante Laravel
        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }

        // Regenerar sesión para evitar fijación de sesión
        $request->session()->regenerate();

        // Obtener usuario autenticado
        $user = Auth::user();

        // Redirección según el rol
        switch ($user->rol_id) {

            case 1: // ADMIN
                return redirect()->route('empresa.dashboard');

            case 2: // EVALUADOR
                return redirect()->route('evaluador.dashboard');

            case 3: // EMPRESA
                return redirect()->route('empresad.dashboard');

            default:
                Auth::logout();

                return redirect('/login')->withErrors([
                    'email' => 'Su usuario no tiene un rol válido.',
                ]);
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
