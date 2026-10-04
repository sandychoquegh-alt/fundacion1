@extends('layouts.admin')

@section('contenido')
<!-- este dashboard lo ve el administrador en su pantalla principal -->
<!-- Content Header -->
<section class="content-header">
    <h1>
        Panel Principal
        <small>Resumen General</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <!-- TARJETA 1 -->
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalEmpresas }}</h3>
                    <p>Empresas Registradas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building"></i>
                </div>
                <a href="{{ url('empresas') }}" class="small-box-footer">
                    Más información <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- TARJETA 2 -->
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $solicitudesPendientes }}</h3>
                    <p>Solicitudes Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <a href="{{ url('../evaluador/solicitudes') }}" class="small-box-footer">
                    Revisar <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- TARJETA 3 -->
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                 <h3>{{ $solicitudesRecibidas }}</h3>
                 <p>Solicitudes Recibidas</p>
              </div>
           <div class="icon">
               <i class="fa fa-inbox"></i>
           </div>
             <a href="{{ route('solicitudes.pendientes') }}" class="small-box-footer">
               Ver Solicitudes <i class="fa fa-arrow-circle-right"></i>
              </a>
           </div>
        </div>

        <!-- TARJETA 4 -->
        <div class="col-lg-2 col-xs-6">
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>{{ $certificadosActivos }}</h3>
            <p>Certificados Activos</p>
        </div>
        <div class="icon">
            <i class="fa fa-shield"></i>
        </div>
        <a href="{{ url('certificados/activos') }}" class="small-box-footer">
            Ver Certificados <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
        <!-- TARJETA 5 -->
        <div class="col-lg-2 col-xs-6">
    <div class="small-box bg-orange">
        <div class="inner">
            <h3>{{ $certificadosPorVencer }}</h3>
            <p>Por Vencer (45 días)</p>
        </div>
        <div class="icon">
            <i class="fa fa-exclamation-triangle"></i>
        </div>
        <a href="{{ route('certificados.revocados') }}" class="small-box-footer">
            Ver Certificados <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

        <!-- TARJETA 6 -->
       
       <div class="col-lg-2 col-xs-6">
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{ $certificadosVencidos }}</h3>
            <p>Certificados Vencidos</p>
        </div>
        <div class="icon">
            <i class="fa fa-ban"></i>
        </div>
        <a href="{{ url('certificados/vencidos') }}" class="small-box-footer">
            Ver Certificados <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
       
        

    </div>
    

    <!-- GRÁFICO -->
    <div class="row">
        <section class="col-lg-12 connectedSortable">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Gráfico de Solicitudes Mensuales</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
    <canvas id="chartSolicitudes" style="height:300px;"></canvas>
</div>
            </div>

        </section>
    </div>

    <!-- ÚLTIMAS SOLICITUDES -->
    <div class="row">
        <section class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Últimas Solicitudes Registradas</h3>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                
                                <th>Empresa</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($ultimasSolicitudes as $s)
                                <tr>
                                    
                                    <td>{{ $s->empresa->razon_social }}</td>
                                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($s->estado=='Aprobada') bg-green
                                            @elseif($s->estado=='Rechazada') bg-red
                                            @else bg-yellow @endif">
                                            {{ $s->estado }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </section>
    </div>

</section>

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(){

let ctx = document.getElementById('chartSolicitudes');

if(ctx){

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($meses),
        datasets: [{
            label: 'Solicitudes',
            data: @json($cantidadPorMes),
            borderColor: '#3c8dbc',
            backgroundColor: 'rgba(60,141,188,0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false
    }

});

}

});
</script>
@endsection