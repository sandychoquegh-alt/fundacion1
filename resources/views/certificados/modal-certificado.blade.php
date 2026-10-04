<div class="modal fade" id="modalCertificado" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formCertificado" action="{{ route('certificados.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Otorgar Certificado VAON</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body row">
          <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">

          <div class="form-group col-md-6">
            <label for="producto">Producto</label>
            <input type="text" id="producto" name="producto" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label for="empresa">Marca Comercial</label>
            <input type="text" class="form-control" id="empresa" name="empresa" value="{{ $empresa->razon_social }}" readonly>
          </div>

          <div class="form-group col-md-6">
            <label for="porcentaje_vaon">% VAON</label>
            <input type="number" step="0.01" id="porcentaje_vaon" name="porcentaje_vaon" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label for="imagen">Subir Imagen de la Marca Comercial</label>
            <input type="file" name="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
          </div>
          <div class="form-group col-md-6">
            <label for="" >Lugar de Fabricación</label>
            <input type="text" id="" name="" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label for="" >Motivos de la Certificación</label>
            <input type="text" id="" name="" class="form-control" required>
          </div>


          <div class="form-group col-md-6">
            <label for="fecha_emision" >Fecha de Emisión</label>
            <input type="date" id="fecha_emision" name="fecha_emision" class="form-control" required>
          </div>

          <div class="form-group col-md-6">
            <label for="fecha_vencimiento">Válido Hasta</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
          </div>

          <div class="col-md-6 text-center">
            <img id="preview" src="#" alt="Vista previa" style="display:none; max-width: 200px; border:1px solid #ccc;">
          </div>
        </div>

        <div class="modal-footer">
          
        <button type="button" class="btn btn-success" id="btnVistaPrevia">Vista Previa</button>
<a href="{{ route('certificados.certificado', $empresa->id) }}" 
                           class="btn btn-primary btn-sm" target="_blank">
                            Generar Certificado
                        </a>


          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function(){
    const output = document.getElementById('preview');
    output.src = reader.result;
    output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>
@push('scripts')
<script>
$(document).ready(function () {
    // Mostrar modal al hacer clic en el botón
    $(document).on('click', '#btnCertificado', function () {
        const empresaId = $(this).data('empresa-id');
        console.log("Empresa seleccionada:", empresaId);

        // Asigna el ID de empresa dentro del modal
        $('#modalCertificado input[name="empresa_id"]').val(empresaId);

        // Muestra el modal
        $('#modalCertificado').modal('show');
    });

    // Vista previa de imagen
    window.previewImage = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
});
</script>
@endpush

@push('scripts')
<script>
document.getElementById('btnVistaPrevia').addEventListener('click', function () {
    const form = document.querySelector('#formCertificado');
    const formData = new FormData(form);

    fetch('{{ route("certificados.preview") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // Abrimos una nueva pestaña para ver la plantilla renderizada
        const w = window.open();
        w.document.write(html);
        w.document.close();
    })
    .catch(error => console.error('Error en vista previa:', error));
});
</script>
@endpush

