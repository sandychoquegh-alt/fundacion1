<?php

namespace App\Http\Controllers\Evaluador;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Visita;
use App\Models\Evaluacion;

class DashboardController extends Controller
{
    public function index()
    {
        $usuarioId = auth()->id();

        // 📊 KPIs
        $totalSolicitudes = Solicitud::where('evaluador_id',$usuarioId)->count();

        $visitasProgramadas = Visita::where('evaluador_id',$usuarioId)
            ->where('estado','programada')
            ->count();

        $pendientes = Solicitud::where('evaluador_id',$usuarioId)
            ->where('estado','en_revision')
            ->count();

        $visitasAtrasadas = Visita::where('evaluador_id',$usuarioId)
            ->where('estado','programada')
            ->whereDate('fecha_visita','<',now())
            ->count();

        // 📅 Visitas de hoy
        $visitasHoy = Visita::with('solicitud.empresa')
            ->where('evaluador_id',$usuarioId)
            ->whereDate('fecha_visita',now())
            ->orderBy('hora','asc')
            ->get();

        // 🕒 Actividad reciente
        $ultimasVisitas = Visita::with('solicitud.empresa')
            ->where('evaluador_id',$usuarioId)
            ->latest()
            ->take(5)
            ->get();

        // 📊 Gráfico visitas por mes
        $visitasPorMes = DB::table('visitas')
            ->selectRaw('MONTH(fecha_visita) as mes, COUNT(*) as total')
            ->where('evaluador_id',$usuarioId)
            ->groupBy('mes')
            ->pluck('total','mes');

        // 📊 Solicitudes por estado
        $solicitudesEstado = [
            'pendiente' => Solicitud::where('evaluador_id',$usuarioId)->where('estado','en_revision')->count(),
            'aprobadas' => Solicitud::where('evaluador_id',$usuarioId)->where('estado','aprobado')->count(),
            'rechazadas' => Solicitud::where ('evaluador_id',$usuarioId)->where('estado','rechazado')->count(),
        ];

        return view('evaluador.dashboard', compact(
            'totalSolicitudes',
            'visitasProgramadas',
            'pendientes',
            'visitasAtrasadas',
            'visitasHoy',
            'ultimasVisitas',
            'visitasPorMes',
            'solicitudesEstado'
        ));
    }
}