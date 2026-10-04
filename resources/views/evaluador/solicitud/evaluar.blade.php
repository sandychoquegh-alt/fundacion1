@extends('layouts.evaluador')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h4>Evaluación de Solicitud #{{ $solicitud->id }}</h4>
</div>

<div class="card-body">

<form action="{{ route('evaluaciones.store') }}" method="POST">

@csrf

<input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">

<h5>Verificación de Instalaciones</h5>

<select name="instalaciones" class="form-control">

<option value="cumple">Cumple</option>
<option value="no_cumple">No cumple</option>

</select>

<br>

<h5>Revisión Documental</h5>

<select name="documentacion" class="form-control">

<option value="completa">Documentación completa</option>
<option value="incompleta">Documentación incompleta</option>

</select>

<br>

<h5>Verificación del Origen de Insumos</h5>

<select name="origen_insumos" class="form-control">

<option value="verificado">Verificado</option>
<option value="no_verificado">No verificado</option>

</select>

<br>

<h5>Observaciones del Evaluador</h5>

<textarea name="observaciones" class="form-control" rows="5"></textarea>

<br>

<h5>Resultado Final</h5>

<select name="resultado" class="form-control">

<option value="cumple">Cumple requisitos VAON</option>
<option value="no_cumple">No cumple requisitos VAON</option>

</select>

<br>

<button class="btn btn-primary">

Guardar Evaluación

</button>

</form>

</div>

</div>

</div>

@endsection
