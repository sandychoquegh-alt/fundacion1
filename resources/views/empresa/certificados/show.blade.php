@extends('layouts.empresad')

@section('contenido')

<style>

    .detalle-page {
        padding: 25px;
    }

    .detalle-header {
        background: linear-gradient(135deg, #0A1E3F, #162f5c);
        color: white;
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 25px;
    }

    .detalle-header h2 {
        margin: 0;
        font-weight: 700;
    }

    .detalle-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 22px rgba(0,0,0,.08);
        border: none;
        overflow: hidden;
    }

    .detalle-card-header {
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #e9ecef;
    }

    .detalle-card-header h4 {
        margin: 0;
        color: #0A1E3F;
        font-weight: 700;
    }

    .detalle-body {
        padding: 30px;
    }

    .dato {
        padding: 15px 0;
        border-bottom: 1px solid #edf0f4;
    }

    .dato:last-child {
        border-bottom: none;
    }

    .dato-label {
        font-size: 12px;
        color: #7b8491;
        margin-bottom: 5px;
    }

    .dato-value {
        font-size: 15px;
        color: #202938;
        font-weight: 600;
    }

    .certificado-digital {
        background: linear-gradient(
            145deg,
            #f8fafc,
            #eef2f7
        );
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        height: 100%;
    }

    .escudo {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        background: #0A1E3F;
        color: #D4AF37;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 45px;
    }

    .codigo-grande {
        font-size: 20px;
        font-weight: 800;
        color: #0A1E3F;
        letter-spacing: 1px;
    }

    .estado-vigencia {
        display: inline-block;
        margin-top: 15px;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 700;
    }

    .estado-valido {
        background: #d1e7dd;
        color: #0f5132;
    }

    .estado-vencido {
        background: #f8d7da;
        color: #842029;
    }

    .btn-volver {
        border-radius: 9px;
    }

</style>


<div class="container-fluid detalle-page">


    {{-- ENCABEZADO --}}
    <div class="detalle-header">

        <h2>
            <i class="fa fa-certificate"></i>
            Detalle del certificado
        </h2>

        <p class="mb-0 mt-2">
            Información correspondiente a su Certificado VAON.
        </p>

    </div>


    {{-- BOTÓN VOLVER --}}
    <div class="mb-4">

        <a href="{{ route('empresa.certificados') }}"
           class="btn btn-secondary btn-volver">

            <i class="fa fa-arrow-left"></i>
            Volver a mis certificados

        </a>

    </div>


    <div class="row">


        {{-- INFORMACIÓN --}}
        <div class="col-lg-7 mb-4">

            <div class="detalle-card">

                <div class="detalle-card-header">

                    <h4>
                        <i class="fa fa-info-circle"></i>
                        Información del certificado
                    </h4>

                </div>


                <div class="detalle-body">


                    <div class="dato">

                        <div class="dato-label">
                            PRODUCTO
                        </div>

                        <div class="dato-value">
                            {{ $certificado->producto }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            NÚMERO DE CERTIFICADO
                        </div>

                        <div class="dato-value">
                            {{ $certificado->codigo }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            EMPRESA
                        </div>

                        <div class="dato-value">
                            {{ $empresa->razon_social }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            PORCENTAJE VAON
                        </div>

                        <div class="dato-value">
                            {{ $certificado->porcentaje_vaon }}%
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            LUGAR DE FABRICACIÓN
                        </div>

                        <div class="dato-value">
                            {{ $certificado->lugar_fabricacion }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            FECHA DE EMISIÓN
                        </div>

                        <div class="dato-value">
                            {{ \Carbon\Carbon::parse(
                                $certificado->fecha_emision
                            )->format('d/m/Y') }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            FECHA DE VENCIMIENTO
                        </div>

                        <div class="dato-value">
                            {{ \Carbon\Carbon::parse(
                                $certificado->fecha_vencimiento
                            )->format('d/m/Y') }}
                        </div>

                    </div>


                    <div class="dato">

                        <div class="dato-label">
                            ESTADO DE PAGO
                        </div>

                        <div class="dato-value text-success">

                            <i class="fa fa-check-circle"></i>
                            PAGADO

                        </div>

                    </div>


                </div>

            </div>

        </div>


        {{-- TARJETA DIGITAL --}}
        <div class="col-lg-5 mb-4">

            <div class="certificado-digital">

                <div class="escudo">

                    <i class="fa fa-shield"></i>

                </div>


                <h4>
                    Certificado VAON
                </h4>

                <p class="text-muted">
                    Certificación de Valor Agregado de Origen Nacional
                </p>


                <div class="codigo-grande">

                    {{ $certificado->codigo }}

                </div>


                @php

                    $hoy = \Carbon\Carbon::today();

                    $vencimiento = \Carbon\Carbon::parse(
                        $certificado->fecha_vencimiento
                    );

                    $vigente = $vencimiento->gte($hoy);

                @endphp


                @if($vigente)

                    <span class="estado-vigencia estado-valido">

                        <i class="fa fa-check-circle"></i>
                        CERTIFICADO VÁLIDO

                    </span>

                @else

                    <span class="estado-vigencia estado-vencido">

                        <i class="fa fa-times-circle"></i>
                        CERTIFICADO VENCIDO

                    </span>

                @endif


                <hr class="my-4">


                <div class="d-grid gap-2">

                    <a href="{{ route(
                        'empresa.certificados.descargar',
                        $certificado->id
                    ) }}"
                       class="btn btn-dark">

                        <i class="fa fa-download"></i>
                        Descargar certificado PDF

                    </a>


                    @if($certificado->archivo_pdf)

                        <a href="{{ asset(
                            'storage/' . $certificado->archivo_pdf
                        ) }}"
                           target="_blank"
                           class="btn btn-outline-primary">

                            <i class="fa fa-file-pdf-o"></i>
                            Visualizar PDF

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection