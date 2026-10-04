<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AnexoBController extends Controller
{
    // Mostrar formulario
    public function cartaForm()
    {
        return view('empresa.anexoB.carta');
    }

    // Guardar y generar PDF
    public function cartaStore(Request $request)
    {
        $request->validate([
            'razon_social' => 'required',
            'nit' => 'required',
            'direccion' => 'required',
            'representante' => 'required',
            'cargo' => 'required',
            'productos' => 'required',
        ]);

        $pdf = Pdf::loadView('empresa.anexoB.carta_pdf', $request->all())
                  ->setPaper('A4', 'portrait');

        return $pdf->download("Carta_AnexoB.pdf");
    }


    public function vaonForm()
{
    return view('empresa.anexoB.carta');
}

public function vaonStore(Request $request)
{
    $request->validate([
        'producto' => 'required',
        'marca' => 'required',
        'mano_obra' => 'required|numeric',
        'materia_prima' => 'required|numeric',
        'insumos' => 'required|numeric',
    ]);

    $total = $request->mano_obra + $request->materia_prima + $request->insumos;

    \DB::table('vaon_declaraciones')->insert([
        'empresa_id' => auth()->id(),
        'producto' => $request->producto,
        'marca' => $request->marca,
        'mano_obra' => $request->mano_obra,
        'materia_prima' => $request->materia_prima,
        'insumos' => $request->insumos,
        'total_vaon' => $total,
        'created_at' => now()
    ]);

    return back()->with('success', 'Declaración VAON guardada correctamente.');
}


    public function generarPdf(Request $request)
    {
        // Validación mínima (SIN guardar en BD)
        $request->validate([
            'representante' => 'required|string',
            'ci' => 'required|string',
            'empresa' => 'required|string',
            'nit' => 'required|string',
        ]);

        // Recibe todos los datos en un solo array
        $data = $request->all();

        // Carga la vista PDF desde empresa/anexoB
        $pdf = Pdf::loadView('empresa.anexoB.anexoB-pdf', [
            'data' => $data
        ])->setPaper('letter');

        return $pdf->download('ANEXO_B_'.$data['empresa'].'.pdf');
    }

}
