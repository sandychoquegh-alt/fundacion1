@extends('layouts.admin')

@section('contenido')
<h2 class="text-2xl font-bold mb-4">Solicitudes Rechazadas</h2>

<div class="box">
    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $sol)
                <tr>
                    <td>{{ $sol->producto_nombre }}</td>
                    <td>{{ $sol->empresa->razon_social ?? 'Sin empresa' }}</td>
                    <td>{{ $sol->created_at->format('d/m/Y') }}</td>
                    <td><span class="label label-danger">Rechazada</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No hay solicitudes rechazadas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
