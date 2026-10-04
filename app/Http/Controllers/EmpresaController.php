<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ajusta roles si usas Spatie
    }

    /**
     * Vista principal de empresas
     */
   public function index()
{
    $empresas = Empresa::all(); // Trae todos los registros
    return view ('empresa.index', compact('empresas'));
}



    /**
     * API: Lista de empresas para AJAX / DataTables
     */
  public function store(Request $request)
{
    $data = $request->validate([
        'razon_social' => 'required|string|max:255',
        'nit' => 'required|string|max:50',
        'representante' => 'required|string|max:150',
        'telefono' => 'required|string|max:30',
        'email' => 'required|email|max:150',
        'direccion' => 'required|string',
        'estado' => 'required|string',
    ]);

    $data['usuario_id'] = auth()->id();

    Empresa::create($data);

    return redirect()->back()
        ->with('success', 'Empresa registrada correctamente.');
}

    

    /**
     * Crear empresa via AJAX
     */
      // Guardar nueva empresa


    /**
     * Obtener empresa para editar
     */
    public function show($id)
{
    $empresa = Empresa::findOrFail($id);
    return view('empresa.show', compact('empresa'));
}


    /**
     * Actualizar empresa via AJAX
     */
   // Actualizar empresa
public function update(Request $request, Empresa $empresa)
{
    $data = $request->validate([
        'razon_social' => 'required|string|max:255',
        'nit' => 'nullable|string|max:50',
        'representante' => 'nullable|string|max:150',
        
        'telefono' => 'nullable|string|max:30',
        'email' => 'nullable|email|max:150',
        'direccion' => 'nullable|string',
        'rubro' => 'nullable|string|max:100',
        'sector' => 'nullable|string|max:100',
        'fecha_registro' => 'nullable|date',
        'estado' => 'nullable|string',
    ]);

    $empresa->update($data);

    return redirect()->route('empresas.show', $empresa->id)
                     ->with('success', 'Empresa actualizada correctamente.');
}



    /**
     * Eliminación lógica (SoftDeletes)
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return response()->json(['message' => 'Empresa eliminada (lógica)']);
    }

    /**
     * Restaurar empresa eliminada
     */
    public function restore($id)
    {
        $empresa = Empresa::withTrashed()->findOrFail($id);
        $empresa->restore();

        return response()->json(['message' => 'Empresa restaurada']);
    }



}







