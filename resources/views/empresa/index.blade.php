@extends ('layouts.admin')
@section ('contenido')

<h4>Gestión de Empresas</h4>

{{-- Botón para abrir modal --}}
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#empresaModal">
    Nueva Empresa
</button>
<br><hr>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

{{-- Tabla de empresas --}}
<table class="table table-bordered table-striped" id="empresasTable">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>NIT</th>
            <th>Representante</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Rubro</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
    <tbody>
@foreach ($empresas as $empresa)
<tr>
    <td>{{ $empresa->razon_social }}</td>
    <td>{{ $empresa->nit }}</td>
    <td>{{ $empresa->representante }}</td>
    <td>{{ $empresa->email }}</td>
    <td>{{ $empresa->telefono }}</td>
    <td>{{ $empresa->rubro }}</td>
    <td>{{ $empresa->estado }}</td>
    <td>
      <!-- Botón Editar -->
     <a href="{{ route('empresas.show',$empresa) }}" class="btn btn-info btn-sm">Ver</a>
     <!-- Botón Editar -->
    <!-- <button class="btn btn-warning btn-sm editBtn" data-id="{{ $empresa->id }}">Editar</button>-->
       
       <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta empresa?')">Eliminar</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>



{{-- Aquí incluimos el modal --}}
@include('empresa.modal')

@stop


@section('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable una sola vez
    $('#empresasTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });

    console.log("✅ DataTable inicializado correctamente");
});
</script>
@endpush
@stop