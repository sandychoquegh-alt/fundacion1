@extends('layouts.empresad')

@section('contenido')
<div class="">
    <div class="box-header with-border">
        <h3 class="box-title">Crear Nueva Solicitud</h3>
    </div>
    <div class="box-body">

        <form action="{{ route('empresa.solicitudes.store') }}" method="POST" enctype="multipart/form-data" id="formSolicitud">
            @csrf
            <input type="hidden" name="accion" id="accion">

            <div id="productos-container">




    <div class="form-group producto-item">
        <label>Nombre del Producto</label>
        <input type="text" name="producto_nombre[]" class="form-control mb-2" required>

        <button type="button" class="btn btn-danger btn-sm eliminar-producto">
            Eliminar
        </button>
        <hr>
    </div>

</div>

<button type="button" id="agregar-producto" class="btn btn-success mt-2">
    <i class="fa-solid fa-circle-plus"></i> Agregar otro producto
</button>


            <div class="form-group">
                <label>Marca Comercial</label>
                <input type="text" name="marca" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Dirección y Lugar de Fabrica..</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <!--
              <div class="col-md-4">
            <label><strong>Dirección y Lugar de fabricación:</strong></label>
            <input type="text" name="lugar_fabricacion" class="form-control" required>
        </div>-->
            <div class="form-group">
                <label>Declaración Jurada(pdf) Subir el documento descargado del AnexoA</label>
                <input type="file" name="declaracion_jurada" class="form-control"  placeholder="ingresar el anexoA " required>
            </div>

            <div class="form-group">
                <label>Respaldos(pdf,jpg,png,jpeg) Subir el documento descargado del AnexoB</label>
                <input type="file" name="respaldos[]" class="form-control" multiple  placeholder="Ubir el documento del anexoB"  required>
            </div>

            <div class="form-group">
                <label>Diagrama (PDF/JPG/PNG/jpeg)</label>
                <input type="file" name="diagrama" class="form-control" required>
            </div>

            <div class="form-group">

    <label>
        <strong>Imágenes de los productos</strong>
    </label>

    <input
        type="file"
        id="selector-imagen"
        class="form-control"
        accept="image/jpeg,image/jpg,image/png"
    >

    <small
        id="contador-imagenes"
        class="text-muted">
        0 de 0 imágenes seleccionadas
    </small>

    <div
        id="lista-imagenes"
        class="mt-3">
    </div>

    {{-- Inputs que realmente se enviarán --}}
    <div
        id="inputs-imagenes">
    </div>

</div>
            <div class="form-group">
                <input type="checkbox" name="declaracion_veraz" required>
                Acepto la declaración veraz
            </div>

            <!-- BOTONES
            <button type="submit" class="btn btn-success" name="accion" value="guardar">
    Guardar
</button> -->

<button type="submit" class="btn btn-primary" name="accion" value="enviar">
    Enviar
</button>


        </form>

    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(() => {
    const form = document.getElementById('formSolicitud');
    const contenedor = document.querySelector('.box-body');

    function enviarSolicitud(accion) {
        document.getElementById('accion').value = accion;

        let titulo = accion === 'guardar' ? 'Guardar como borrador' : 'Enviar solicitud';
        let texto  = accion === 'guardar' 
                     ? 'Podrás editar esta solicitud más adelante.' 
                     : 'Una vez enviada, pasará a revisión.';

        Swal.fire({
            title: titulo,
            text: texto,
            icon: accion === 'guardar' ? 'info' : 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed){

                if(accion === 'enviar'){
                    contenedor.style.opacity = "0";
                    contenedor.style.transition = "opacity .5s ease";
                    setTimeout(() => { contenedor.style.display = "none"; }, 600);
                }

                form.submit(); 
            }
        });
    }

    document.querySelector('button[name="accion"][value="enviar"]').addEventListener('click', (e) => {
        e.preventDefault();
        enviarSolicitud('enviar');
    });
})();
</script>


<script>
document.getElementById('agregar-producto').addEventListener('click', function () {

    let container = document.getElementById('productos-container');

    // 🔍 Obtener inputs
    let inputs = container.querySelectorAll('input[name="producto_nombre[]"]');

    // 🚫 Evitar agregar si hay vacíos
    for (let input of inputs) {
        if (input.value.trim() === '') {
            input.focus();
            return;
        }
    }

    // ✅ Crear nuevo campo
    let nuevoProducto = document.createElement('div');
    nuevoProducto.classList.add('form-group', 'producto-item');

    nuevoProducto.innerHTML = `
        <label>Nombre del Producto</label>
        <input type="text" name="producto_nombre[]" class="form-control mb-2" required>

        <button type="button" class="btn btn-danger btn-sm eliminar-producto">
            Eliminar
        </button>
        <hr>
    `;

    container.appendChild(nuevoProducto);
});

