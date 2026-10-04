<?php
#ESTO ES PARA EL O LA CARPETA DE SOLICITUD/INDEX Y SHOW esto ya es del EVALUADOR
namespace App\Http\Controllers\Evaluador;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Models\Evaluacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{

  


public function index()
{

$solicitudes = Solicitud::with('productos')
    ->where('evaluador_id', auth()->id())
    ->where('estado','en_revision')
    ->latest()
    ->get();

return view('evaluador.solicitud.index', compact('solicitudes'));

}
public function show($id)
{
    $solicitud = Solicitud::with([
        'empresa',
        'productos',
        'documentos',
        'evaluador'
    ])->findOrFail($id);

    return view('evaluador.solicitud.show', compact('solicitud'));
}


public function enviar(Request $request)
{
    $html = $request->contenido_modal;

    if (!$html) {
        return back()->with('error', 'El contenido del PDF está vacío');
    }

    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    $nombreArchivo = 'informe_' . time() . '.pdf';

    Storage::disk('public')->put('informes/' . $nombreArchivo, $pdf->output());
    

    Evaluacion::updateOrCreate(
        [
            'solicitud_id' => $request->solicitud_id,
            'evaluador_id' => auth()->id()
        ],
        [
            'informe' => 'informes/' . $nombreArchivo
        ]
    );

    return back()->with('success', 'PDF guardado correctamente');
}

/*este es para el modal de solicitud sow<!-- Modal Evaluación --> para el boton Realizar Evaluacion*/
public function guardar(Request $request, $id)
{
    $request->validate([
        'resultado' => 'required|in:cumple,no_cumple',
        'evidencia' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('evidencia')) {
        $rutaImagen = $request->file('evidencia')->store('evidencias', 'public');
        
    } else {
        return back()->with('error', 'No se subió la imagen');
    }

    Evaluacion::create([
        'evaluador_id' => auth()->id(),
        'solicitud_id' => $id,
        'resultado' => $request->resultado,
        'evidencia' => $rutaImagen
    ]);

    return back()->with('success', 'Evaluación guardada correctamente');
}
#este es el controlado para que el evaluador la vea del historial ver detalles
public function verDetalle($id)
{
    $evaluacion = Evaluacion::with('solicitud.empresa')
        ->findOrFail($id);

    return view('evaluador.detalle', compact('evaluacion'));
}

public function enviarAdmin($id)
{
    $evaluacion = Evaluacion::findOrFail($id);

    // 🟢 Marcar como enviado
    $evaluacion->estado = 'enviado';
    $evaluacion->save();

    return back()->with('success', 'Informe enviado al administrador');
}

}