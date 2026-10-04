@extends('layouts.admin')

@section('contenido')

<div class="container mt-4">

    <div class="card shadow">
          <div class="card-header bg-dark text-white">
    <h4>
        <i class="fa fa-tasks me-2"></i>
        Evaluaciones Recibidas
    </h4>
</div>

        <div class="card-body">

            @if($evaluaciones->isEmpty())
                <div class="alert alert-info">
                    No hay evaluaciones enviadas aún
                </div>
            @else

            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Empresa</th>
                        <th>Producto</th>
                        <th>Evaluador</th>
                        <th>Resultado</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($evaluaciones as $evaluacion)
                    <tr>
                        <td>{{ $evaluacion->solicitud->empresa->razon_social }}</td>
                        <td>{{ $evaluacion->solicitud->marca }}</td>
                        <td>{{ $evaluacion->evaluador->name ?? 'N/A' }}</td>
                        <td>
                            @if($evaluacion->resultado == 'cumple')
                                <span class="badge bg-success">Cumple</span>
                            @else
                                <span class="badge bg-danger">No cumple</span>
                            @endif
                        </td>
                        <td>{{ $evaluacion->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.evaluaciones.ver', $evaluacion->id) }}" 
                               class="btn btn-primary btn-sm">
                               👁 Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            @endif

        </div>
    </div>

</div>
@endsection