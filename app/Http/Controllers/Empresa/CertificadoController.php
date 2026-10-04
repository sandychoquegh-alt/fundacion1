<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use Illuminate\Support\Facades\Storage;

class CertificadoController extends Controller
{
    /**
     * Certificados pagados y disponibles
     */
    public function index()
    {
        $usuario = auth()->user();

        $empresa = $usuario->empresa;

        if (!$empresa) {
            abort(403, 'El usuario no tiene una empresa asignada.');
        }

        $certificados = Certificado::where('empresa_id', $empresa->id)
            ->where('estados', 'pagado')
            ->orderBy('fecha_emision', 'desc')
            ->get();

        return view('empresa.certificados.index', compact(
            'certificados',
            'empresa'
        ));
    }


    /**
     * Certificados pendientes de pago
     */
    public function pendientes()
    {
        $usuario = auth()->user();

        $empresa = $usuario->empresa;

        if (!$empresa) {
            abort(403, 'El usuario no tiene una empresa asignada.');
        }

        $certificados = Certificado::where('empresa_id', $empresa->id)
            ->where('estados', 'no_pagado')
            ->orderBy('fecha_emision', 'desc')
            ->get();

        return view('empresa.certificados.pendientes', compact(
            'certificados',
            'empresa'
        ));
    }


    /**
     * Detalle de certificado pagado
     */
    public function show($id)
    {
        $usuario = auth()->user();

        $empresa = $usuario->empresa;

        if (!$empresa) {
            abort(403, 'El usuario no tiene una empresa asignada.');
        }

        $certificado = Certificado::where('id', $id)
            ->where('empresa_id', $empresa->id)
            ->where('estados', 'pagado')
            ->firstOrFail();

        return view('empresa.certificados.show', compact(
            'certificado',
            'empresa'
        ));
    }


    /**
     * Visualizar PDF
     */
    public function ver($id)
    {
        $usuario = auth()->user();

        $empresa = $usuario->empresa;

        if (!$empresa) {
            abort(403, 'El usuario no tiene una empresa asignada.');
        }

        $certificado = Certificado::where('id', $id)
            ->where('empresa_id', $empresa->id)
            ->where('estados', 'pagado')
            ->firstOrFail();

        if (
            !$certificado->archivo_pdf ||
            !Storage::disk('public')->exists($certificado->archivo_pdf)
        ) {
            abort(404, 'El archivo del certificado no está disponible.');
        }

        return response()->file(
            Storage::disk('public')->path(
                $certificado->archivo_pdf
            )
        );
    }


    /**
     * Descargar PDF
     */
    public function descargar($id)
    {
        $usuario = auth()->user();

        $empresa = $usuario->empresa;

        if (!$empresa) {
            abort(403, 'El usuario no tiene una empresa asignada.');
        }

        $certificado = Certificado::where('id', $id)
            ->where('empresa_id', $empresa->id)
            ->where('estados', 'pagado')
            ->firstOrFail();

        if (
            !$certificado->archivo_pdf ||
            !Storage::disk('public')->exists($certificado->archivo_pdf)
        ) {
            abort(404, 'El archivo del certificado no está disponible.');
        }

        return Storage::disk('public')->download(
            $certificado->archivo_pdf,
            'Certificado_VAON_' .
            $certificado->codigo .
            '.pdf'
        );
    }
}