<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Solicitud;
use App\Models\Sello;
use App\Models\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {

        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

        $anioActual = Carbon::now()->year;

$datos = Solicitud::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', $anioActual)
        ->groupBy('mes')
        ->orderBy('mes')
        ->pluck('total', 'mes')
        ->toArray();

        $cantidadPorMes = [];

         // CERTIFICADOS POR VENCER (45 días)
        $certificadosPorVencer = Certificado::whereBetween(
            'fecha_vencimiento',
            [Carbon::now(), Carbon::now()->addDays(45)]
        )->count();

        // Solicitudes recibidas
$solicitudesRecibidas = Solicitud::count();

// Certificados activos
$certificadosActivos = Certificado::where('fecha_vencimiento', '>=', Carbon::today())
    ->count();

// Certificados vencidos
$certificadosVencidos = Certificado::where('fecha_vencimiento', '<', Carbon::today())
    ->count();


        for($i=1; $i<=12; $i++){
            $cantidadPorMes[] = $datos[$i] ?? 0;
        }

        return view('empresa.dashboard', [

            'totalEmpresas'        => Empresa::count(),
            'solicitudesPendientes'=> Solicitud::where('estado','Pendiente')->count(),
            'ultimasSolicitudes'   => Solicitud::orderBy('id','desc')->limit(5)->get(),

            'meses' => $meses,
            'cantidadPorMes' => $cantidadPorMes,
            // NUEVA VARIABLE
            'certificadosPorVencer' => $certificadosPorVencer,
            'certificadosPorVencer' => $certificadosPorVencer,
    'solicitudesRecibidas'  => $solicitudesRecibidas,
    'certificadosActivos'   => $certificadosActivos,
    'certificadosVencidos'  => $certificadosVencidos,
           
        ]);

        
    }
}
