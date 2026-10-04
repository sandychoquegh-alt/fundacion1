<div class="modal fade" id="modalCertificado" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


        <form id="formCertificado"
              action="{{ route('certificados.generar') }}"
              method="POST"
              enctype="multipart/form-data"  target="_blank">

            @csrf

            <div class="modal-header">
                <h4 class="modal-title">Generar Certificado</h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Cerrar">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body row">

                {{-- IDs --}}
                <input type="hidden"
                       name="producto_id"
                       id="producto_id">

                <input type="hidden"
                       name="empresa_id"
                       id="empresa_id">

                {{-- PRODUCTO --}}
                <div class="form-group col-md-6">
                    <label>Producto</label>
                    <input type="text"
                           id="producto"
                           name="producto"
                           class="form-control"
                           readonly
                           required>
                </div>

                {{-- EMPRESA --}}
                <div class="form-group col-md-6">
                    <label>Empresa</label>
                    <input type="text"
                           id="empresa"
                           class="form-control"
                           readonly>
                </div>

                {{-- CÓDIGO --}}
                <div class="form-group col-md-6">
                    <label>N.º de Certificado</label>
                    <input type="text"
                           name="codigo"
                           class="form-control"
                           placeholder="Ingrese el número de certificado"
                           required>
                </div>

                {{-- IMAGEN --}}
                <div class="form-group col-md-6">
                    <label>Imagen / Marca Comercial</label>

                    <input type="file"
                           name="imagen"
                           class="form-control"
                           accept="image/*"
                           onchange="previewImage(event)">

                    <img id="preview"
                         src="#"
                         style="display:none; max-width:180px; margin-top:10px;">
                </div>

                {{-- MOTIVOS --}}
                <div class="form-group col-md-6">
                    <label>Motivo de la Certificación</label>

                    <input type="text"
                           name="motivos_cert"
                           class="form-control"
                           placeholder="Ingrese una breve descripción"
                           required>
                </div>

                {{-- PORCENTAJE VAON --}}
                <div class="form-group col-md-6">
                    <label>Porcentaje VAON (%)</label>

                    <input type="number"
                           name="porcentaje_vaon"
                           class="form-control"
                           min="0"
                           max="100"
                           step="0.01"
                           placeholder="Ej. 70, 80, 100"
                           required>
                </div>

                {{-- LUGAR --}}
                <div class="form-group col-md-6">
                    <label>Lugar de Fabricación</label>

                    <input type="text"
                           name="lugar_fabricacion"
                           class="form-control"
                           placeholder="Ingrese el lugar de fabricación"
                           required>
                </div>

                {{-- FECHA EMISIÓN --}}
                <div class="form-group col-md-6">
                    <label>Fecha de Emisión</label>

                    <input type="date"
                           name="fecha_emision"
                           class="form-control"
                           required>
                </div>

                {{-- FECHA VENCIMIENTO --}}
                <div class="form-group col-md-6">
                    <label>Válido Hasta</label>

                    <input type="date"
                           name="fecha_vencimiento"
                           class="form-control"
                           required>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="form-group col-md-12">
                    <label>Información del Producto</label>

                    <textarea name="descripcion"
                              class="form-control"
                              rows="4"
                              placeholder="Ingrese información del producto"
                              required></textarea>
                </div>

            </div>

            <div class="modal-footer">

                <button type="submit"
                        class="btn btn-success">
                    <i class="fa fa-certificate"></i>
                    Generar Certificado
                </button>

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Cerrar
                </button>

            </div>

        </form>

    </div>
</div>


</div>

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ======================================================
// PREVISUALIZAR IMAGEN
// ======================================================

function previewImage(event) {

    const img = document.getElementById('preview');

    if (event.target.files && event.target.files[0]) {

        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';

    } else {

        img.src = '#';
        img.style.display = 'none';

    }
}


// ======================================================
// ABRIR MODAL Y CARGAR DATOS
// ======================================================

$(document).on('click', '.btn-open-cert', function () {

    const productoId = $(this).data('id');
    const empresaId = $(this).data('empresa');
    const producto = $(this).data('producto');
    const empresaNombre = $(this).data('empresa-nombre');

    // IDs
    $('#producto_id').val(productoId);
    $('#empresa_id').val(empresaId);

    // Datos visuales
    $('#producto').val(producto);
    $('#empresa').val(empresaNombre);

    console.log('Producto ID:', productoId);
    console.log('Empresa ID:', empresaId);
    console.log('Producto:', producto);
    console.log('Empresa:', empresaNombre);

});


// ======================================================
// LIMPIAR MODAL AL CERRAR
// ======================================================

$('#modalCertificado').on('hidden.bs.modal', function () {

    $('#formCertificado')[0].reset();

    $('#producto_id').val('');
    $('#empresa_id').val('');

    $('#producto').val('');
    $('#empresa').val('');

    $('#preview').attr('src', '#');
    $('#preview').hide();

});


// ======================================================
// VALIDACIÓN
// ======================================================

$('#formCertificado').on('submit', function (event) {

    const productoId = $('#producto_id').val().trim();
    const empresaId = $('#empresa_id').val().trim();

    const codigo = $('input[name="codigo"]').val().trim();
    const motivos = $('input[name="motivos_cert"]').val().trim();
    const porcentaje = $('input[name="porcentaje_vaon"]').val().trim();
    const lugar = $('input[name="lugar_fabricacion"]').val().trim();

    const emision = $('input[name="fecha_emision"]').val();
    const vencimiento = $('input[name="fecha_vencimiento"]').val();

    const descripcion = $('textarea[name="descripcion"]').val().trim();

    let errores = [];


    if (!productoId) {
        errores.push('No se encontró el producto.');
    }

    if (!empresaId) {
        errores.push('No se encontró la empresa.');
    }

    if (!codigo) {
        errores.push('Debe ingresar el número de certificado.');
    }

    if (!motivos) {
        errores.push('Debe ingresar el motivo de la certificación.');
    }

    if (!porcentaje) {
        errores.push('Debe ingresar el porcentaje VAON.');
    }

    if (porcentaje < 0 || porcentaje > 100) {
        errores.push('El porcentaje VAON debe estar entre 0 y 100.');
    }

    if (!lugar) {
        errores.push('Debe ingresar el lugar de fabricación.');
    }

    if (!emision) {
        errores.push('Debe ingresar la fecha de emisión.');
    }

    if (!vencimiento) {
        errores.push('Debe ingresar la fecha de vencimiento.');
    }

    if (emision && vencimiento && vencimiento < emision) {
        errores.push('La fecha de vencimiento no puede ser anterior a la fecha de emisión.');
    }

    if (!descripcion) {
        errores.push('Debe ingresar la información del producto.');
    }


    // Si existen errores
    if (errores.length > 0) {

        event.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'No se puede generar el certificado',
            html: errores.join('<br>'),
            confirmButtonText: 'Entendido'
        });

        return false;
    }


    // Confirmación
    event.preventDefault();

    Swal.fire({
        icon: 'question',
        title: '¿Generar certificado?',
        text: 'Se generará el certificado para este producto.',
        showCancelButton: true,
        confirmButtonText: 'Sí, generar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $('#formCertificado')[0].submit();

        }

    });

});

</script>

@endsection
