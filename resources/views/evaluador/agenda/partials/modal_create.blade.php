<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="POST" action="{{ route('visitas.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Programar Nueva Visita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Empresa</label>
                            <select name="empresa_id" class="form-control" required>
                                
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Hora</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label>Observaciones</label>
                            <textarea name="observaciones" class="form-control"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Guardar</button>
                </div>

            </form>

        </div>
    </div>
</div>