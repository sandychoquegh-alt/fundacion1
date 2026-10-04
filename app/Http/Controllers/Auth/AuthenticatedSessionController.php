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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intento de login
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }

        // Regenerar sesión
        $request->session()->regenerate();

        // Obtener usuario autenticado
        $user = Auth::user();

        // 🔥 Redirección por rol (ORDEN CORRECTO)
        switch ($user->rol_id) {

            case 1:   // ADMIN
        return redirect()->route('empresa.dashboard');
        break;

            case 2:   // EVALUADOR
                return redirect()->route('evaluador.dashboard'); 
                break;

            case 3:   // EMPRESA
                return redirect()->route('empresad.dashboard'); 
                break;

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
