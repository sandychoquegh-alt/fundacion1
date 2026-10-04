@extends('layouts.empresad')

@section('contenido')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Solicitud de Verificación VAON (Anexo A)</h3>
    </div>

    <form action="{{ route('empresa.verificacion.anexoA.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="box-body">

            {{-- DATOS DE LA ORGANIZACIÓN --}}
            <h4><strong>1. Datos de la Organización</strong></h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Razón Social *</label>
                    <input type="text" name="razon_social" value="{{ old('razon_social', $empresa->razon_social ?? '') }}" readonly class="form-control bg-light">
                </div>

                <div class="col-md-6">
                    <label>NIT *</label>
                    <input type="text" name="nit" value="{{ old('nit', $empresa->nit ?? '') }}" readonly class="form-control bg-light">
                </div>

                <div class="col-md-12">
                    <label>Dirección de fabricación *</label>
                    <input type="text" name="direccion" class="form-control" required>
                </div>
            </div>

            <hr>

            {{-- REPRESENTANTE LEGAL --}}
            <h4><strong>2. Representante Legal</strong></h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Nombre del representante legal *</label>
                    <input type="text" name="representante" value="{{ old('representante', $empresa->representante ?? '') }}" readonly class="form-control bg-light">
                </div>

                <div class="col-md-6">
                    <label>Cargo del Representante Legal*</label>
                    <input type="text" name="cargo" class="form-control" required>
                </div>
            </div>

            <hr>

            {{-- CONTACTO --}}
            <h4><strong>3. Persona de contacto</strong></h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Persona de contacto *</label>
                    <input type="text" name="persona_contacto" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Correo electrónico *</label>
                    <input type="email" name="correo" value="{{ old('correo', $empresa->email ?? '') }}" readonly class="form-control bg-light">
                </div>

                <div class="col-md-6">
                    <label>Teléfono *</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono ?? '') }}" readonly class="form-control bg-light">
                </div>

                <div class="col-md-6">
                    <label>Celular</label>
                    <input type="text" name="celular" class="form-control">
                </div>
            </div>

            <hr>

            {{-- PRODUCTOS A VERIFICAR --}}
           <!-- <h4><strong>4. Productos a Verificar</strong></h4>
            <div id="productosContainer">

                <div class="row producto-item">
                    <div class="col-md-6">
                        <label>Nombre del producto *</label>
                        <input type="text" name="productos[0][nombre]" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Marca comercial *</label>
                        <input type="text" name="productos[0][marca]" class="form-control" required>
                    </div>
                </div>

            </div>

            <button type="button" class="btn btn-info mt-2" id="addProducto">+ Agregar otro producto</button>

            <hr>

            {{-- ARCHIVOS --}}
            <h4><strong>5. Documentos Requeridos</strong></h4>

            <div class="form-group">
                <label>Adjuntar Diagramas de flujo de los procesos, que permitan conocer de manera global los procesos implicados en la elaboración de los productos ( JPG, PNG) *</label>
                <input type="file" name="diagrama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Descripción de los procesos,  que permitan conocer de manera global los procesos implicados en la elaboracion de los productos</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>-->

        </div>

        <div class="box-footer">
            <button class="btn btn-primary">Guardar Información</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
let index = 1;

document.getElementById('addProducto').addEventListener('click', function () {
    let container = document.getElementById('productosContainer');

    let html = `
        <div class="row producto-item mt-3">
            <div class="col-md-6">
                <label>Nombre del producto *</label>
                <input type="text" name="productos[${index}][nombre]" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Marca comercial *</label>
                <input type="text" name="productos[${index}][marca]" class="form-control" required>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    index++;
});
</script>
@endpush
