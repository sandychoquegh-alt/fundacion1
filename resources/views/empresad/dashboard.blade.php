@extends('layouts.empresad')

@section('contenido')

<style>

.dashboard-title{
font-weight:700;
margin-bottom:10px;
}

.stat-card{
background:white;
border-radius:12px;
padding:20px;
box-shadow:0px 4px 15px rgba(0,0,0,0.08);
transition:0.3s;
margin-bottom:20px;
}

.stat-card:hover{
transform:translateY(-5px);
}

.stat-number{
font-size:32px;
font-weight:bold;
}

.progress-tramite{
margin-top:30px;
}

.quick-btn{
padding:15px 25px;
margin:5px;
border-radius:8px;
font-size:16px;
}

.chart-card{
background:white;
border-radius:10px;
padding:20px;
box-shadow:0px 4px 12px rgba(0,0,0,0.08);
margin-bottom:20px;
}



.dashboard-header h1{
font-size:28px;
font-weight:bold;
}

.dashboard-header p{
color:#666;
margin-bottom:25px;
}

/* CARDS */

.dashboard-cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-bottom:30px;
}

.card{
display:flex;
align-items:center;
background:#fff;
padding:20px;
border-radius:10px;
box-shadow:0 4px 15px rgba(0,0,0,0.08);
transition:0.3s;
}

.card:hover{
transform:translateY(-5px);
}

.card-icon{
width:60px;
height:60px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
color:white;
font-size:24px;
margin-right:15px;
}

