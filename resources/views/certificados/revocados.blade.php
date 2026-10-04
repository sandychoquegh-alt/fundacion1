@extends('layouts.admin')

@section('contenido')

<div class="box box-warning">

<div class="box-header">
<h3 class="box-title">Certificados por vencer (45 días)</h3>
</div>

<div class="box-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>Código</th>
<th>Producto</th>

<th>Fecha Emisión</th>
<th>Fecha Vencimiento</th>
<th>Días restantes</th>
<th>Acción</th>
</tr>
</thead>

<tbody>

@foreach ($certificados as $c)

<tr>

<td>{{ $c->codigo }}</td>

<td>{{ $c->producto }}</td>



<td>{{ $c->fecha_emision }}</td>

<td>{{ $c->fecha_vencimiento }}</td>

<td>

@php
$dias = (int) \Carbon\Carbon::now()->diffInDays($c->fecha_vencimiento, false);
@endphp

@if($dias <= 10)
<span class="label label-danger">{{ $dias }} días</span>
@elseif($dias <= 30)
<span class="label label-warning">{{ $dias }} días</span>
@else
<span class="label label-info">{{ $dias }} días</span>
@endif

</td>

<td>

<a href="#" class="btn btn-primary btn-sm">
Renovar
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection