@extends('layouts.evaluador')

@section('content')



<div class="content mt-4">

<section class="content-header">
    <h1>
        Solicitudes Asignadas
        <small>Panel de Evaluación</small>
    </h1>
</section>

<section class="content">

<div class="box box-primary">

<div class="box-header with-border">
    <h3 class="box-title">
        Solicitudes en Revisión
    </h3>
</div>


<div class="box-body">
{{ $solicitudes->count() }}
<table class="table table-bordered table-hover">

<thead style="background:#f4f4f4">

<tr>

<th>Empresa</th>
<th>Marca</th>
<th>Fecha Solicitud</th>
<th>Estado</th>
<th width="120">Acción</th>
</tr>

</thead>

<tbody>

@forelse($solicitudes as $solicitud)

<tr>



<td>
{{ $solicitud->empresa->razon_social ?? 'Empresa no disponible' }}
</td>

<td>
{{ $solicitud->marca ?? 'Producto no disponible' }}
</td>

<td>
{{ $solicitud->created_at->format('d/m/Y') }}
</td>

<td>
<span class="label label-warning">
En revisión
</span>
</td>

<td>

<a href="{{ route('evaluador.solicitud.show',$solicitud->id) }}"
class="btn btn-primary btn-sm">

<i class="fa fa-search"></i>
 Revisar

</a>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center">
No existen solicitudes asignadas
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</section>

</div>

@endsection