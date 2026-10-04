<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificacionController extends Controller
{
    /**
     * FORMULARIO ANEXO A
     */
    public function formAnexoA()
{
    $empresa = Empresa::where('usuario_id', Auth::id())->first();

    return view('empresa.verificacion.anexoA', compact('empresa'));
}


    /**
     * GUARDAR ANEXO A
     */
   public function storeAnexoA(Request $request)
{
    $request->validate([
        'razon_social' => 'required',
        'nit' => 'required',
        'direccion' => 'required',
        'representante' => 'required',
        'cargo' => 'required',
        'persona_contacto' => 'required',
        'correo' => 'required|email',
        'telefono' => 'required',
        'celular' => 'nullable|string|max:30',
    ]);

    $empresa = Empresa::where('usuario_id', Auth::id())->first();

    if ($empresa) {
        $empresa->update([
    'direccion' => $request->direccion,
    'cargo' => $request->cargo,
    'persona_contacto' => $request->persona_contacto,
    'celular' => $request->celular,
]);

    }

    return redirect()->route('empresa.verificacion.show', $empresa->id)
        ->with('success', 'Datos del Anexo A completados correctamente.');
}


    /**
     * MOSTRAR INFORMACIÓN
     */
    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.verificacion.show', compact('empresa'));
    }

    /**
     * EDITAR
     */
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.verificacion.edit', compact('empresa'));
    }

    /**
     * ACTUALIZAR
     */
   

    /**
     * DESCARGAR PDF
     */
    public function downloadPDF($id)
    {
        $empresa = Empresa::findOrFail($id);

        $pdf = PDF::loadView('empresa.verificacion.pdf', compact('empresa'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download("AnexoA_{$empresa->id}.pdf");
    }
}
