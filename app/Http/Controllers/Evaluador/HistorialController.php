<?php

namespace App\Http\Controllers\Evaluador;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Models\Evaluacion;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $query = Solicitud::query()->with('empresa');

        // Filtros
        if ($request->search) {
            $query->where('codigo', 'like', "%{$request->search}%")
                  ->orWhereHas('empresa', function($q) use ($request) {
                      $q->where('razon_social', 'like', "%{$request->search}%");
                  });
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->desde) {
            $query->whereDate('fecha_evaluacion', '>=', $request->desde);
        }

        if ($request->hasta) {
            $query->whereDate('fecha_evaluacion', '<=', $request->hasta);
        }

        $evaluaciones = $query->orderBy('fecha_evaluacion', 'desc')->paginate(10);

        return view('evaluador.historial', compact('evaluaciones'));
    }

    public function historial(Request $request)
{
    $query = Evaluacion::with('empresa');

    // FILTRO: búsqueda
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('codigo', 'LIKE', '%' . $request->search . '%')
              ->orWhereHas('empresa', function ($e) use ($request) {
                  $e->where('razon_social', 'LIKE', '%' . $request->search . '%');
              });
        });
    }

    // FILTRO: estado
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // FILTRO: fechas
    if ($request->filled('desde')) {
        $query->whereDate('fecha_evaluacion', '>=', $request->desde);
    }

    if ($request->filled('hasta')) {
        $query->whereDate('fecha_evaluacion', '<=', $request->hasta);
    }

    $evaluaciones = $query->paginate(10);

    return view('evaluador.historial', compact('evaluaciones'));
}

}
