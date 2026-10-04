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
        height: 100%;
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

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .alert-pago {
        background: #fff8e1;
        border: 1px solid #ffe69c;
        color: #664d03;
        border-radius: 10px;
        padding: 12px;
        font-size: 12px;
        line-height: 1.5;
    }

    .btn-cert {
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        padding: 9px 13px;
    }

    .btn-disabled-cert {
        background: #e9ecef;
        color: #6c757d;
        border: none;
        cursor: not-allowed;
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


<div class="cert-header">

    <div class="cert-header-icon">
        <i class="fa fa-clock-o"></i>
    </div>

    <h2>Certificados pendientes de pago</h2>

    <p>
        Certificados que han sido generados y se encuentran
        pendientes de confirmación de pago.
    </p>

</div>


@if($certificados->count() > 0)

    <div class="row">

        @foreach($certificados as $certificado)

            @php
                $vencimiento = \Carbon\Carbon::parse(
                    $certificado->fecha_vencimiento
                );
            @endphp

            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                <div class="cert-card">

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


                    <div class="cert-body">

                        <div class="mb-3">

                            <span class="badge-pendiente">
                                <i class="fa fa-clock-o"></i>
                                PAGO PENDIENTE
                            </span>

                        </div>


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


                        <div class="cert-info">

                            <div class="cert-info-icon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <div>

                                <small>Fecha de emisión</small>

                                <strong>
                                    {{ \Carbon\Carbon::parse(
                                        $certificado->fecha_emision
                                    )->format('d/m/Y') }}
                                </strong>

                            </div>

                        </div>


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


                        <div class="alert-pago">

                            <i class="fa fa-info-circle"></i>

                            El certificado ha sido generado, pero
                            todavía se encuentra pendiente de pago.

                            Para obtener acceso al certificado,
                            debe realizar el pago correspondiente
                            en la Fundación Hecho en Bolivia.

                        </div>


                        <hr>


                        <div class="text-center">

                            <button type="button"
                                    class="btn btn-cert btn-disabled-cert w-100"
                                    disabled>

                                <i class="fa fa-lock"></i>

                                Certificado no disponible

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="empty-cert">

        <div class="empty-cert-icon">
            <i class="fa fa-check-circle"></i>
        </div>

        <h4>
            No tienes certificados pendientes de pago
        </h4>

        <p class="text-muted">
            Actualmente no existen certificados generados
            pendientes de confirmación de pago.
        </p>

        <a href="{{ route('empresad.certificados') }}"
           class="btn btn-dark mt-3">

            <i class="fa fa-certificate"></i>
            Ver certificados activos

        </a>

    </div>

@endif


</div>

@endsection
