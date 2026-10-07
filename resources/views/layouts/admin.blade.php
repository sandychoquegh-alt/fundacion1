<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Foundation | www.fundacionhechobolivia.com</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/object1092908693.gif')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  </head>
 
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SAN</b>DY</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SISTEMA</b></span>
        </a>
         
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <small class="bg-red">En linía</small>
                  
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <p>
                      <span class="hidden-xs">{{ Auth::user()->nombre }} <p>Rol: {{ Auth::user()->rol_id }}</p></span>
                      <small>...</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="#" class="btn btn-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Cerrar sesión
                </a>
                      <button href="#" class="btn btn-default btn-flat">Cerrar</button>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

      @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

      <!-- Left side column. contains the logo and sidebar -->
    
      <aside class="main-sidebar">

          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">

              <!-- sidebar menu -->
              <ul class="sidebar-menu">

                  <li class="header"><b>SISTEMA - VAON</b></li>

                  <!-- INICIO -->
                  <li class="treeview">
                      <a href="{{ url('empresa/dashboard') }}">
                          <i class="fa fa-th"></i>
                          <span>INICIO</span>
                      </a>
                  </li>


                  <!-- GESTIÓN DE EMPRESAS -->
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-building"></i>
                          <span>GESTIÓN DE EMPRESAS</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">
                          <li>
                              <a href="{{ url('empresa/index') }}">
                                  <i class="fa fa-circle-o"></i>Empresas Registradas
                              </a>
                          </li>
                      </ul>
                  </li>


                  <!-- SOLICITUDES PENDIENTES -->
                  <li class="treeview">
                      <a href="{{ route('evaluador.solicitudes.index') }}">
                          <i class="fa fa-th"></i>
                          <span>SOLICITUDES RECEPCIONADAS</span>
                      </a>
                  </li>


                  <!-- SOLICITUDES -->
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-file-text"></i>
                          <span>SOLICITUDES</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">

                          <li>
                              <a href="{{ route('solicitudes.pendientes') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Recibidas
                              </a>
                          </li>

                          <li>
                              <a href="{{ route('solicitudes.aprobadas') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Aprobadas
                              </a>
                          </li>
                             <!--
                          <li>
                              <a href="{{ route('solicitudes.rechazadas') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Rechazadas
                              </a>
                          </li>-->

                      </ul>
                  </li>


                  <!-- CONTROL DE CERTIFICADOS -->
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-shield"></i>
                          <span>CONTROL DE CERT.</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">

                          <li>
                              <a href="{{ route('certificados.activos') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Activos
                              </a>
                          </li>

                          <li>
                              <a href="{{ route('certificados.vencidos') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Vencidos
                              </a>
                          </li>

                          <li>
                              <a href="{{ route('certificados.revocados') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Por expirar (Revocados)
                              </a>
                          </li>

                      </ul>
                  </li>


                  <!-- CERTIFICADOS PRE-APROBADOS 
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-file-text"></i>
                          <span>CERT. PRE-APROBADAS</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">

                          <li>
                              <a href="{{ route('solicitudes.pendientes') }}">
                                  <i class="fa fa-circle-o"></i>
                                  Pagadas
                              </a>
                          </li>

                          <li>
                              <a href="{{ route('solicitudes.aprobadas') }}">
                                  <i class="fa fa-circle-o"></i>
                                  No Pagadas
                              </a>
                          </li>

                      </ul>
                  </li>-->


                  <!-- =====================================================
                      MÓDULO CAPACITACIONES
                  ====================================================== 

                  <li class="treeview">

                      <a href="#">
                          <i class="fa fa-graduation-cap"></i>

                          <span>CAPACITACIONES</span>

                          <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">

                          <!-- IR AL PANEL DE CAPACITACIONES 
                          <li>
                              <a href="http://127.0.0.1:8001/admin/dashboard">

                                  <i class="fa fa-dashboard"></i>

                                  Panel de Capacitación

                              </a>
                          </li>

                          <!-- CURSOS -
                          <li>
                              <a href="http://127.0.0.1:8001/admin/cursos">

                                  <i class="fa fa-book"></i>

                                  Cursos

                              </a>
                          </li>

                          <!-- ESTUDIANTES 
                              <a href="http://127.0.0.1:8001/admin/usuariosNuevo">

                                  <i class="fa fa-users"></i>

                                  Estudiantes

                              </a>
                          </li>

                          <!-- INSCRIPCIONES -
                          <li>
                              <a href="http://127.0.0.1:8001/admin/inscripciones">

                                  <i class="fa fa-file-text-o"></i>

                                  Inscripciones

                              </a>
                          </li>

                      </ul>

                  </li>-->
                  <li>
                              <a href="{{ route('admin.evaluaciones') }}">

                                  <i class="fa fa-file"></i>

                                  Historial del Evaluador

                              </a>
                          </li>


                  <!-- ACCESO 
                  <li class="treeview">

                      <a href="#">

                          <i class="fa fa-users"></i>

                          <span>ACCESO HISTORIAL DEL EVALUA </span>

                          <i class="fa fa-angle-left pull-right"></i>

                      </a>

                      <ul class="treeview-menu">
                         <!--
                          <li>
                              <a href="configuracion/usuario">

                                  <i class="fa fa-circle-o"></i>

                                  Usuarios

                              </a>
                          </li>-

                          <li>
                              <a href="{{ route('admin.evaluaciones') }}">

                                  <i class="fa fa-file"></i>

                                  Historial del Evaluador

                              </a>
                          </li>

                      </ul>

                  </li>-->


                  <!-- AYUDA -->
                  <li>

                      <a href="#">

                          <i class="fa fa-plus-square"></i>

                          <span>Ayuda</span>

                          <small class="label pull-right bg-red">
                              PDF
                          </small>

                      </a>

                  </li>


                  <!-- ACERCA DE -->
                  <li>

                      <a href="#">

                          <i class="fa fa-info-circle"></i>

                          <span>Acerca De...</span>

                          <small class="label pull-right bg-yellow">
                              FB
                          </small>

                      </a>

                  </li>

              </ul>

          </section>

      </aside>


       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de VOAN</h3>
                   
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  	<div class="row">
	                  	<div class="col-md-12">
		                          <!--Contenido-->
                              <div class="container" style="width:100%;">
                                <casvas id="" style="height:70%;"></casvas>
                              </div>
                              @yield('contenido')
		                          <!--Fin Contenido-->
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

                           </div>
                        </div>
		                    
                  		</div>
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 0.0.1
        </div>
        <strong> &copy; 2025-2030 <a href="www.incanatoit.com"></a>.</strong> 
      </footer>


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


