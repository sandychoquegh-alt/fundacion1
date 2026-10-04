<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Panel Empresa | VAON</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.panel-notificaciones {
    position: fixed;
    top: 0;
    right: -350px; /* oculto */
    width: 320px;
    height: 40%;
    background: #ffffff;
    box-shadow: -2px 0 10px rgba(0,0,0,0.2);
    transition: right 0.3s ease;
    z-index: 9999;
    display: flex;
    flex-direction: column;
}

.panel-notificaciones.activo {
    right: 0; /* aparece */
}

.panel-header {
    padding: 15px;
    background: #343a40;
    color: #fff;
    display: flex;
    justify-content: space-between;
}

.panel-body {
    padding: 10px;
    overflow-y: auto;
    color: #0e0d0d;
}

.item-noti {
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
    padding-bottom: 8px;
}

.btn-link-verde {
    background: none;
    border: none;
    color: green;
    cursor: pointer;
    font-size: 12px;
}
</style>
    <style>
        body {
            background: #f4f6f9;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* Sidebar */
        .sidebar { /* Verde institucional más moderno */
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            padding-top: 25px;
            height: 100%;
        }

        .sidebar h4 {
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 25px;
            color: #fff;
        }

        .sidebar a {
            color: #e6e6e6;
            padding: 12px 20px;
            display: block;
            font-size: 15px;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background: #5f61613a;
            color: #fff;
            border-left: 3px solid #4b82c0ff;
        }

        /* Header */
        .main-header {
            background-color: #252b88ff !important;
            color: #fff;
            border-bottom: none;
        }

        .logo {
            background-color:  #3c6ea7ff!important;
            color: #fff !important;
        }

        .navbar-custom-menu .nav > li > a {
            color: #fff;
            font-weight: bold;
        }

        .box {
            border-radius: 10px;
            border-top: 3px solid #1a1b4dff;
        }

        footer {
            background: #1a1f4dff !important;
            color: white !important;
            padding: 15px;
            text-align: center;
        }

        .user-header {
            background: #1a4d2e !important;
        }

        .alert {
            border-radius: 12px;
        }
        .toast-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: #fff;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            z-index: 9999;
            font-weight: bold;
            opacity: 1;
            transition: opacity .5s ease, transform .5s ease;
        }


        #menu-certificados > .treeview-menu {
    display: none;
}

#menu-certificados.abierto > .treeview-menu {
    display: block;
}

#flecha-certificados {
    transition: transform 0.2s ease;
}

#menu-certificados.abierto #flecha-certificados {
    transform: rotate(-90deg);
}

/* =========================================
   SIDEBAR CONTRAÍDO - SOLO ICONOS
========================================= */

body.sidebar-collapse .main-sidebar {
    width: 50px !important;
}

body.sidebar-collapse .content-wrapper,
body.sidebar-collapse .main-footer {
    margin-left: 50px !important;
}

body.sidebar-collapse .main-header .navbar {
    margin-left: 50px !important;
}

/* Ocultar textos */
body.sidebar-collapse .main-sidebar .sidebar span,
body.sidebar-collapse .main-sidebar .sidebar h4 {
    display: none !important;
}

/* Centrar los iconos */
body.sidebar-collapse .main-sidebar .sidebar a {
    text-align: center !important;
    padding: 15px 5px !important;
}

/* Tamaño de iconos */
body.sidebar-collapse .main-sidebar .sidebar a i {
    margin: 0 !important;
    font-size: 18px;
}

/* Ocultar flechas de los menús */
body.sidebar-collapse .main-sidebar .pull-right {
    display: none !important;
}
    </style>
    

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- HEADER -->
   <header class="main-header">

    {{-- LOGO --}}
    <a href="#" class="logo">
        <span class="logo-mini">
            <b>V</b>N
        </span>

        <span class="logo-lg">
            <b>VAON</b> EMPRESAS
        </span>
    </a>


    {{-- NAVBAR --}}
    <nav class="navbar navbar-static-top">
       {{-- BOTÓN SIDEBAR --}}
         <a href="#" class="sidebar-toggle" data-toggle="offcanvas"  role="button"></a>

        {{-- MENÚ DERECHO --}}
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{-- NOTIFICACIONES --}}
                @auth
                <li class="nav-item dropdown">
                    <a id="btnNotificaciones" class="nav-link position-relative" href="javascript:void(0);">
                        <i class="fa-solid fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif

                    </a>
                </li>
                @endauth
                {{-- USUARIO --}}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs">
                            {{ Auth::user()->nombre }}
                        </span>
                    </a>
                    {{-- DROPDOWN USUARIO --}}
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p> <strong>
                                    {{ Auth::user()->nombre }}
                                </strong>
                                <br>
                                <small>
                                    Rol:
                                    {{ Auth::user()->rol_id }}
                                </small>
                            </p>

                        </li>
                        <li class="user-footer">
                            <form action="{{ route('logout') }}"
                                  method="POST">
                                @csrf
                                <button type="submit"  class="btn btn-danger btn-block">
                                    <i class="fa fa-sign-out"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    {{-- PANEL DE NOTIFICACIONES --}}
    <div id="panelNotificaciones" class="panel-notificaciones">
        <div class="panel-header">
            <strong>
                🔔 Notificaciones
            </strong>
            <span id="cerrarPanel"  style="cursor: pointer;">
                ✖
            </span>
        </div>
        <div class="panel-body">
            @forelse(
                auth()->user()->notifications->sortByDesc('created_at')
                as $notificacion
            )
                <div class="item-noti">
                    {{ $notificacion->data['mensaje'] }}
                </div>
            @empty
                <p> No tienes notificaciones. </p>
            @endforelse
        </div>
    </div>
