@extends('layouts.empresad')

@section('contenido')

<style>
    .table-container {
        background: #ffffff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        width: 90%;
    }
    .table thead {
        background: #0d6efd;
        color: white;
    }
    .table td, .table th {
        padding: 8px 10px !important;
    }
    .badge {
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 8px;
    }
    .badge-pendiente { background: #ffc107; }
    .badge-evaluacion { background: #0dcaf0; }
    .badge-aprobado { background: #198754; color:white; }
    .badge-rechazado { background: #dc3545; color:white; }
</style>

<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Mis Solicitudes</h2>
        <!-- Botón para crear nueva solicitud (modal o redirección a formulario) -->
        <a href="{{ route('empresa.solicitudes.create') }}" class="btn btn-primary">
            <i class="fa fa-file-circle-plus"></i> Nueva Solicitud
        </a>
    </div>
     @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Productofg</th>
                        <th>Marca</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->marca }}</td>
                       <td>
                        
    {{ $item->solicitud->fecha_solicitud ?? 'Sin fecha' }}
</td>

<td>
    <span class="badge 
        @switch($item->solicitud->estado ?? null)
            @case('pendiente') badge-pendiente @break
            @case('en_revision') badge-evaluacion @break
            @case('aprobado') badge-aprobado @break
            @case('rechazado') badge-rechazado @break
        @endswitch
    ">
        {{ ucfirst($item->solicitud->estado ?? 'Sin estado') }}
    </span>
</td>
                        <td class="d-flex gap-1">
                            <!-- Botón Editar 
                            <button type="button"
                                class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarSolicitud"
                                data-id="{{ $item->id }}"
                                data-producto="{{ $item->producto_nombre }}"
                                data-marca="{{ $item->marca }}"
                                data-descripcion="{{ $item->descripcion }}"
                            >
                                ✏ Editar
                            </button>-->

                            <!-- Botón Eliminar -->
                            <form action="{{ route('empresa.solicitudes.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Editar Solicitud -->
<div class="modal fade" id="modalEditarSolicitud" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarLabel">Editar Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarSolicitud" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="producto_nombre" id="edit_producto" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" id="edit_marca" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control"></textarea>
                    </div>

                    <p class="text-muted">Los archivos solo se actualizan si subes uno nuevo.</p>

                    <div class="mb-3">
                        <label class="form-label">Diagrama</label>
                        <input type="file" name="diagrama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="imagen" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEditar = document.getElementById('modalEditarSolicitud');

    modalEditar.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;

        let id = button.getAttribute('data-id');
        let producto = button.getAttribute('data-producto');
        let marca = button.getAttribute('data-marca');
        let descripcion = button.getAttribute('data-descripcion');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_producto').value = producto;
        document.getElementById('edit_marca').value = marca;
        document.getElementById('edit_descripcion').value = descripcion;

        document.getElementById('formEditarSolicitud').action = `/empresa/solicitudes/${id}`;
    });
});
</script>
@endpush
