@extends('layouts.evaluador')

@section('content')


<style>

#toast-container{
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.toast{
    width: 320px;
    margin-bottom: 15px;
    padding: 15px 18px;
    border-radius: 12px;
    color: #fff;
    font-weight: 500;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;

    opacity: 0;
    transform: translateX(120%);
    transition: all 0.4s ease;
}

/* TIPOS */
.toast-success{ background: linear-gradient(135deg,#28a745,#1e7e34); }
.toast-error{ background: linear-gradient(135deg,#dc3545,#a71d2a); }
.toast-warning{ background: linear-gradient(135deg,#ffc107,#d39e00); color:#000; }
.toast-info{ background: linear-gradient(135deg,#17a2b8,#117a8b); }

/* mostrar */
.toast.show{
    opacity: 1;
    transform: translateX(0);
}

/* botón cerrar */
.toast-close{
    position: absolute;
    top: 10px;
    right: 12px;
    cursor: pointer;
    font-weight: bold;
}

/* barra progreso */
.toast-progress{
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    background: rgba(255,255,255,0.7);
    width: 100%;
    animation: progress 4s linear forwards;
}

@keyframes progress{
    from{ width: 100%; }
    to{ width: 0%; }
}

</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Agenda de Visitas</h3>

        

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalVisita">

<i class="fa fa-calendar-plus-o"></i>
Programar Visita

</button>
    </div>
     
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mb-2">
    <span class="badge" style="background:#f39c12">Programada</span>
    <span class="badge" style="background:#28a745">Realizada</span>
    <span class="badge" style="background:#dc3545">Cancelada</span>
</div>
            <div id="calendar"></div>
            
        </div>
    </div>

</div>
<!--estos son para las alertas -->
<div id="toast-container"></div>

<!-- 🔊 sonido -->
<audio id="toast-sound" src="https://www.soundjay.com/buttons/sounds/button-3.mp3"></audio>
@include('evaluador.agenda.partials.modal_create')

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var visitas = @json($visitas->map(function($visita){
        return [
            'title' => 'Visita - ' . ($visita->empresa->razon_social ?? 'Empresa'),
            'start' => $visita->fecha_visita,
            'estado' => $visita->estado
           
        ];
    }));

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        locale: 'es',
        height: 650,

        events: visitas,

        // 🎨 AQUÍ aplicamos colores según el estado
        eventDidMount: function(info) {

    let estado = info.event.extendedProps.estado;

    if (estado === 'Programada') {
        info.el.style.backgroundColor = '#f39c12';
        info.el.style.color = '#000'; // 🟡 texto negro
    }

    if (estado === 'Realizada') {
        info.el.style.backgroundColor = '#28a745';
        info.el.style.color = '#fff'; // 🟢 texto blanco
    }

    if (estado === 'Cancelada') {
        info.el.style.backgroundColor = '#dc3545';
        info.el.style.color = '#fff'; // 🔴 texto blanco
    }

    // 💡 opcional: hacerlo más bonito
    info.el.style.borderRadius = '6px';
    info.el.style.fontWeight = 'bold';
}

    });

    calendar.render();

});

</script>

<script>

function showToast(message, type = 'success') {

    let container = document.getElementById('toast-container');
    let sound = document.getElementById('toast-sound');

    let toast = document.createElement('div');
    toast.classList.add('toast', 'toast-' + type);

    // iconos
    let icons = {
        success: '<i class="fa fa-check-circle me-2"></i>',
        error: '<i class="fa fa-times-circle me-2"></i>',
        warning: '<i class="fa fa-exclamation-circle me-2"></i>',
        info: '<i class="fa fa-info-circle me-2"></i>'
    };

    toast.innerHTML = `
        <span class="toast-close">&times;</span>
        ${icons[type] || ''} ${message}
        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);

    // mostrar
    setTimeout(() => toast.classList.add('show'), 100);

    // 🔊 sonido
    if(sound){
        sound.currentTime = 0;
        sound.play().catch(()=>{});
    }

    // cerrar manual
    toast.querySelector('.toast-close').onclick = () => removeToast(toast);

    // auto cerrar
    setTimeout(() => removeToast(toast), 4000);
}

function removeToast(toast){
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
}

</script>

<script>

@if(session('success'))
    showToast("{{ session('success') }}", "success");
@endif

@if(session('error'))
    showToast("{{ session('error') }}", "error");
@endif

@if(session('warning'))
    showToast("{{ session('warning') }}", "warning");
@endif

@if(session('info'))
    showToast("{{ session('info') }}", "info");
@endif

</script>

@endpush
 
<!--esto es para que se vea el modal PROGRAMAR VISITAS-->

<div class="modal fade" id="modalVisita">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<form action="{{ route('visitas.store') }}" method="POST">

@csrf

<div class="modal-header">

<h4 class="modal-title">Programar Visita</h4>

<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>


<div class="modal-body">

<table class="table table-bordered">

<thead>

<tr>
<th>Empresa</th>
<th>Marca Comercial</th>
<th>Seleccionar</th>

</tr>

</thead>

<tbody>

@forelse($solicitudes as $solicitud)

<tr>

<td>{{ $solicitud->empresa->razon_social ?? 'Empresa' }}</td>

<input type="hidden" name="producto_id" value="{{ $solicitud->producto_id }}">
<td>{{ $solicitud->marca ?? 'Producto' }}</td>

<td>

<input type="radio" name="solicitud_id" value="{{ $solicitud->id }}" required >

</td>

</tr>

@endforeach

</tbody>

</table>


<hr>

<div class="form-group">

<label>Fecha de visita</label>

<input type="date" name="fecha_visita" class="form-control" required min="{{ date('Y-m-d') }}">

</div>

<div class="form-group">

<label>Hora</label>

<input type="time" name="hora" class="form-control">

</div>

</div>


<div class="modal-footer">

<button class="btn btn-primary">

Guardar visita

</button>

</div>

</form>

</div>

</div>

</div>