<div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="empresaForm" method="POST" action="{{ route('empresas.store') }}">
    
           @csrf

    <input type="hidden" name="id" id="empresa_id">

        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="empresaModalLabel">Nueva Empresa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body row">
            <div class="col-md-6 form-group">
                <label for="razon_social" class="form-label">Nombre de la Empresa</label>
                <input type="text" class="form-control" name="razon_social" id="razon_social" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="validationDefault02" class="form-label">NIT</label>
                <input type="text" class="form-control" name="nit" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="representante" class="form-label">Representante</label>
                <input type="text" class="form-control" name="representante" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" id="telefono" required>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="validationDefaultCorreo">Email</label>
                <input type="email" class="form-control" id="validationDefaultCorreo" name="email" aria-describedby="inputGroupPrepend2" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="validationDefault6" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" id="validationDefault6" required>
            </div>
            <!--
            <div class="col-md-6 form-group">
                <label for="validationDefault07" class="form-label">Rubro</label>
                <input type="text" class="form-control" name="rubro" id="validationDefault07"required>
            </div>
            
            

            <div class="col-md-6 form-group">
                <label for="tipo_empresa" class="form-label">Tipo de Empresa</label>
                <select class="form-select form-control" name="estado" id="validationDefault04" required>
                    <option selected disabled value="">Elegir...</option>
                    <option value="pendiente">UNIPERSONAL</option>
                    <option value="en_revision">S.R.L</option>
                    <option value="aprobada">LTDA</option>
                    <option value="rechazada">S.A</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="sector" class="form-label">Sector</label>
                <input type="text" class="form-control" name="sector"  id="sector" required>
            </div>
           
           

            <div class=" col-md-6 form-group">
                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                <input type="date" class="form-control" name="fecha_registro" id="fecha_registro" required>
            </div>
             -->
            <div class="col-md-6 form-group">
                <label for="validationDefault04">Estado</label>
                <select class="form-select form-control" name="estado" id="validationDefault04" required>
                    <option selected disabled value="">Elegir...</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_revision">En revisión</option>
                    <option value="aprobada">Aprobada</option>
                    <option value="rechazada">Rechazada</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class=" modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

