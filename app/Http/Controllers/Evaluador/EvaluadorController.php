<?php

namespace App\Http\Controllers\Evaluador;
use App\Models\Notificacion;
use App\Models\Solicitud;
use App\Models\Documentos;
use App\Notifications\SolicitudAprobada;
use App\Http\Controllers\Controller;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluadorController extends Controller
{
    /**
     * Mostrar historial de evaluaciones con filtros
     */
    public function historial(Request $request)
{
    $query = \App\Models\Evaluacion::with('empresa');

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->whereHas('empresa', function($q2) use ($request) {
                $q2->where('razon_social', 'like', '%' . $request->search . '%');
            })->orWhere('codigo', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    if ($request->filled('desde')) {
        $query->whereDate('fecha_evaluacion', '>=', $request->desde);
    }

    if ($request->filled('hasta')) {
        $query->whereDate('fecha_evaluacion', '<=', $request->hasta);
    }

    $evaluaciones = $query->orderBy('fecha_evaluacion', 'desc')->paginate(10);

    return view('evaluador.historial', compact('evaluaciones'));
}


public function aprobarSolicitud($id)
{
    $solicitud = Solicitud::findOrFail($id);
    $solicitud->estado = 'aprobado';
    $solicitud->save();

    // Crear notificación
    Notificacion::create([
        'usuario_id' => $solicitud->empresa->usuario->id, // o como tengas la relación
        'mensaje' => "Tu solicitud del producto {$solicitud->producto_nombre} ha sido aprobada.",
        'leido' => 0,
        'fecha' => now(),
    ]);

    // Enviar correo
    \Mail::to($solicitud->empresa->email)->send(new SolicitudAprobadaMail($solicitud));

    return back()->with('success', 'Solicitud aprobada y notificación enviada.');
}



}
