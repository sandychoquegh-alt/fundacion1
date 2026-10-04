<?php

namespace App\Http\Controllers\Evaluador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\VisitaService;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitaProgramadaMail;
use App\Models\Empresa;

use App\Models\Visita;
use App\Models\Producto;
use App\Models\Solicitud;
use Carbon\Canbon;
#ESTO SE ESTA USANDO PARA LA PARTE
class VisitaController extends Controller
{

    protected $visitaService;

    public function __construct(VisitaService $visitaService)
    {
        $this->visitaService = $visitaService;
    }


     public function index()
    {
        $solicitudes = Solicitud::with(['empresa','producto'])
    ->where('evaluador_id',auth()->id())
    ->where('estado','en_revision')
     ->latest()
       ->whereDoesntHave('visitas', function($query){
        $query->whereIn('estado', ['programada','reprogramada','realizada']);
    })
    ->get();

      $visitas = Visita::with(['empresa','solicitud'])
    ->where('evaluador_id', auth()->id())
    ->orderBy('fecha_visita','asc')
    ->get();

     return view('evaluador.agenda.index', compact('solicitudes','visitas'));

    } 



// Almacenar una nueva visita
public function store(Request $request)
{
    $request->validate([
        'solicitud_id' => 'required|exists:solicitudes,id',
        'fecha_visita' => 'required|date',
        'hora'         => 'required|date_format:H:i|after:07:59|before:18:01'
    ]);

    // 🚫 Verificar conflicto de horario del evaluador
    $conflictoHora = Visita::where('evaluador_id', auth()->id())
        ->where('fecha_visita', $request->fecha_visita)
        ->where('hora', $request->hora)
        ->exists();

    if ($conflictoHora) {
        return redirect()
            ->route('evaluador.agenda')
            ->with('error', '⚠️ Ya tienes una visita en esa hora');
    }

    // 🚫 Verificar si la solicitud ya tiene una visita programada
    $existe = Visita::where('solicitud_id', $request->solicitud_id)
        ->where('estado', 'programada')
        ->exists();

    if ($existe) {
        return redirect()
            ->route('evaluador.agenda')
            ->with('error', '⚠️ Esta solicitud ya tiene una visita programada');
    }

    // Obtener solicitud
    $solicitud = Solicitud::findOrFail($request->solicitud_id);

    // 💾 Guardar visita
    $visita = Visita::create([
        'empresa_id'     => $solicitud->empresa_id,
        'solicitud_id'   => $solicitud->id,
        'evaluador_id'   => auth()->id(),
        'fecha_visita'   => $request->fecha_visita,
        'hora'           => $request->hora,
        'estado'         => 'Programada',
        'observaciones'  => $request->observaciones
    ]);

    /*
    |--------------------------------------------------------------------------
    | 📧 NOTIFICAR A LA EMPRESA
    |--------------------------------------------------------------------------
    */

    $empresa = Empresa::find($solicitud->empresa_id);

    if ($empresa && !empty($empresa->email)) {

        try {

            Mail::to($empresa->email)->send(
                new VisitaProgramadaMail($visita)
            );

            \Log::info(
                'Notificación de visita enviada a la empresa.',
                [
                    'visita_id' => $visita->id,
                    'empresa_id' => $empresa->id,
                    'email' => $empresa->email,
                ]
            );

        } catch (\Exception $e) {

            // La visita ya fue registrada.
            // Si falla el correo, no eliminamos la visita.

            \Log::error(
                'Error al enviar notificación de visita: ' .
                $e->getMessage(),
                [
                    'visita_id' => $visita->id,
                    'empresa_id' => $empresa->id,
                ]
            );
        }
    }

    return redirect()
        ->route('evaluador.agenda')
        ->with('success', 'Visita programada correctamente');
}






//  Visitas esto es para la vista de VER VISITAS PROGRAMADAS
public function visitas(Request $request)
{
    $query = Visita::with(['solicitud.empresa','solicitud.producto'])
        ->where('evaluador_id', auth()->id());

    // 🔍 filtro empresa
    if($request->empresa){
        $query->whereHas('solicitud.empresa', function($q) use ($request){
            $q->where('razon_social','like','%'.$request->empresa.'%');
        });
    }

    // 🔍 filtro producto
    if($request->producto){
        $query->whereHas('solicitud', function($q) use ($request){
            $q->where('marca','like','%'.$request->producto.'%');
        });
    }

    // 🔍 estado
    if($request->estado){
        $query->where('estado', $request->estado);
    }

    // 📅 rango fechas
    if($request->desde){
        $query->whereDate('fecha_visita','>=',$request->desde);
    }

    if($request->hasta){
        $query->whereDate('fecha_visita','<=',$request->hasta);
    }

    $visitas = $query->orderBy('fecha_visita','desc')->paginate(10);

    return view('evaluador.visitas.index', compact('visitas'));
}




    public function json()
    {
        $visitas = Visita::where('evaluador_id', auth()->id())->get();

        $eventos = [];

        foreach ($visitas as $visita) {
            $eventos[] = [
                'id' => $visita->id,
                'title' => $visita->empresa->razon_social,
                'start' => $visita->fecha.' '.$visita->hora,
            ];
        }

        return response()->json($eventos);
    }




    public function show($id)
    {
        $visita = Visita::findOrFail($id);
        return view('evaluador.agenda.show', compact('visita'));
    }



public function reprogramar(Request $request, $id)
{
    $request->validate([
        'fecha_visita' => 'required|date',
        'hora' => 'required' // 👈 importante para validar duplicados
    ]);

    $visita = Visita::findOrFail($id);

    // 🔴 VALIDAR SI YA EXISTE UNA VISITA EN ESA FECHA Y HORA
    $existe = Visita::where('evaluador_id', $visita->evaluador_id)
        ->where('fecha_visita', $request->fecha_visita)
        ->where('hora', $request->hora)
        ->where('id', '!=', $id) // 👈 excluir la misma visita
        ->exists();

    if ($existe) {
        return back()->with('error', 'Ya tienes una visita programada en esa fecha y hora');
    }

    // ✅ REPROGRAMAR
    $visita->fecha_visita = $request->fecha_visita;
    $visita->hora = $request->hora;

    // 🔵 CAMBIAR ESTADO AUTOMÁTICAMENTE
    $visita->estado = 'Reprogramada';

    $visita->save();

    return back()->with('success', 'Reprogramado correctamente');
}
}