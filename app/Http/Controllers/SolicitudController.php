<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Solicitud;
use App\Notifications\ComentarioSolicitudNotification;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SolicitudController extends Controller
{
    /**
     * Mostrar solicitudes de la empresa autenticada
     */
  public function index()
{
    $empresaId = auth()->user()->empresa_id;

    if (!$empresaId) {
        return redirect()->back()->with('error', 'El usuario no tiene una empresa asignada.');
    }

    $productos = Producto::with('solicitud') // 👈 CLAVE
        ->where('empresa_id', $empresaId)
        ->orderBy('id', 'desc')
        ->get();

    return view('empresa.solicitudes.index', compact('productos'));
}

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('empresa.solicitudes.create');
    }

    /**
     * Guardar solicitud
     */
      public function store(Request $request)
{
    $request->validate([
        'producto_nombre' => [
            'required',
            'array',
            'min:1',
        ],

        'producto_nombre.*' => [
            'required',
            'string',
            'max:255',
            'distinct',
            Rule::unique('productos', 'nombre'),
        ],

        'marca' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',

        'diagrama' => 'required|file|mimes:pdf,jpg,png,jpeg|max:5120',

        'imagenes' => 'required|array|min:1',
'imagenes.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',

        'declaracion_jurada' => 'required|file|mimes:pdf|max:5120',

        'respaldos' => 'required|array|min:1',

        'respaldos.*' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',

        'tipo' => 'nullable|string|max:255',

    ], [

        'producto_nombre.*.distinct' =>
            '⚠️ No puedes repetir productos en la misma solicitud.',

        'producto_nombre.*.unique' =>
            '⚠️ Este producto ya está registrado en el sistema.',

        'diagrama.required' =>
            '⚠️ Debes adjuntar el diagrama.',

        'imagen.required' =>
            '⚠️ Debes adjuntar la imagen del producto.',

        'declaracion_jurada.required' =>
            '⚠️ Debes adjuntar la declaración jurada.',

        'respaldos.required' =>
            '⚠️ Debes adjuntar al menos un respaldo.',

    ]);


    DB::transaction(function () use ($request) {

        /*
        |--------------------------------------------------------------------------
        | 1. CREAR SOLICITUD
        |--------------------------------------------------------------------------
        */

        $solicitud = Solicitud::create([

            'empresa_id' => Auth::user()->empresa_id,

            'marca' => $request->marca,

            'descripcion' => $request->descripcion,

            'estado' => $this->determinarEstadoSolicitud($request->accion),

            'fecha_solicitud' => now()->toDateString(),

            'tipo' => $request->tipo,

        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. CREAR PRODUCTOS
        |--------------------------------------------------------------------------
        */

        foreach ($request->producto_nombre as $nombre) {

            Producto::create([

                'empresa_id' => Auth::user()->empresa_id,

                'solicitud_id' => $solicitud->id,

                'nombre' => $nombre,

                'marca' => $request->marca,

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 3. GUARDAR DIAGRAMA
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('diagrama')) {

            $file = $request->file('diagrama');

            $ruta = $file->store(
                'solicitudes/diagrama',
                'public'
            );

            Documento::create([

                'solicitud_id' => $solicitud->id,

                'nombre_original' =>
                    $file->getClientOriginalName(),

                'ruta' => $ruta,

                'tipo' => 'diagrama',

            ]);
        }


       // ==========================================
// IMÁGENES DE LOS PRODUCTOS
// UNA IMAGEN POR CADA PRODUCTO
// ==========================================

if ($request->hasFile('imagenes')) {

    foreach ($request->file('imagenes') as $index => $imagen) {

        $ruta = $imagen->store(
            'solicitudes/imagenes',
            'public'
        );

        Documento::create([
            'solicitud_id' => $solicitud->id,
            'nombre_original' => $imagen->getClientOriginalName(),
            'ruta' => $ruta,
            'tipo' => 'imagen',
        ]);
    }
}

        /*
        |--------------------------------------------------------------------------
        | 5. GUARDAR DECLARACIÓN JURADA
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('declaracion_jurada')) {

            $file = $request->file('declaracion_jurada');

            $ruta = $file->store(
                'solicitudes/declaraciones',
                'public'
            );

            Documento::create([

                'solicitud_id' => $solicitud->id,

                'nombre_original' =>
                    $file->getClientOriginalName(),

                'ruta' => $ruta,

                'tipo' => 'declaracion',

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 6. GUARDAR RESPALDOS
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('respaldos')) {

            foreach ($request->file('respaldos') as $file) {

                $ruta = $file->store(
                    'solicitudes/respaldos',
                    'public'
                );

                Documento::create([

                    'solicitud_id' => $solicitud->id,

                    'nombre_original' =>
                        $file->getClientOriginalName(),

                    'ruta' => $ruta,

                    'tipo' => 'respaldo',

                ]);
            }
        }

    });


    /*
    |--------------------------------------------------------------------------
    | 7. MENSAJE FINAL
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('empresa.solicitudes.index')
        ->with(
            'success',
            'Solicitud enviada correctamente.'
        );
}
    /**
     * Eliminar solicitud
     */
    public function destroy($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        // Solo permite borrar si pertenece a su empresa
        if ($solicitud->empresa_id !== Auth::user()->empresa_id) {
            abort(403, 'No autorizado');
        }

        $solicitud->delete();

        return redirect()->route('empresa.solicitudes.index')
            ->with('success', 'Solicitud eliminada correctamente');
    }



    public function generarCertificado($id)
{
    $sol = Solicitud::with(['empresa', 'producto'])->findOrFail($id);

    
    // Generar PDF con DomPDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificados.certificado', [
        'sol' => $sol,
    ]);

    return $pdf->stream("certificado_{$sol->id}.pdf");
}


public function vistaPrevia(Request $request)
{
    $solicitud = Solicitud::find($request->solicitud_id);

    return view('certificados.plantilla', [
        'solicitud' => $solicitud,
        'data' => $request->all()
    ]);
}

public function generar(Request $request)
{
    $solicitud = Solicitud::find($request->solicitud_id);

    $pdf = Pdf::loadView('certificados.plantilla', [
        'solicitud' => $solicitud,
        'data' => $request->all()
    ]);

    return $pdf->stream('certificado.pdf');
}


public function obtenerDatos($id)
{
    $solicitud = Solicitud::with('empresa')->findOrFail($id);

    return response()->json([
        'solicitud_id'   => $solicitud->id,
        'producto'       => $solicitud->producto ?? '',
        'razon_social'   => $solicitud->empresa->razon_social ?? '',
        'nit'            => $solicitud->empresa->nit ?? '',
        'rubro'          => $solicitud->empresa->rubro ?? '',
        'representante'  => $solicitud->empresa->representante ?? '',
        'direccion'      => $solicitud->empresa->direccion ?? '',
    ]);
    
}
   


public function enviarComentario(Request $request)
{
    $request->validate([
        'descripcion' => 'required|string',
        'solicitud_id' => 'required|exists:solicitudes,id'
    ]);

    // Buscar la solicitud con su empresa
    $solicitud = Solicitud::with('empresa.usuario')
        ->findOrFail($request->solicitud_id);

    // Enviar notificación a la empresa
   $solicitud->empresa->usuario->notify(
    new ComentarioSolicitudNotification(
        $request->descripcion,
        $solicitud->id
    )
);

    return back()->with('success', 'Comentario enviado y notificación enviada.');
}
}