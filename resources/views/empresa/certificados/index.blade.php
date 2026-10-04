@extends('layouts.empresad')

@section('contenido')

<style>

    .certificados-page {
        padding: 25px;
    }

    .cert-header {
        background: linear-gradient(135deg, #0A1E3F, #162f5c);
        color: white;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,.12);
    }

    .cert-header h2 {
        margin: 0;
        font-weight: 700;
    }

    .cert-header p {
        margin: 7px 0 0;
        color: #dbe4f3;
    }

    .cert-header-icon {
        width: 58px;
        height: 58px;
        background: rgba(255,255,255,.12);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 15px;
    }

    .cert-card {
        background: #fff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        overflow: hidden;
        transition: all .25s ease;
        height: 100%;
    }

    .cert-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.12);
    }

    .cert-card-top {
        background: #f8fafc;
        padding: 20px;
        border-bottom: 1px solid #edf0f4;
    }

    .cert-icon {
        width: 48px;
        height: 48px;
        background: #0A1E3F;
        color: #D4AF37;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        float: left;
        margin-right: 14px;
    }

    .cert-code {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 3px;
    }

    .cert-product {
        font-size: 17px;
        font-weight: 700;
        color: #172033;
        margin: 0;
    }

    .cert-body {
        padding: 20px;
    }

    .cert-info {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .cert-info-icon {
        width: 34px;
        height: 34px;
        background: #f1f4f8;
        color: #0A1E3F;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .cert-info small {
        display: block;
        color: #7a8492;
        font-size: 11px;
    }

    .cert-info strong {
        color: #253044;
        font-size: 13px;
    }

    .badge-pago {
        background: #d1e7dd;
        color: #0f5132;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-valido {
        background: #d1e7dd;
        color: #0f5132;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-vencido {
        background: #f8d7da;
        color: #842029;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .btn-cert {
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        padding: 9px 13px;
    }

    .btn-cert-primary {
        background: #0A1E3F;
        color: white;
        border: none;
    }

    .btn-cert-primary:hover {
        background: #162f5c;
        color: white;
    }

    .btn-cert-download {
        background: #f5f6f8;
        color: #263238;
        border: 1px solid #e1e5ea;
    }

    .btn-cert-download:hover {
        background: #e9ecef;
        color: #0A1E3F;
    }

    .empty-cert {
        background: white;
        border-radius: 16px;
        padding: 60px 25px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
    }

    .empty-cert-icon {
        width: 80px;
        height: 80px;
        background: #f1f4f8;
        color: #0A1E3F;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
    }

    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }

</style>


<div class="container-fluid certificados-page">

    {{-- ENCABEZADO --}}
    <div class="cert-header">

        <div class="cert-header-icon">
            <i class="fa fa-shield"></i>
        </div>

        <h2>Mis Certificados</h2>

        <p>
            Consulta y administra los certificados VAON emitidos
            para tu empresa.
        </p>

    </div>


    {{-- MENSAJE --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>

    @endif


    {{-- CERTIFICADOS --}}
    @if($certificados->count() > 0)

        <div class="row">

            @foreach($certificados as $certificado)

                @php

                    $hoy = \Carbon\Carbon::today();

                    $vencimiento = \Carbon\Carbon::parse(
                        $certificado->fecha_vencimiento
                    );

                    $vigente = $vencimiento->gte($hoy);

                @endphp


                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                    <div class="cert-card">

                        {{-- PARTE SUPERIOR --}}
                        <div class="cert-card-top clearfix">

                            <div class="cert-icon">
                                <i class="fa fa-certificate"></i>
                            </div>

                            <div>
                                <div class="cert-code">
                                    CERTIFICADO VAON
                                </div>

                                <h4 class="cert-product">
                                    {{ $certificado->producto }}
                                </h4>
                            </div>

                        </div>


                        {{-- INFORMACIÓN --}}
                        <div class="cert-body">

                            <div class="d-flex justify-content-between mb-3">

                                <span class="badge-pago">
                                    <i class="fa fa-check-circle"></i>
                                    PAGADO
                                </span>


                                @if($vigente)

                                    <span class="badge-valido">
                                        VÁLIDO
                                    </span>

                                @else

                                    <span class="badge-vencido">
                                        VENCIDO
                                    </span>

                                @endif

                            </div>


                            {{-- CÓDIGO --}}
                            <div class="cert-info">

                                <div class="cert-info-icon">
                                    <i class="fa fa-hashtag"></i>
                                </div>

                                <div>
                                    <small>N.º de certificado</small>
                                    <strong>
                                        {{ $certificado->codigo }}
                                    </strong>
                                </div>

                            </div>


                            {{-- PORCENTAJE --}}
                            <div class="cert-info">

                                <div class="cert-info-icon">
                                    <i class="fa fa-percent"></i>
                                </div>

                                <div>
                                    <small>Porcentaje VAON</small>
                                    <strong>
                                        {{ $certificado->porcentaje_vaon }}%
                                    </strong>
                                </div>

                            </div>


                            {{-- FECHA EMISIÓN --}}
                            <div class="cert-info">

                                <div class="cert-info-icon">
                                    <i class="fa fa-calendar"></i>
                                </div>

                                <div>
                                    <small>Fecha de emisión</small>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
                                    </strong>
                                </div>

                            </div>


                            {{-- FECHA VENCIMIENTO --}}
                            <div class="cert-info">

                                <div class="cert-info-icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                                <div>
                                    <small>Fecha de vencimiento</small>
                                    <strong>
                                        {{ $vencimiento->format('d/m/Y') }}
                                    </strong>
                                </div>

                            </div>


                            <hr>


                            {{-- BOTONES --}}
                            <div class="d-flex gap-2">

                                <a href="{{ route(
                                    'empresa.certificados.show',
                                    $certificado->id
                                ) }}"
                                   class="btn btn-cert btn-cert-primary flex-fill">

                                    <i class="fa fa-eye"></i>
                                    Ver certificado

                                </a>


                                <a href="{{ route(
                                    'empresa.certificados.descargar',
                                    $certificado->id
                                ) }}"
                                   class="btn btn-cert btn-cert-download">

                                    <i class="fa fa-download"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- SIN CERTIFICADOS --}}
        <div class="empty-cert">

            <div class="empty-cert-icon">
                <i class="fa fa-shield"></i>
            </div>

            <h4>
                Aún no tienes certificados disponibles
            </h4>

            <p class="text-muted">
                Los certificados aparecerán aquí una vez que hayan
                sido generados y el pago correspondiente haya sido
                confirmado por la Fundación Hecho en Bolivia.
            </p>

        </div>

    @endif

</div>

@endsection