</header>
    <!-- SIDEBAR -->
<aside class="main-sidebar" id="sidebarEmpresa">
        <section class="sidebar">
           
                <h4 class="text-center">Panel Empresa</h4>
                  <a href="{{ route('empresad.dashboard') }}">
                     <i class="fa fa-th"></i>
                     <span>Inicio</span>
                  </a>
                 <a href="{{ route('empresa.verificacion.anexoA') }}">
                     <i class="fa fa-pencil-square-o"></i>
                     <span>Llenar Anexo A</span>
                 </a>
                 <a href="{{ route('empresa.anexoB.carta') }}">
                     <i class="fa fa-file-text"></i>
                     <span>Llenar Anexo B</span>
                 </a>
                  <a href="{{ route('empresa.solicitudes.index') }}">
                     <i class="fa fa-file-text-o"></i>
                     <span>Realizar Solicitud</span>
                 </a>
                 

                    <li class="treeview" id="menu-certificados">

                      <a href="#" id="toggle-certificados">
                        <i class="fa fa-shield"></i>
                        <span>Mis Certificados</span>
                        <i class="fa fa-angle-left pull-right" id="flecha-certificados"></i>
                      </a>

                       <ul class="treeview-menu" id="submenu-certificados">

                       <li>
                       <a href="{{ route('empresa.certificados.pendientes') }}">
                       <i class="fa fa-clock-o"></i>
                        <span>Pendientes de pago</span>
                       </a>
                       </li>

                       <li>
                       <a href="{{ route('empresa.certificados') }}">
                        <i class="fa fa-certificate"></i>
                         <span>Certificados activos</span>
                        </a>
                       </li>

                        </ul>

                    </li>
               
                   <a href="{{ route('manual') }}">
                   <i class="fa fa-plus-square"></i> <span>Manual</span>
                   </a>
          
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"> <i class="fa fa-sign-out"></i> <span>Cerrar sesión</span> </a>
                </form>
            
        </section>
</aside>

<!-- CONTENT -->
<div class="content-wrapper">
<section class="content">
            <div class="box col-md-12">
                <div class=" col-md-12 box-header with-border ">
                    <h3 class="box-title">Panel de Empresa VAON DSCD</h3>
                     <!-- Aquí puedes ponerlo al inicio del contenido -->

                        <div class="container mt-3">
   

                           <!-- resto del contenido de la tabla de solicitudes -->
                        </div>
                <div>

                     @yield('contenido')
                     
                    @yield('js')

                    @yield('scripts')
                    @stack('scripts')

                     <!-- Toasts -->
                <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>


            </div>

                 


                </div>

            </div>
        </section>

    </div>

    <!-- FOOTER -->
    <footer class="main-footer">
        <strong>© 2025 - 2030 Sistema VAON | Todos los derechos reservados</strong>
    </footer>

</div>

<!-- Scripts -->
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
@stack('scripts')

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


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       NOTIFICACIONES
       ===================================================== */

    const btnNotificaciones =
        document.getElementById("btnNotificaciones");

    const panelNotificaciones =
        document.getElementById("panelNotificaciones");

    const cerrarPanel =
        document.getElementById("cerrarPanel");


    if (
        btnNotificaciones &&
        panelNotificaciones &&
        cerrarPanel
    ) {

        // Abrir / cerrar panel
        btnNotificaciones.addEventListener("click", function (e) {

            e.stopPropagation();

            panelNotificaciones.classList.toggle("activo");

        });


        // Cerrar con X
        cerrarPanel.addEventListener("click", function () {

            panelNotificaciones.classList.remove("activo");

        });


        // Evitar que el click dentro del panel lo cierre
        panelNotificaciones.addEventListener("click", function (e) {

            e.stopPropagation();

        });


        // Cerrar al hacer click fuera
        document.addEventListener("click", function () {

            panelNotificaciones.classList.remove("activo");

        });

    }



    /* =====================================================
       MENÚ MIS CERTIFICADOS
       ===================================================== */

    const menuCertificados =
        document.getElementById("menu-certificados");

    const toggleCertificados =
        document.getElementById("toggle-certificados");


    if (
        menuCertificados &&
        toggleCertificados
    ) {

        // Al cargar la página comienza cerrado
        menuCertificados.classList.remove("abierto");


        // Abrir / cerrar al hacer click
        toggleCertificados.addEventListener("click", function (e) {

            e.preventDefault();
            e.stopPropagation();

            menuCertificados.classList.toggle("abierto");

        });

    }

});

</script>


</body>
</html>




