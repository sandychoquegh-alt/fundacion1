@extends('layouts.evaluador')

@section('content')
<style>
form{
    background: #f8f9fa;
    border-radius: 20px;
   /* border-left: 5px solid #0d6efd;*/
}
.pagination{
    border-radius: 8px;
}

.page-link{
    color: #0d6efd;
    border-radius: 6px !important;
    margin: 0 3px;
}

.page-item.active .page-link{
    background-color: #0d6efd;
    border-color: #0d6efd;
    font-weight: bold;
}

.page-link:hover{
    background: #e9f2ff;
}

</style>

<style>
.modal-custom {
    display: none;
    position: fixed;
  
    left: 0;
    top: -40px;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
}

.modal-contenido {
    background: white;
    padding: 0px;
    width: 400px;
    margin: 10% auto;
    border-radius: 10px;
    animation: fadeIn 0.3s ease-in-out;
    
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<div class="container">

<div class="card shadow">

    <div class="card-header bg-dark text-white">
        <h4><i class="fa fa-calendar"></i> Gestión de Visitas</h4>
    </div>

    <div class="card-body">



    <form method="GET" class="row g-3 mb-4 p-3 border rounded bg-light shadow-sm">

    <!-- Empresa -->
    <div class="col-md-2">
        <label class="form-label">Empresa</label>
        <input type="text" name="empresa" class="form-control"
        value="{{ request('empresa') }}"
        placeholder="Nombre empresa">
    </div>

    <!-- Producto -->
    <div class="col-md-2">
        <label class="form-label">Producto</label>
        <input type="text" name="producto" class="form-control"
        value="{{ request('producto') }}"
        placeholder="Nombre producto">
    </div>

    <!-- Estado -->
    <div class="col-md-2">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="">Todos</option>
            <option value="programada" {{ request('estado')=='Programada'?'selected':'' }}>Programada</option>
            <option value="reprogramada" {{ request('estado')=='Reprogramada'?'selected':'' }}>Reprogramada</option>
            <option value="realizada" {{ request('estado')=='Realizada'?'selected':'' }}>Realizada</option>
            <option value="cancelada" {{ request('estado')=='Cancelada'?'selected':'' }}>Cancelada</option>
        </select>
    </div>

    <!-- Fecha desde -->
    <div class="col-md-2">
        <label class="form-label">Desde</label>
        <input type="date" name="desde" class="form-control"
        value="{{ request('desde') }}">
    </div>

    <!-- Fecha hasta -->
    <div class="col-md-2">
        <label class="form-label">Hasta</label>
        <input type="date" name="hasta" class="form-control"
        value="{{ request('hasta') }}">
    </div>

    <!-- Botones -->
    <div class="col-md-1 text-end">
        <button class="btn btn-primary">
            <i class="fa fa-search"></i> Filtrar
        </button>

        <a href="{{ route('evaluador.visitas') }}" class="btn btn-secondary">
            Limpiar
        </a>
    </div>
</form >
<hr>
        <table class="table table-bordered table-hover">

            <thead class="table-dark bg-primary text-white">
                <tr>
                  
                    <th>Empresa</th>
                    <th>Marca Comercial</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            @foreach($visitas as $visita)

            <tr>
                 <td>{{ $visita->solicitud?->empresa?->razon_social ?? '-' }}</td>
                 <td>{{ $visita->solicitud?->marca ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($visita->fecha_visita)->format('d/m/Y') }}</td>

                <td>{{ \Carbon\Carbon::parse($visita->hora)->format('H:i') }}</td>

                <td>
                    @if($visita->estado == 'Programada')
                        <span class="badge bg-primary">Programada</span>
                    @elseif($visita->estado == 'Reprogramada')
                        <span class="badge bg-warning text-dark">Reprogramada</span>
                    @elseif($visita->estado == 'realizada')
                        <span class="badge bg-success">Realizada</span>
                    @else
                        <span class="badge bg-danger">Cancelada</span>
                    @endif
                </td>

                <td>
                    <a href="#" 
   class="btn btn-warning btn-sm"
  onclick="abrirModal(
    {{ $visita->id }},
    '{{ \Carbon\Carbon::parse($visita->fecha_visita)->format('Y-m-d') }}',
    '{{ \Carbon\Carbon::parse($visita->fecha_visita)->format('d/m/Y') }}'
)">
   Reprogramar
</a>
                    <!--
                    <a href="#" class="btn btn-blue btn-sm">Cancelar</a>
                    <a href="#" class="btn btn-success btn-sm">Completar</a>-->
                </td>
            </tr>

            @endforeach

            </tbody>

        </table>
