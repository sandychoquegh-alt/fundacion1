@extends('layouts.admin')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Detalles de la Empresa</h2>

    <a href="{{ route('empresas.index') }}" class="btn btn-secondary mb-3">← Volver</a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Razón Social</th>
                    <td>{{ $empresa->razon_social }}</td>
                </tr>
                <tr>
                    <th>NIT</th>
                    <td>{{ $empresa->nit }}</td>
                </tr>
                <tr>
                    <th>Nombre del Representante</th>
                    <td>{{ $empresa->representante }}</td>
                </tr>
                
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $empresa->telefono }}</td>
                </tr>
                <tr>
                    <th>Correo Electronico</th>
                    <td>{{ $empresa->email }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $empresa->direccion }}</td>
                </tr>
                <tr>
                    <th>Rubro</th>
                    <td>{{ $empresa->rubro }}</td>
                </tr>
                <tr>
                    <th>Sector</th>
                    <td>{{ $empresa->sector }}</td>
                </tr>
                <tr>
                    <th>Fecha Registro</th>
                    <td>{{ $empresa->fecha_registro }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ $empresa->estado }}</td>
                </tr>
            </table>

            <div class="mt-4 text-center">
                <!-- EDITAR: usa data-attributes con los mismos nombres que los inputs del modal -->
                <button type="button"
                    class="btn btn-warning btn-edit-empresa"
                    data-toggle="modal"
                    data-target="#empresaModal"
                    data-id="{{ $empresa->id }}"
                    data-razon_social="{{ $empresa->razon_social }}"
                    data-nit="{{ $empresa->nit }}"
                    data-representante="{{ $empresa->representante }}"
                
                    data-telefono="{{ $empresa->telefono }}"
                    data-email="{{ $empresa->email }}"
                    data-direccion="{{ $empresa->direccion }}"
                    data-rubro="{{ $empresa->rubro }}"
                    data-sector="{{ $empresa->sector }}"
                    data-fecha="{{ $empresa->fecha_registro }}"
                    data-estado="{{ $empresa->estado }}">
                    Editar Empresa
                </button>
                <button class="btn btn-success" id="btnCertificado" data-toggle="modal" data-target="#modalCertificado" data-empresa-id="{{ $empresa->id }}">
  <i class="fa fa-certificate"></i> Otorgar Certificado
</button>
                


            </div>
        </div>
    </div>
</div>

{{-- incluir modal --}}
@include('empresa.modal')
@include('certificados.modal-certificado')

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // Delegated click handler (funciona aunque el botón esté en DOM)
    $(document).on('click', '.btn-edit-empresa', function () {

        const btn = $(this);
        const modal = $('#empresaModal');

        // Cambiar título
        modal.find('.modal-title').text('Editar Empresa');

        // Rellenar campos del modal, los name/id deben coincidir con los del modal
        modal.find('#empresa_id').val(btn.data('id'));
        modal.find('input[name="razon_social"]').val(btn.data('razon_social'));
        modal.find('input[name="nit"]').val(btn.data('nit'));
        modal.find('input[name="representante"]').val(btn.data('representante'));
        
        modal.find('input[name="telefono"]').val(btn.data('telefono'));
        modal.find('input[name="email"]').val(btn.data('email'));
        modal.find('input[name="direccion"]').val(btn.data('direccion'));
        modal.find('input[name="rubro"]').val(btn.data('rubro'));
        modal.find('input[name="sector"]').val(btn.data('sector'));
        modal.find('input[name="fecha_registro"]').val(btn.data('fecha'));
        modal.find('select[name="estado"]').val(btn.data('estado'));

        // Cambiar action del form para UPDATE (ruta RESTful)
        // Construimos la URL: /empresas/{id} (asegúrate de que Route::resource está definido)
        const id = btn.data('id');
        const form = $('#empresaForm');

        // Usa url() helper de blade para evitar problemas de prefijos
        form.attr('action', "{{ url('empresas') }}/" + id);

        // Agregar _method PUT si no existe
        if (!form.find('input[name="_method"]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        // Mostrar modal (solo en caso de que data-toggle no funcione)
        // modal.modal('show'); // no es necesario si data-toggle funciona
    });

    // Si quieres limpiar el formulario al cerrar el modal
    $('#empresaModal').on('hidden.bs.modal', function () {
        const form = $('#empresaForm');
        // eliminar _method si existe (para futuras aperturas como 'new')
        form.find('input[name="_method"]').remove();
    });

});
</script>
@endpush



