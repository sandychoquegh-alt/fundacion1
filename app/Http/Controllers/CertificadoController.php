<?php



namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\CertificadoGeneradoMail;
use App\Mail\CertificadoPagadoMail;
use App\Models\Solicitud;
use App\Models\Certificado;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    /**
     * Generar certificado desde el formulario del modal
     */
    public function generar(Request $request)
    {
        // ✅ VALIDACIÓN
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'codigo' => 'required|string|max:50|unique:certificados,codigo',
            'producto' => 'required|string|max:255',
            'motivos_cert' => 'required|string',
            'porcentaje_vaon' => 'required|numeric|min:0|max:100',
            'lugar_fabricacion' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // ✅ EVITAR DUPLICADOS POR PRODUCTO
        if (Certificado::where('producto_id', $request->producto_id)->exists()) {

            return back()->with(
                'error',
                'Este producto ya tiene un certificado generado.'
            );
        }

        // ✅ CREAR CERTIFICADO
        $certificado = new Certificado();

        $certificado->producto_id = $request->producto_id;
        $certificado->empresa_id = $request->empresa_id;
        $certificado->codigo = $request->codigo;
        $certificado->producto = $request->producto;
        $certificado->motivos_cert = $request->motivos_cert;
        $certificado->porcentaje_vaon = $request->porcentaje_vaon;
        $certificado->lugar_fabricacion = $request->lugar_fabricacion;
        $certificado->fecha_emision = $request->fecha_emision;
        $certificado->fecha_vencimiento = $request->fecha_vencimiento;
        $certificado->descripcion = $request->descripcion;
        $certificado->estado = 'Activo';

        // ✅ IMAGEN
        if ($request->hasFile('imagen')) {

            $path = $request->file('imagen')
                            ->store('certificados', 'public');

            $certificado->imagen = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR CERTIFICADO
        |--------------------------------------------------------------------------
        */

        try {

            $certificado->save();

        } catch (\Illuminate\Database\QueryException $e) {

            return back()->with(
                'error',
                'Certificado duplicado detectado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'certificados.plantilla-pdf',
            [
                'certificado' => $certificado
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | NOMBRE Y RUTA DEL PDF
        |--------------------------------------------------------------------------
        */

        $nombreArchivo =
            'certificado_' .
            $certificado->codigo .
            '.pdf';

        $ruta =
            'certificados/' .
            $nombreArchivo;

        /*
        |--------------------------------------------------------------------------
        | GUARDAR PDF
        |--------------------------------------------------------------------------
        */

        Storage::disk('public')->put(
            $ruta,
            $pdf->output()
        );

        /*
        |--------------------------------------------------------------------------
        | GUARDAR RUTA DEL PDF EN BD
        |--------------------------------------------------------------------------
        */

        $certificado->archivo_pdf = $ruta;

        $certificado->save();

        /*
        |--------------------------------------------------------------------------
        | OBTENER EMPRESA
        |--------------------------------------------------------------------------
        */

        $certificado->load('empresa');

        $empresa = $certificado->empresa;

        /*
        |--------------------------------------------------------------------------
        | ENVIAR CERTIFICADO AL CORREO DE LA EMPRESA
        |--------------------------------------------------------------------------
        */

        if ($empresa && !empty($empresa->email)) {

            try {

                Mail::to($empresa->email)->send(
                    new CertificadoGeneradoMail(
                        $certificado,
                        $pdf->output()
                    )
                );

            } catch (\Exception $e) {

                // El certificado ya fue generado.
                // Si falla el correo, no se elimina el certificado.

                \Log::error(
                    'Error al enviar certificado por correo: ' .
                    $e->getMessage()
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MOSTRAR PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->stream(
            'certificado_' .
            $certificado->codigo .
            '.pdf'
        );
    }



public function verificar($codigo)
{
    $certificado = Certificado::where('codigo', $codigo)->first();

    if (!$certificado) {
        return view('certificados.verificar', [
            'verificar' => 'no-valido'
        ]);
    }

    if ($certificado->fecha_vencimiento < now()) {
        return view('certificados.verificar', [
            'verificar' => 'vencido',
            'certificado' => $certificado
        ]);
    }

    return view('certificados.verificar', [
        'verificar' => 'valido',
        'certificado' => $certificado
    ]);
}

public function verificarBuscar(Request $request)
{
    $codigo = $request->codigo;

    $certificado = Certificado::where('codigo', $codigo)
                              ->orWhere('id', $codigo)
                              ->first();

    if (!$certificado) {
        return view('certificados.verificar', [
            'resultado' => 'no_encontrado'
        ]);
    }

    return view('certificados.verificar', [
        'resultado' => 'encontrado',
        'certificado' => $certificado
    ]);
}

public function ver($id)
{
    $certificado = Certificado::find($id);

    if (!$certificado) {
        return abort(404, "Certificado no encontrado");
    }

    return view('certificados.ver', compact('certificado'));
}





 /** LISTA → Activos --------------------------------------- */
   public function activos()
    {
       $certificados = Certificado::where('estado', '!=', 'Revocado')
            ->where('fecha_vencimiento', '>=', now())
            ->get();

        return view('certificados.activos', compact('certificados'));
    }
       /** LISTA → Vencidos */
    public function vencidos()
    {
        $certificados = Certificado::where('estado', '!=', 'Revocado')
            ->where('fecha_vencimiento', '<', now())
            ->get();

        return view('certificados.vencidos', compact('certificados'));
    }

   /** LISTA → Revocados */
    public function revocados()
    {
        $certificados = Certificado::with('empresa')
        ->whereBetween('fecha_vencimiento', [
            Carbon::now(),
            Carbon::now()->addDays(45)
        ])
        ->orderBy('fecha_vencimiento','asc')
        ->get();
        return view('certificados.revocados', compact('certificados'));
    }
    /** DETALLE */
    public function show($id)
    {
        $certificado = Certificado::findOrFail($id);
        return view('certificados.show', compact('certificado'));
    }

    /** ACCIÓN: Revocar */
    public function revocar($id)
    {
        $cert = Certificado::findOrFail($id);
        $cert->estado = "Revocado";
        $cert->save();

        return back()->with('success', 'Certificado REVOCADO correctamente.');
    }

    /** ACCIÓN: Activar otra vez (solo si no está vencido) */
    public function activar($id)
    {
        $cert = Certificado::findOrFail($id);

        if ($cert->fecha_vencimiento < now()) {
            return back()->with('error', 'No se puede activar un certificado vencido.');
        }

        $cert->estado = "Activo";
        $cert->save();

        return back()->with('success', 'Certificado ACTIVADO nuevamente.');
    }



public function cambiarEstado(Request $request, $id)
{
    $request->validate([
        'estados' => 'required|in:pagado,no_pagado',
    ]);

    $certificado = Certificado::findOrFail($id);

    // Cambiar estado del pago
    $certificado->estados = $request->estados;
    $certificado->save();

    /*
    |--------------------------------------------------------------------------
    | SI EL CERTIFICADO FUE MARCADO COMO PAGADO
    |--------------------------------------------------------------------------
    */

    if ($request->estados === 'pagado') {

        // Obtener la empresa relacionada
        $certificado->load('empresa');

        $empresa = $certificado->empresa;

        // Verificar que la empresa tenga correo
        if ($empresa && !empty($empresa->email)) {

            try {

                // Enviar notificación por correo
                Mail::to($empresa->email)->send(
                    new CertificadoPagadoMail($certificado)
                );

            } catch (\Exception $e) {

                // Registrar el error sin deshacer el pago
                \Log::error(
                    'Error al enviar notificación de certificado pagado: ' .
                    $e->getMessage()
                );
            }
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'El certificado fue marcado como PAGADO y se notificó a la empresa.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SI EL CERTIFICADO FUE MARCADO COMO NO PAGADO
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->back()
        ->with(
            'success',
            'El certificado fue marcado como NO PAGADO.'
        );
}

    

}


