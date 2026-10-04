@extends('layouts.evaluador')

@section('content')


<style>

.filtro-box{
    background: #f8fafc;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.filtro-box label{
    display: block;
    margin-bottom: 8px;
    color: #1e3a8a; /* azul institucional */
    font-size: 14px;
}

.filtro-input,
.filtro-select{
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    transition: all 0.2s ease;
}

.filtro-input:focus,
.filtro-select:focus{
    border-color: #1e40af;
    box-shadow: 0 0 0 2px rgba(30,64,175,0.15);
}

.btn-buscar{
    background:#1e40af;
    border:none;
    border-radius:6px;
}

.btn-buscar:hover{
    background:#1e3a8a;
}

</style>
<div class="container-fluid py-4">

<!-- 🏛️ ENCABEZADO -->
<div class="mb-4">
    <h3 class="fw-bold text-primary">
        <i class="fa fa-folder-open me-2"></i>
        Historial de Evaluaciones dfvds
    </h3>
    <p class="text-muted">
        Registro institucional de evaluaciones realizadas
    </p>
</div>

<!-- 🔍 FILTROS -->
<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-light border-bottom">
    <strong><i class="fa fa-search me-2"></i>Filtros de búsqueda</strong>
</div>
<hr>
<div class="card-body">

<form method="GET" class="row mb-3 justify-content-center">
<div class="row justify-content-center mb-4 g-3">

    <!-- EMPRESA -->
    <div class="col-md-4">

        <div class="filtro-box">

            <label class="form-label fw-semibold">
                <i class="fa fa-building me-1"></i>
                Empresa
            </label>

            <input type="text" 
            name="buscar" 
            class="form-control filtro-input"
            placeholder="Ingrese nombre de empresa"
            value="{{ request('buscar') }}">

        </div>

    </div>

    <!-- RESULTADO -->
    <div class="col-md-3">

        <div class="filtro-box text-center">

            <label class="form-label fw-semibold">
                <i class="fa fa-filter me-1"></i>
                Resultado
            </label>

            <select name="resultado" class="form-select filtro-select">
                <option value="">Todos</option>
                <option value="cumple">✔ Cumple</option>
                <option value="no_cumple">✖ No cumple</option>
            </select>

        </div>

    </div>

    <!-- BOTÓN -->
    <div class="col-md-2 d-flex align-items-end">

        <button class="btn btn-primary w-100 btn-buscar">
            <i class="fa fa-search"></i> Buscar
        </button>

    </div>

</div>

</form>

</div>
</div>
<hr>
<!-- 📊 TABLA -->
<div class="card border-5 shadow-sm">

<div class="card-header bg-primary text-white">
    <i class="fa fa-table me-2"></i>
    Listado de Evaluaciones
</div>

<div class="card-body p-0">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr class="text-center">

<th>Empresazx</th>
<th>Producto</th>
<th class="p-3">Estado</th>
<th>Fecha Eval.</th>
<th>Resultado</th>
<th>Evidencias</th>
<th>info</th>
<th>Acciones</th>
</tr>

</thead>

<tbody>

@foreach($evaluaciones as $evaluacion)

<tr>

<td>
<i class="fa fa-building text-primary me-1"></i>
{{ $evaluacion->solicitud->empresa->razon_social }}
</td>

<td>
<i class="fa fa-box text-secondary me-1"></i>
{{ $evaluacion->solicitud->marca }}
</td>
<td class="text-center">
  @if($evaluacion->estado == 'enviado')
        <span class="badge bg-primary">Enviado</span>
    @else
        <span class="badge bg-warning">Pendiente</span>
    @endif
</td>
<td class="text-center">
    <i class="fa fa-calendar-alt text-muted me-1"></i>
{{ $evaluacion->created_at->format('d/m/Y') }}

</td>

<td class="text-center">

@if($evaluacion->resultado == 'cumple')
<span class="badge bg-success px-3 py-2">
✔ Cumple
</span>
@else
<span class="badge bg-danger px-3 py-2">
✖ No cumple
</span>
@endif

</td>
<td class="text-center">
   
    @if($evaluacion->evidencia)
        <img src="{{ asset('storage/' . $evaluacion->evidencia) }}" width="60">
    @endif
</td>

<td class="text-center">
    {{ $evaluacion->informe }}

</td>

<td class="text-center">
   <a href="{{ route('evaluador.ver.detalle', $evaluacion->id) }}" 
   class="btn btn-info btn-sm">
   👁 Ver
</a>
</td>


</tr>

@endforeach

</tbody>

</table>

</div>

</div>

<!-- 📄 PAGINACIÓN -->
<div class="mt-3 d-flex justify-content-center">
{{ $evaluaciones->links() }}
</div>

</div>

@endsection