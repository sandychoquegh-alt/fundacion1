<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Foundation | www.fundacionhechobolivia.com')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/object1092908693.gif') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
   



    @stack('styles') <!-- Estilos adicionales -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    <header class="main-header">
        <a href="index2.html" class="logo">
            <span class="logo-mini"><b>SAN</b>DY</span>
            <span class="logo-lg"><b>SISTEMA</b></span>
        </a>

        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Navegación</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <small class="bg-red">En línea</small>
                            
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                 <span class="hidden-xs">{{ Auth::user()->nombre }} <p>Rol: {{ Auth::user()->rol_id }}</p></span>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('login') }}" class="btn btn-danger">Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header">PANEL DEL EVALUADOR</li>
                <li class="treeview">
                     <a href="{{ route('evaluador.dashboard') }}"><i class="fa fa-th"></i>  <span>INICIO</span></a>
                </li>
              

<li class="treeview">
    <a href="{{ route('evaluador.solicitud') }}">
        <i class="fa fa-folder-open"></i>
        <span>Solicitudes Asignadas</span>
    </a>
</li>

<li class="treeview">
    <a href="">
        <i class="fa fa-check-square-o"></i>
        <span>Evaluaciones</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
                 <li><a href=""><i class="fa fa-circle-o"></i> Aprobadas </a></li>
                 <li><a href=""><i class="fa fa-circle-o"></i> Rechazadas</a></li>
                 <li><a href=""><i class="fa fa-circle-o"></i> Pendientes</a></li>
                 <li><a href=""><i class="fa fa-circle-o"></i> Observadas</a></li>
                 
    </ul>




<li class="treeview">
    <a href="">
        <i class="fa fa-calendar"></i>
        <span>Visitas Programadas</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
                 <li><a href="{{ route('evaluador.agenda') }}"><i class="fa fa-circle-o"></i>Agendar Visitas </a></li>
                 <li><a href="{{ route('evaluador.visitas') }}"><i class="fa fa-circle-o"></i> Ver Visitas Programadas</a></li>
                 
    </ul>
</li>

<li class="treeview">
    <a href="{{ route('evaluador.historial') }}">
        <i class="fa fa-history"></i>
        <span>Historial de Evaluaciones</span>
    </a>
</li>

<li class="treeview">
    <a href="">
        <i class="fa fa-user"></i>
        <span>Perfil</span>
    </a>
</li>


   
                
                 
                <!-- Resto de menú según tu código -->
            </ul>
        </section>
    </aside>

    <!-- Contenido principal -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content') <!-- Aquí van las vistas hijas -->
            
            @yield('js')
            @yield('scripts')



             <!-- Toasts -->
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
function showToast(message, type = 'success') {
    const colors = {
        success: '#4BB543',
        error: '#FF4C4C',
        info: '#2196F3',
        warning: '#FFAA00'
    };

    const toast = document.createElement('div');
    toast.innerText = message;
    toast.style.background = colors[type] || colors.info;
    toast.style.color = 'white';
    toast.style.padding = '12px 20px';
    toast.style.marginTop = '10px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
    toast.style.fontFamily = 'Arial, sans-serif';
    toast.style.fontSize = '1.5rem';
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.5s, transform 0.5s';
    toast.style.transform = 'translateX(100%)';

    document.getElementById('toast-container').appendChild(toast);

    // Animación de entrada
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }, 50);

    // Desaparece después de 4 segundos
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

// Mostrar toast desde Laravel Session
@foreach (['success', 'error', 'info', 'warning'] as $msg)
    @if(session($msg))
        showToast("{{ session($msg) }}", "{{ $msg }}");
    @endif
@endforeach
</script>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 0.0.1
        </div>
        <strong> &copy; 2025-2030 <a href="www.incanatoit.com"></a>.</strong> 
    </footer>

</div>


<!-- jQuery (debe ir primero) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap (usa el que viene con AdminLTE) -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- AdminLTE (después de Bootstrap) -->
<script src="{{ asset('js/app.min.js') }}"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- Scripts personalizados de las vistas -->
@stack('scripts')

<script>
    $(document).ready(function() {
        console.log("✅ jQuery, Bootstrap, AdminLTE y DataTables cargados correctamente");
    });
</script>



</body>
</html>