.bg-blue{background:#3498db;}
.bg-green{background:#2ecc71;}
.bg-orange{background:#f39c12;}
.bg-red{background:#e74c3c;}

.card-info h3{
font-size:22px;
margin:0;
}

.card-info p{
margin:0;
color:#777;
}

/* ACCIONES */

.dashboard-actions h2{
margin-bottom:15px;
}

.actions-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
gap:15px;
}

.action-card{
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
background:white;
padding:25px;
border-radius:10px;
text-decoration:none;
color:#333;
box-shadow:0 4px 15px rgba(0,0,0,0.08);
transition:0.3s;
}

.action-card:hover{
background:#2c3e50;
color:white;
transform:translateY(-3px);
}

.action-card i{
font-size:30px;
margin-bottom:10px;
}



/* =========================================================
   BANNER CAPACITACIONES FHB
========================================================= */

.banner-capacitaciones {
    background: linear-gradient(135deg, #1a4d7a, #252b88);
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 25px;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
}

.banner-contenido {
    display: flex;
    align-items: center;
    gap: 25px;
}

.banner-icono {
    width: 80px;
    height: 80px;
    min-width: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);

    display: flex;
    align-items: center;
    justify-content: center;
}

.banner-icono i {
    font-size: 38px;
    color: #f5c542;
}

.banner-texto h2 {
    margin-top: 0;
    margin-bottom: 10px;
    font-weight: bold;
    color: #fff;
}

.banner-texto p {
    margin-bottom: 18px;
    font-size: 15px;
    color: #f1f1f1;
}

.btn-capacitaciones {
    background: #f5c542;
    color: #1a1a1a !important;
    font-weight: bold;
    border-radius: 6px;
    padding: 10px 18px;
    border: none;
}

.btn-capacitaciones:hover {
    background: #fff;
    color: #252b88 !important;
}


/* =========================================================
   BANNER CAPACITACIONES
========================================================= */

.banner-capacitaciones {
    background: linear-gradient(135deg, #1a4d7a, #252b88);
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 25px;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
}

.banner-contenido {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}


/* =========================================================
   PARTE IZQUIERDA
========================================================= */

.banner-texto {
    flex: 1;
}

.banner-icono {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 15px;
}

.banner-icono i {
    font-size: 30px;
    color: #f5c542;
}

.banner-texto h2 {
    margin-top: 0;
    margin-bottom: 10px;
    font-weight: bold;
    color: #fff;
}

.banner-texto p {
    margin-bottom: 18px;
    font-size: 15px;
    color: #f1f1f1;
    max-width: 550px;
}


/* =========================================================
   BOTÓN
========================================================= */

.btn-capacitaciones {
    background: #f5c542;
    color: #1a1a1a !important;
    font-weight: bold;
    border-radius: 6px;
    padding: 10px 18px;
    border: none;
}

.btn-capacitaciones:hover {
    background: #fff;
    color: #252b88 !important;
}


/* =========================================================
   CARRUSEL
========================================================= */

.banner-carrusel {
    width: 42%;
    height: 220px;
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    flex-shrink: 0;
}

.imagen-carrusel {
    position: absolute;
    width: 100%;
    height: 100%;

    opacity: 0;
    transform: translateX(40px);

    transition:
        opacity 0.8s ease,
        transform 0.8s ease;
}

.imagen-carrusel.activa {
    opacity: 1;
    transform: translateX(0);
}

.imagen-carrusel img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .banner-contenido {
        flex-direction: column;
    }

    .banner-texto {
        width: 100%;
    }

    .banner-carrusel {
        width: 100%;
        height: 200px;
    }

}


</style>


<div class="container-fluid">

<!-- BIENVENIDA -->

<div class="row">

<div class="col-md-12">

<h2 class="dashboard-title">
Bienvenido, <strong>{{ auth()->user()->name ?? 'Empresa' }}</strong>
</h2>

<p class="text-muted">
Panel de control del sistema de certificación VAON.
</p>

</div>

</div>



<!-- TARJETAS ESTADISTICAS -->

 <div class="dashboard-cards">

        <div class=" card">
            <div class="card-icon bg-blue">
                <i class="fa fa-file-text"></i>
                
            </div>
            <div class="card-info">
                <p>Solicitudes Enviadas</p>
            </div>
            <div class="col-md-3">
              <div class=""><h2><b>{{ $solicitudes }}</b></h2></div>
            </div>
        </div>

        <div class="card">
            <div class="card-icon bg-green">
                <i class="fa fa-certificate"></i>
            </div>
            <div class="card-info">
                
                <p>Certificados Aprobados</p>
            </div>
            <div class="col-md-3">
              <div class=""><h2><b>{{ $certificados }}</b></h2></div>
            </div>
        </div>

        <div class="card">
            <div class="card-icon bg-orange">
                <i class="fa fa-search"></i>
            </div>
            <div class="card-info">
                <h3></h3>
                <p>En Revisión</p>
            </div>
            <div class="col-md-3">
              <div class=""><h2><b>{{ $enRevision }}</b></h2></div>
            </div>
        </div>

        <div class="card">
            <div class="card-icon bg-red">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="card-info">
                <h3></h3>
                <p>Certificados por vencer</p>
            </div>
            <div class="col-md-3">
              <div class=""><h2><b>{{ $vencenPronto }}</b></h2></div>
            </div>
        </div>

    </div>



<!-- PROGRESO DEL TRAMITE -->

<div class="row progress-tramite">

<div class="col-md-12">

<div class="chart-card">

<h4><b>Progreso del proceso de certificación</b></h4>

<div class="progress">

<div class="progress-bar progress-bar-success" style="width:25%">
Solicitud enviada
</div>

<div class="progress-bar progress-bar-warning" style="width:25%">
Verificación
</div>

<div class="progress-bar progress-bar-info" style="width:25%">
Evaluación
</div>

<div class="progress-bar progress-bar-danger" style="width:25%">
Certificación
</div>

</div>

</div>

</div>

</div>



<!-- ACCIONES RAPIDAS -->

<div class="dashboard-actions">

        <h4><b>Acciones rápidas</b></h4>

        <div class="actions-grid">

            <a href="{{ route('empresa.solicitudes.create') }}" class="action-card">
                <i class="fa fa-plus-circle"></i>
                <p>Nueva Solicitud</p>
            </a>

            <a href="{{ route('empresa.solicitudes.index') }}" class="action-card">
                <i class="fa fa-list"></i>
                <p>Ver Solicitudes</p>
            </a>

            <a href="{{ route('manual') }}" class="action-card">
                <i class="fa fa-book"></i>
                <p>Manual de Usuario</p>
            </a>

            <a href="#" class="action-card">
                <i class="fa fa-file-pdf-o"></i>
                <p>Mis Certificados</p>
            </a>

        </div>

    </div>

</div>

<hr>

        <!-- BANER DE CURSOS -->

            <div class="row">

                <!-- BANNER CAPACITACIONES -->
                <div class="col-md-12">

                    <div class="banner-capacitaciones">

                        <div class="banner-contenido">

                            <!-- LADO IZQUIERDO -->
                            <div class="banner-texto">

                                <div class="banner-icono">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>

                                <h2>
                                    Capacitaciones FHB
                                </h2>

                                <p>
                                    Fortalece tus conocimientos y los de tu equipo
                                    mediante nuestros cursos de capacitación.
                                </p>

                                <a href="http://127.0.0.1:8001"
                                target="_blank"
                                class="btn btn-capacitaciones">

                                    <i class="fa fa-book"></i>
                                    Ver cursos disponibles

                                </a>

                            </div>


                            <!-- LADO DERECHO: CARRUSEL -->
                            <div class="banner-carrusel">

                                <div class="imagen-carrusel activa">
                                    <img src="{{ asset('img/cursos/curso1.jpg') }}"
                                        alt="Curso de capacitación">
                                </div>

                                <div class="imagen-carrusel">
                                    <img src="{{ asset('img/cursos/curso2.jpg') }}"
                                        alt="Curso de capacitación">
                                </div>

                                <div class="imagen-carrusel">
                                    <img src="{{ asset('img/cursos/curso3.jpg') }}"
                                        alt="Curso de capacitación">
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>





<!-- TABLA -->

<div class="row">

<div class="col-md-12">

<div class="chart-card">

<h4><b>Últimas solicitudes</b></h4>

<table class="table table-hover">

<thead>

<tr>
<th>Producto</th>
<th>Fecha</th>
<th>Estado</th>
</tr>

</thead>

<tbody>



<tr>

<td></td>

<td></td>

<td>


<span class="label label-success">Aprobado</span>



<span class="label label-warning">En revisión</span>



<span class="label label-danger">Rechazado</span>


</td>

</tr>


</tbody>

</table>

</div>

</div>

</div>


</div>



<!-- CHART JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>



/* CONTADOR ANIMADO */

const counters = document.querySelectorAll('.counter');

counters.forEach(counter => {

counter.innerText='0';

const update=()=>{

const target=+counter.getAttribute('data-target') || counter.innerText;

const c=+counter.innerText;

const increment=target/100;

if(c < target){

counter.innerText=`${Math.ceil(c + increment)}`;

setTimeout(update,20);

}else{

counter.innerText=target;

}

};

update();

});

</script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const imagenes = document.querySelectorAll(".imagen-carrusel");

    let actual = 0;

    if (imagenes.length > 1) {

        setInterval(function () {

            imagenes[actual].classList.remove("activa");

            actual++;

            if (actual >= imagenes.length) {
                actual = 0;
            }

            imagenes[actual].classList.add("activa");

        }, 4000);

    }

});

</script>



@endsection


