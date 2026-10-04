@extends('layouts.evaluador')

@section('content')

<div class="container-fluid dashboard-container">

<!-- 🔷 KPI -->
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card kpi bg-primary text-white">
            <i class="fa fa-file"></i>
            <h6 class="mb-1">Total de Solicitudes Asignadas </h6>
                <h2>{{ $pendientes }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi bg-success text-white">
            <i class="fa fa-calendar"></i>
            <h6>Visitas Programadas</h6>
            <h2>{{ $visitasProgramadas }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi bg-warning text-dark">
            <i class="fa fa-clock"></i>
            <h6>Solicitudes Pendientes</h6>
            <h2>{{ $pendientes }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi bg-danger text-white">
            <i class="fa fa-exclamation-triangle"></i>
            <h6>Visitas por Programar</h6>
            <h2>{{ $visitasAtrasadas }}</h2>
        </div>
    </div>

</div>
<hr>
<!-- ⚠️ ALERTAS -->
@if($visitasAtrasadas > 0)
<div class="alert alert-danger shadow">
    ⚠️ Tienes {{ $visitasAtrasadas }} visitas atrasadas
</div>
@endif
<hr>
<div class="row">

<!-- 📅 VISITAS HOY -->
<div class="col-md-4">
<div class="card shadow mb-4">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-calendar"></i> Visitas de Hoy
    </div>

    <div class="card-body">

        @forelse($visitasHoy as $v)
            <div class="item">
                <strong>{{ $v->solicitud->empresa->razon_social }}</strong>
                <span>{{ $v->hora }}</span>
            </div>
        @empty
            <p class="text-muted">Sin visitas hoy</p>
        @endforelse

    </div>
</div>
</div>

<!-- 📊 GRÁFICOS -->
<div class="col-md-8">

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        📊 Visitas por Mes
    </div>
    <div class="card-body">
        <canvas id="visitasChart"></canvas>
    </div>
</div>


</div>

</div>
<hr>
<!-- 🕒 ACTIVIDAD -->
<div class="row mt-4">

    <!-- 📊 IZQUIERDA -->
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-header bg-success text-white">
                 Solicitudes por Estado
            </div>

            <div class="card-body">
                <canvas id="estadoChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 🕒 DERECHA -->
    <div class="col-md-8 mb-3">
        <div class="card shadow h-100">
            <div class="card-header bg-secondary text-white">
                <i class="fa fa-history"></i> Actividad Reciente
            </div>

            <div class="card-body">

                @foreach($ultimasVisitas as $v)
                    <div class="actividad-item">
                        <td>{{ $v->solicitud?->empresa?->razon_social }}</td>
                        <br>
                        <small class="text-muted" data-fecha="{{ $v->created_at }}">
                            {{ $v->created_at->diffForHumans() }} 
                            {{ $v->created_at->translatedFormat('d \d\e F \d\e Y ') }}

    {{ $v->fecha_pro }}
</small>
                    
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>

</div>

<!-- 📦 CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const visitasData = @json($visitasPorMes);
const meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

let dataMeses = Array(12).fill(0);
Object.keys(visitasData).forEach(m => dataMeses[m-1] = visitasData[m]);

new Chart(document.getElementById('visitasChart'), {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [{
            label: 'Visitas',
            data: dataMeses
        }]
    }
});

const estadoData = @json($solicitudesEstado);

new Chart(document.getElementById('estadoChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pendiente','Aprobadas','Rechazadas'],
        datasets: [{
            data: [
                estadoData.pendiente,
                estadoData.aprobadas,
                estadoData.rechazadas
            ]
        }]
    }
});
</script>

<!--este script es para el funcionamiento de la vista de Actividades recientes-->
<script>

function actualizarTiempos() {
    document.querySelectorAll('.tiempo').forEach(el => {

        let fecha = new Date(el.dataset.fecha);
        let ahora = new Date();

        let diff = Math.floor((ahora - fecha) / 1000);

        let texto = '';

        if(diff < 60){
            texto = 'hace ' + diff + ' segundos';
        }
        else if(diff < 3600){
            texto = 'hace ' + Math.floor(diff/60) + ' minutos';
        }
        else if(diff < 86400){
            texto = 'hace ' + Math.floor(diff/3600) + ' horas';
        }
        else{
            texto = fecha.toLocaleDateString('es-BO') + ' ' + fecha.toLocaleTimeString('es-BO');
        }

        el.innerText = texto;

    });
}

// ejecutar cada 60 segundos
setInterval(actualizarTiempos, 10000);

// ejecutar al cargar
actualizarTiempos();

</script>

<!-- 🎨 ESTILO -->
<style>

body{
    background: #eef2f7;
}

.dashboard-container{
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
}

/* Para pantallas grandes */
@media (min-width: 992px){
    .dashboard-container{
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
}

/* 📱 MÓVIL */
@media (max-width: 576px){
    .dashboard-container{
        padding: 10px;
    }
}

/* 📲 TABLET */
@media (min-width: 577px) and (max-width: 992px){
    .dashboard-container{
        max-width: 95%;
        padding: 15px;
    }
}

/* 💻 PANTALLAS GRANDES */
@media (min-width: 993px){
    .dashboard-container{
        max-width: 1200px;
        padding: 20px;
    }
}

/* 🖥️ PANTALLAS EXTRA GRANDES */
@media (min-width: 1400px){
    .dashboard-container{
        max-width: 1350px;
    }
}

.kpi{
    padding:20px;
    border-radius:12px;
    position:relative;
}

.kpi i{
    position:absolute;
    right:15px;
    top:15px;
    font-size:22px;
    opacity:0.3;
}

.item{
    display:flex;
    justify-content:space-between;
    border-bottom:1px solid #eee;
    padding:8px;
}

.actividad-item{
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.actividad-item:hover{
    background: #f8f9fa;
    border-radius: 5px;
}
.text-muted{
    font-size: 12px;
    color: #6c757d !important;
}

.tiempo{
    font-size: 12px;
    color: #6c757d;
    transition: 0.3s;
}

.tiempo:hover{
    color: #000;
}
</style>

@endsection