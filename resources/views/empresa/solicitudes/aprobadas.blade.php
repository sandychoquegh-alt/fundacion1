@extends('layouts.admin')

@section('contenido')
<h2 class="text-2xl font-bold mb-4">Solicitudes Aprobadas</h2>

<div class="box">
    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                   
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $sol)
                <tr>
                    <td>{{ $sol->empresa->razon_social ?? 'Sin empresa' }}</td>
                    <td>{{ $sol->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-success">Aprobado</span>
                    </td>
                    <td>
    <a href="{{ route('empresa.solicitudes.show', $sol->id) }}" 
       class="btn btn-primary btn-sm">
        Ver
    </a>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay solicitudes aprobadas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