// ❌ ELIMINAR
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('eliminar-producto')) {
        e.target.closest('.producto-item').remove();
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const selectorImagen = document.getElementById('selector-imagen');
    const listaImagenes = document.getElementById('lista-imagenes');
    const contadorImagenes = document.getElementById('contador-imagenes');
    const inputsImagenes = document.getElementById('inputs-imagenes');
    const productosContainer = document.getElementById('productos-container');
    const formSolicitud = document.getElementById('formSolicitud');

    // Guardar las imágenes seleccionadas
    let imagenesSeleccionadas = [];


    // ==========================================
    // OBTENER CANTIDAD DE PRODUCTOS
    // ==========================================

    function obtenerCantidadProductos() {

        return productosContainer.querySelectorAll(
            'input[name="producto_nombre[]"]'
        ).length;
    }


    // ==========================================
    // ACTUALIZAR CONTADOR
    // ==========================================

    function actualizarContador() {

        const totalProductos =
            obtenerCantidadProductos();

        contadorImagenes.textContent =
            imagenesSeleccionadas.length +
            ' de ' +
            totalProductos +
            ' imágenes seleccionadas';
    }


    // ==========================================
    // SELECCIONAR UNA IMAGEN
    // ==========================================

    selectorImagen.addEventListener('change', function () {

        if (!this.files || this.files.length === 0) {
            return;
        }

        const archivo = this.files[0];

        const totalProductos =
            obtenerCantidadProductos();


        // --------------------------------------
        // CONTROLAR CANTIDAD
        // --------------------------------------

        if (
            imagenesSeleccionadas.length >=
            totalProductos
        ) {

            Swal.fire({
                icon: 'warning',
                title: 'Cantidad máxima alcanzada',
                text:
                    'Tienes ' +
                    totalProductos +
                    ' producto(s). Debes seleccionar una imagen por cada producto.',
                confirmButtonText: 'Entendido'
            });

            this.value = '';

            return;
        }


        // --------------------------------------
        // VALIDAR TIPO DE IMAGEN
        // --------------------------------------

        const tiposPermitidos = [
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];

        if (!tiposPermitidos.includes(archivo.type)) {

            Swal.fire({
                icon: 'error',
                title: 'Archivo no válido',
                text: 'Solo se permiten imágenes JPG, JPEG o PNG.',
                confirmButtonText: 'Entendido'
            });

            this.value = '';

            return;
        }


        // --------------------------------------
        // GUARDAR IMAGEN
        // --------------------------------------

        imagenesSeleccionadas.push(archivo);


        // IMPORTANTE:
        // Limpiamos el selector para poder
        // volver a elegir otra imagen.
        this.value = '';


        mostrarImagenes();
        actualizarInputs();
        actualizarContador();
    });


    // ==========================================
    // MOSTRAR LAS IMÁGENES
    // ==========================================

    function mostrarImagenes() {

        listaImagenes.innerHTML = '';

        imagenesSeleccionadas.forEach(
            function (archivo, index) {

                const div =
                    document.createElement('div');

                div.className =
                    'd-flex align-items-center border rounded p-2 mb-2';

                const url =
                    URL.createObjectURL(archivo);

                div.innerHTML = `

                    <img
                        src="${url}"
                        style="
                            width:70px;
                            height:70px;
                            object-fit:cover;
                            border-radius:8px;
                            margin-right:12px;
                        "
                    >

                    <div style="flex:1">

                        <strong>
                            Imagen del Producto ${index + 1}
                        </strong>

                        <br>

                        <small>
                            ${archivo.name}
                        </small>

                    </div>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm eliminar-imagen"
                        data-index="${index}">

                        <i class="fa fa-trash"></i>

                    </button>

                `;

                listaImagenes.appendChild(div);
            }
        );

    }


    // ==========================================
    // ELIMINAR IMAGEN
    // ==========================================

    document.addEventListener(
        'click',
        function (e) {

            const boton =
                e.target.closest('.eliminar-imagen');

            if (!boton) {
                return;
            }

            const index =
                parseInt(
                    boton.getAttribute('data-index')
                );

            imagenesSeleccionadas.splice(
                index,
                1
            );

            mostrarImagenes();
            actualizarInputs();
            actualizarContador();
        }
    );


    // ==========================================
    // CREAR INPUTS PARA EL FORMULARIO
    // ==========================================

    function actualizarInputs() {

        inputsImagenes.innerHTML = '';

        imagenesSeleccionadas.forEach(
            function (archivo) {

                const dataTransfer =
                    new DataTransfer();

                dataTransfer.items.add(archivo);

                const input =
                    document.createElement('input');

                input.type = 'file';
                input.name = 'imagenes[]';
                input.hidden = true;

                input.files =
                    dataTransfer.files;

                inputsImagenes.appendChild(input);
            }
        );
    }


    // ==========================================
    // AGREGAR PRODUCTO
    // ==========================================

    const botonAgregar =
        document.getElementById('agregar-producto');

    if (botonAgregar) {

        botonAgregar.addEventListener(
            'click',
            function () {

                setTimeout(
                    function () {

                        actualizarContador();

                    },
                    100
                );

            }
        );
    }


    // ==========================================
    // ELIMINAR PRODUCTO
    // ==========================================

    document.addEventListener(
        'click',
        function (e) {

            const botonEliminar =
                e.target.closest('.eliminar-producto');

            if (!botonEliminar) {
                return;
            }

            setTimeout(
                function () {

                    const totalProductos =
                        obtenerCantidadProductos();


                    // Si hay más imágenes
                    // que productos, eliminamos
                    // las sobrantes.

                    if (
                        imagenesSeleccionadas.length >
                        totalProductos
                    ) {

                        imagenesSeleccionadas =
                            imagenesSeleccionadas.slice(
                                0,
                                totalProductos
                            );

                        mostrarImagenes();
                        actualizarInputs();
                    }

                    actualizarContador();

                },
                100
            );
        }
    );


    // ==========================================
    // VALIDAR ANTES DE ENVIAR
    // ==========================================

    formSolicitud.addEventListener(
        'submit',
        function (e) {

            const totalProductos =
                obtenerCantidadProductos();

            const totalImagenes =
                imagenesSeleccionadas.length;


            if (
                totalImagenes !==
                totalProductos
            ) {

                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Imágenes incompletas',
                    text:
                        'Has registrado ' +
                        totalProductos +
                        ' producto(s), pero seleccionaste ' +
                        totalImagenes +
                        ' imagen(es). Debes seleccionar una imagen para cada producto.',
                    confirmButtonText: 'Entendido'
                });

                return false;
            }

        }
    );


    // ==========================================
    // INICIO
    // ==========================================

    actualizarContador();

});
</script>
@endpush




