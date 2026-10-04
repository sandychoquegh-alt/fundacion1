<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Evaluacion;
use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
{
    $empresaId = Auth::user()->empresa_id;

    // 📄 Solicitudes enviadas
    $solicitudes = Solicitud::where('empresa_id', $empresaId)->count();

    // ✅ Certificados aprobados
    $certificados = Evaluacion::where('empresa_id', $empresaId)
        ->where('estado', 'Activo')
        ->count();

    // 🔍 En revisión
    $enRevision = Solicitud::where('empresa_id', $empresaId)
        ->where('estado', 'en_revision')
        ->count();

// ⏰ Certificados por vencer (dentro de 45 días)
    $vencenPronto = Certificado::where('empresa_id', $empresaId)
        ->whereDate('fecha_vencimiento', '>=', Carbon::now()) // aún no vencidos
        ->whereDate('fecha_vencimiento', '<=', Carbon::now()->addDays(45)) // dentro de 45 días
        ->count();

    return view('empresad.dashboard', compact(
        'solicitudes',
        'certificados',
        'enRevision',
        'vencenPronto'
    ));
}
    public function manual()
{
    return view('solicitudes.manual');
}
}