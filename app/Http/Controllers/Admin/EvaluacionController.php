<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Solicitud;
use App\Models\Sello;
use App\Models\Certificado;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{

public function index()
{
    $evaluaciones = Evaluacion::with('solicitud.empresa', 'evaluador')
        ->where('estado', 'enviado') // 🔥 FILTRO CLAVE
        ->latest()
        ->get();

    return view('admin.evaluaciones.index', compact('evaluaciones'));
}
public function ver($id)
{
    $evaluacion = Evaluacion::with('solicitud.empresa', 'evaluador')
        ->findOrFail($id);

    return view('admin.evaluaciones.ver', compact('evaluacion'));
}

public function aprobar($id)
{
    $evaluacion = Evaluacion::findOrFail($id);
    $evaluacion->estado = 'aprobado';
    $evaluacion->save();

    return back()->with('success', 'Evaluación aprobada');
}

public function rechazar($id)
{
    $evaluacion = Evaluacion::findOrFail($id);
    $evaluacion->estado = 'rechazado';
    $evaluacion->save();

    return back()->with('error', 'Evaluación rechazada');
}
}