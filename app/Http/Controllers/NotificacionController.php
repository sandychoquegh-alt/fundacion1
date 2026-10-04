<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Notifications\ComentarioSolicitudNotification;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function enviarComentario(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'mensaje'    => 'required|string'
        ]);

        Notificacion::create([
            'usuario_id' => $request->usuario_id,
            'mensaje'    => $request->mensaje,
            'leido'      => 0,
            'fecha'      => now(),
        ]);

        return back()->with('success', 'Mensaje enviado correctamente.');
    }

    public function listar(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id'
        ]);

        return Notificacion::where('usuario_id', $request->usuario_id)
            ->orderBy('fecha', 'asc')
            ->get();
    }


    public function enviarNotificacionEmpresas()
{
    $empresas = User::where('role', 'empresa')->get();

    foreach ($empresas as $empresa) {
        $empresa->notify(
            new NotificacionEmpresa('La administración ha publicado un nuevo aviso.')
        );
    }

    return back()->with('success', 'Notificaciones enviadas correctamente.');
}

public function marcarLeida($id)
{
    $notificacion = Auth::user()
        ->notifications()
        ->where('id', $id)
        ->first();

    if ($notificacion) {
        $notificacion->markAsRead();
    }

    return back();
}
}
