@extends('layouts.evaluador')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        
        <!-- HEADER -->
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">
                <i class="fa fa-file-alt me-2"></i> Detalle de Evaluación
            </h4>
        </div>

        <div class="card-body">

            <!-- DATOS GENERALES -->
            <div class="row mb-4">

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light">
                        <h6 class="text-muted">Empresa</h6>
                        <h5 class="fw-bold">
                            {{ $evaluacion->solicitud->empresa->razon_social }}
                        </h5>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light">
                        <h6 class="text-muted">Producto</h6>
                        <h5 class="fw-bold">
                            {{ $evaluacion->solicitud->marca }}
                        </h5>
                    </div>
                </div>

            </div>

            <!-- RESULTADO -->
            <div class="mb-4 ">
                <h5 class="mb-2">Resultado de Evaluación</h5>

                @if($evaluacion->resultado == 'cumple')
                    <span class="badge bg-success px-4 py-2 fs-6 shadow">
                        ✔ Cumple requisitos
                    </span>
                @else
                    <span class="badge bg-danger px-4 py-2 fs-6 shadow">
                        ✖ No cumple requisitos
                    </span>
                @endif
            </div>

            <hr>

            <!-- EVIDENCIA -->
            <div class="mb-4">
                <h5 class="mb-3">
                    <i class="fa fa-image text-primary me-2"></i> Evidencia
                </h5>

                @if($evaluacion->evidencia)
                    <div class="">   <!-- text-center-->
                        <img src="{{ asset('storage/' . $evaluacion->evidencia) }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 300px;">
                    </div>
                @else
                    <div class="alert alert-warning">
                        No hay imagen de evidencia
                    </div>
                @endif
            </div>

            <hr>

            <!-- PDF -->
            <div class="mb-4">
                <h5 class="mb-3">
                    <i class="fa fa-file-pdf text-danger me-2"></i> Informe PDF
                </h5>

                @if($evaluacion->informe)

                    <div class="mb-3 text-end">
                        <a href="{{ asset('storage/' . $evaluacion->informe) }}" 
                           target="_blank" 
                           class="btn btn-danger btn-sm shadow">
                           📄 Abrir en nueva pestaña
                        </a>
                    </div>

                    <iframe src="{{ asset('storage/' . $evaluacion->informe) }}" 
                            class="w-100 border rounded shadow"
                            style="height: 600px ;">
                             
                    </iframe>

                @else
                    <div class="alert alert-secondary">
                        No hay informe disponible
                    </div>
                @endif
            </div>

            <hr>

            <!-- BOTÓN -->
            <div class="text-center">

                @if($evaluacion->estado != 'enviado')
                    <form action="{{ route('evaluador.enviar.admin', $evaluacion->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                            📤 Enviar al Administrador
                        </button>
                    </form>
                @else
                    <button class="btn btn-success px-5 py-2 shadow" disabled>
                        ✔ Informe Enviado
                    </button>
                @endif

            </div>

        </div>
    </div>

</div>


@endsection