<div class="d-flex justify-content-between align-items-center mt-3">

    <div>
        Mostrando {{ $visitas->firstItem() }} a {{ $visitas->lastItem() }} 
        de {{ $visitas->total() }} registros
    </div>

    <div>
        {{ $visitas->appends(request()->query())->links() }}
    </div>

</div>

    </div>
</div>
</div>

<!-- este es el modal para  que se REPROGRAME-->
<div id="modalReprogramar" class="modal-custom">
        
    <div class="modal-contenido p-4 m-0">


      <form id="formReprogramar" method="POST" class="m-0">

    <!-- HEADER -->
    <div class="modal-header"
     style="display:flex; justify-content:space-between; align-items:center; 
            background:#0d6efd; color:white; padding:10px 15px;
            border-top-left-radius:10px; 
            border-top-right-radius:10px;">
    <h5 style="margin:0;">
        <i class="fa-solid fa-calendar-check"></i> Reprogramar Visita
    </h5>

    <!-- BOTÓN CERRAR -->
    <button type="button"
            onclick="cerrarModal()"
            style="
                background: transparent;
                border: none;
                color: white;
                font-size: 22px;
                cursor: pointer;
            ">
        &times;
    </button>

</div>

    @csrf

    <!-- BODY -->
    <div class="p-4">

        <!-- OBSERVACIÓN -->
        <div class="mb-4" style=" padding:10px 20px;">
            <label for="observacion" class="form-label fw-bold">
                Motivo de la reprogramación *
            </label>

            <textarea 
                name="observacion" 
                id="observacion" 
                minlength="10"
                class="form-control shadow-sm" 
                rows="3"
                placeholder="Ej. Se reprograma por falta de disponibilidad del personal técnico en la fecha inicialmente prevista."
                required
            ></textarea>

            <small class="text-muted">
                Ingrese una justificación precisa y concisa.
            </small>
        </div>

        <!-- FECHA ANTERIOR -->
        <div class="mb-3 p-3 rounded" style="background: #f8f9fa; padding:15px 20px;">
            <span class="fw-semibold">📅 Fecha programada anteriormente:</span><br>
            <strong id="fecha_antigua_texto" class="text-danger"></strong>
        </div>

        <!-- NUEVA FECHA -->
        <div class="mb-4" style=" padding:15px 20px;">
            <label for="fecha_visita" class="form-label fw-bold">
                Nueva fecha de visita *
            </label>

            <input 
                type="date" 
                name="fecha_visita" 
                id="fecha_visita" 
                class="form-control shadow-sm"
                required 
                min="{{ date('Y-m-d') }}">
        </div>
        <!-- NUEVA HORA -->
<div class="mb-4" style="padding:15px 20px;">
    <label for="hora" class="form-label fw-bold">
        Hora de visita *
    </label>

    <input 
        type="time" 
        name="hora" 
        id="hora" 
        class="form-control shadow-sm"
        required
        min="08:00"
        max="18:00">
</div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-end gap-2" style="display:flex; justify-content:space-between; border-radius: 10px; align-items:center; padding:10px 15px;" >
          
            <button type="submit" 
                    class="btn btn-primary">
                💾 Guardar
            </button>
              <!-- BOTÓN CERRAR -->
             <button type="button"
              onclick="cerrarModal()"
                style="
                  background: transparent;
                  border: none;
                  color: red;
                  font-size: 15px;
                  cursor: pointer;
            ">Cerrar
        &times;
    </button>
        </div>

    </div>

</form>
    </div>
</div>
@endsection

<script>
function abrirModal(id, fecha) {
    let modal = document.getElementById('modalReprogramar');
    let form = document.getElementById('formReprogramar');
    let inputFecha = document.getElementById('fecha_visita');
    let textoFecha = document.getElementById('fecha_antigua_texto');
    // 👉 mostrar modal
    modal.style.display = 'block';

    // 👉 setear fecha actual
    inputFecha.value = fecha;

    // 👉 cambiar action dinámicamente
    form.action = "/evaluador/visitas/" + id + "/reprogramar";
     // 👉 mostrar como texto (solo visual)
    textoFecha.innerText = fecha;
}

function cerrarModal() {
    document.getElementById('modalReprogramar').style.display = 'none';
}

// cerrar si hace click afuera
//window.onclick = function(event) {
  //  let modal = document.getElementById('modalReprogramar');
  //  if (event.target == modal) {
   //     modal.style.display = "none";
   // }
//}
</script>


