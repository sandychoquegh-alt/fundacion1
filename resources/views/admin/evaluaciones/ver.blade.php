@extends('layouts.admin')

@section('contenido')
<!-- esto es para las alertas ´para que se muestren-->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="fa fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <i class="fa fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-dark text-white">
            <h4>
                <i class="fa fa-user-shield me-2"></i>
                Panel Administrador - Detalle de Evaluación
            </h4>
        </div>

        <div class="card-body">

            <!-- INFO GENERAL -->
            <div class="row mb-4">

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <h6 class="text-muted">Empresa</h6>
                        <strong>{{ $evaluacion->solicitud->empresa->razon_social }}</strong>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <h6 class="text-muted">Producto</h6>
                        <strong>{{ $evaluacion->solicitud->marca }}</strong>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <h6 class="text-muted">Evaluador</h6>
                        <strong>{{ $evaluacion->evaluador->name ?? 'N/A' }}</strong>
                    </div>
                </div>

            </div>
            <br>
            <!-- RESULTADO -->
            <div class=" mb-4">
                <h5>Resultado</h5>

                @if($evaluacion->resultado == 'cumple')
                    <span class="badge bg-success fs-5 px-4 py-2">
                        ✔ Cumple requisitos
                    </span>
                @else
                    <span class="badge bg-danger fs-5 px-4 py-2">
                        ✖ No cumple requisitos
                    </span>
                @endif
            </div>

            <hr>

            <!-- EVIDENCIA -->
            <div class="mb-4">
                <h5>
                    <i class="fa fa-image text-primary"></i> Evidencia
                </h5>

                @if($evaluacion->evidencia)
                    <div class="">
                        <img src="{{ asset('storage/' . $evaluacion->evidencia) }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 300px;">
                    </div>
                @else
                    <div class="alert alert-warning">
                        No hay evidencia
                    </div>
                @endif
            </div>

            <hr>

            <!-- PDF -->
            <div class="mb-4">
                <h5>
                    <i class="fa fa-file-pdf text-danger"></i> Informe PDF
                </h5>

                @if($evaluacion->informe)

                    <div class="mb-2 text-end">
                        <a href="{{ asset('storage/' . $evaluacion->informe) }}" 
                           target="_blank" 
                           class="btn btn-danger btn-sm">
                           📄 Abrir PDF
                        </a>
                    </div>

                    <iframe src="{{ asset('storage/' . $evaluacion->informe) }}" 
                            class="w-100 border rounded shadow"
                            style="height: 500px;">
                    </iframe>

                @else
                    <div class="alert alert-secondary">
                        No hay informe
                    </div>
                @endif
            </div>

            <hr>

            <!-- ACCIONES ADMIN -->
            <div class="text-center">

                <form action="{{ route('admin.evaluaciones.aprobar', $evaluacion->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success px-4">
                        ✔ Aprobar
                    </button>
                </form>

                <form action="{{ route('admin.evaluaciones.rechazar', $evaluacion->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger px-4">
                        ✖ Rechazar
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection