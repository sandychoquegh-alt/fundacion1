<?php

namespace App\Http\Controllers\Empresa;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Solicitud;

class SolicitudController extends Controller
{
public function pendientes()
{
    $productos = Solicitud::with('producto', 'empresa')
                    ->where('estado', 'Pendiente')
                    ->get();

    return view('empresa.solicitudes.pendientes', compact('productos'));
}

public function aprobadas()
{
    $productos = Solicitud::with('producto', 'empresa')
                    ->where('estado', 'Aprobado')
                    ->get();

    return view('empresa.solicitudes.aprobadas', compact('productos'));
}

// Rechazadas
public function rechazadas()
{
    $productos = Solicitud::with('producto', 'empresa')
                    ->where('estado', 'Rechazado')
                    ->get();

    return view('empresa.solicitudes.rechazadas', compact('productos'));
}

public function show($id)
{
    $solicitud = Solicitud::with('empresa','productos')->findOrFail($id);

    return view('empresa.solicitudes.show', compact('solicitud'));
}


}



