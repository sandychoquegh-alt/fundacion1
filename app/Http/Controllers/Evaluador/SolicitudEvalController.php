<?php
//TODO ESTE CONTROLADOR ES PARA QUE EL ADMINSTRADOR LA PUEDA VER : ES DEL ADMINTRADOR

namespace App\Http\Controllers\Evaluador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Documento;
use App\Models\Usuario;
use App\Models\Evaluacion;
use App\Models\Producto;
use App\Models\Notificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudAsignadaMail;

use App\Notifications\ComentarioSolicitudNotification;

class SolicitudEvalController extends Controller
{
    // Mostrar lista de solicitudes
    public function index()
{
    $solicitudes = Solicitud::with(['empresa', 'productos'])
        ->whereIn('estado', ['pendiente', 'en_revision'])
        ->orderBy('id', 'DESC')
        ->get();

    return view('evaluador.solicitudes.index', compact('solicitudes'));
}

  
// Mostrar una solicitud específica
public function show($id)
{
    $solicitud = Solicitud::with([
    'documentos',
    'producto',
    'empresa',
    'evaluador'
])->findOrFail($id);

    // Obtener únicamente usuarios que tienen rol de Evaluador
    $evaluadores = Usuario::where('rol_id', 2)
        ->where('activo', 1)
        ->get();

    return view(
        'evaluador.solicitudes.show',
        compact('solicitud', 'evaluadores')
    );
}



   

public function verArchivo($solicitud_id, $tipo)
{
    $permitidos = [
        'diagrama',
        'imagen',
        'declaracion',
        'respaldo'
    ];

    if (!in_array($tipo, $permitidos)) {
        abort(403);
    }

    $documentos = Documento::where('solicitud_id', $solicitud_id)
        ->where('tipo', $tipo)
        ->get();

    if ($documentos->isEmpty()) {
        abort(404, 'Archivo no encontrado');
    }


    // ==========================================
    // IMÁGENES
    // ==========================================

    if ($tipo === 'imagen') {

        return view(
            'evaluador.solicitudes.imagenes',
            compact('documentos')
        );
    }


    // ==========================================
    // RESPALDOS
    // ==========================================

    if ($tipo === 'respaldo') {

        return view(
            'evaluador.solicitudes.respaldo',
            compact('documentos')
        );
    }


    // ==========================================
    // DIAGRAMA / DECLARACIÓN
    // ==========================================

    $documento = $documentos->first();

    if (!Storage::disk('public')->exists($documento->ruta)) {
        abort(404, 'El archivo no existe en almacenamiento.');
    }

    return response()->file(
        storage_path(
            'app/public/' . $documento->ruta
        )
    );
}
   
  
public function cambiarEstado(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|in:Pendiente,en_revision,Aprobado,Rechazado',
        'evaluador_id' => 'nullable|exists:usuarios,id'
    ]);

    $solicitud = Solicitud::findOrFail($id);

    // Guardar el evaluador anterior
    $evaluadorAnterior = $solicitud->evaluador_id;

    // Actualizar estado
    $solicitud->estado = $request->estado;

    // Asignar evaluador
    if ($request->evaluador_id) {
        $solicitud->evaluador_id = $request->evaluador_id;
    }

    // Fecha automática
    if ($request->estado !== 'Pendiente') {
        $solicitud->fecha_evaluacion = now();
    }

    $solicitud->save();

    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIÓN AL EVALUADOR
    |--------------------------------------------------------------------------
    |
    | Se enviará cuando:
    | - La solicitud esté en revisión.
    | - Exista un evaluador asignado.
    | - El evaluador sea nuevo/diferente al anterior.
    |
    */

    if (
        $solicitud->estado === 'en_revision' &&
        $solicitud->evaluador_id &&
        $solicitud->evaluador_id != $evaluadorAnterior
    ) {

        $evaluador = Usuario::find($solicitud->evaluador_id);

        if ($evaluador && !empty($evaluador->email)) {

            try {

                Mail::to($evaluador->email)->send(
                    new SolicitudAsignadaMail($solicitud)
                );

                \Log::info(
                    'Notificación de solicitud asignada enviada.',
                    [
                        'solicitud_id' => $solicitud->id,
                        'evaluador_id' => $evaluador->id,
                        'email' => $evaluador->email,
                    ]
                );

            } catch (\Exception $e) {

                \Log::error(
                    'Error al enviar notificación al evaluador: ' .
                    $e->getMessage(),
                    [
                        'solicitud_id' => $solicitud->id,
                        'evaluador_id' => $evaluador->id,
                    ]
                );
            }
        }
    }

    return redirect()
        ->route('evaluador.solicitudes.index')
        ->with(
            'success',
            'Estado y evaluador actualizados correctamente.'
        );
}



}
