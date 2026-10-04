@extends('layouts.admin')

@section('contenido')
<h2>Certificados Vencidos</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Empresa</th>
            <th>Fecha Vencimiento</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($certificados as $c)
        <tr>
            <td>{{ $c->codigo }}</td>
            <td>{{ $c->producto }}</td>
            <td>{{ $c->empresa_id }}</td>
            <td>{{ $c->fecha_vencimiento }}</td>
            <td>
                <span class="badge bg-danger">Vencido</span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
