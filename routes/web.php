<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\Auth\RegistroEmpresaController;


/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Mostrar login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

// Procesar login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.post');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| REGISTRO (General y Empresas)
|--------------------------------------------------------------------------
*/

// Registro general
Route::get('/register', [RegisterController::class, 'showForm'])
    ->name('register.form');

// Registro de empresa
Route::get('/empresa/register', [RegistroEmpresaController::class, 'showForm'])
    ->name('empresa.registrar');

Route::post('/empresa/register', [RegistroEmpresaController::class, 'registrar'])
    ->name('empresa.registrar.store');


/*
|--------------------------------------------------------------------------
| DASHBOARDS POR ROL
|--------------------------------------------------------------------------
*/

// Dashboard Admin
Route::middleware(['auth', 'no.cache'])->group(function () {

    // ADMIN
Route::get('/empresa/dashboard', [App\Http\Controllers\Admin\DashboardController::
class, 'index'])
->name('empresa.dashboard');
      // EVALUADOR
   Route::get('/evaluador/dashboard', function () {
    return view('layouts.evaluador');
})->name('evaluador.dashboard');
    // EMPRESA
  Route::get('/empresad/dashboard', [App\Http\Controllers\Empresa\DashboardController::
  class, 'index'])
    ->name('empresad.dashboard');


});









/*
|--------------------------------------------------------------------------
| EMPRESAS (CRUD)
|--------------------------------------------------------------------------
*/

Route::resource('empresas', EmpresaController::class);

Route::get('empresas/list', [EmpresaController::class, 'list'])
    ->name('empresas.list');

Route::put('empresas/restore/{id}', [EmpresaController::class, 'restore'])
    ->name('empresas.restore');


/*
|--------------------------------------------------------------------------
| CERTIFICADOS
|--------------------------------------------------------------------------
*/

Route::get('/empresas/{id}/certificado', [CertificadoController::class, 'create'])
    ->name('empresas.certificado');

Route::post('/certificados', [CertificadoController::class, 'store'])
    ->name('certificados.store');

Route::post('/certificados/preview', [CertificadoController::class, 'preview'])
    ->name('certificados.preview');


/*
|--------------------------------------------------------------------------
| SOLICITUDES (Solo empresa)
|--------------------------------------------------------------------------
*/
// Grupo para empresas


// Panel empresa

Route::prefix('empresa/solicitudes')->name('empresa.solicitudes.')->group(function () {
    Route::get('/', [SolicitudController::class, 'index'])->name('index');
    Route::get('/crear', [SolicitudController::class, 'create'])->name('create');
    Route::post('/', [SolicitudController::class, 'store'])->name('store');
    Route::delete('/{id}', [SolicitudController::class, 'destroy'])->name('destroy');
});



 Route::get('/empresa/solicitudes', [SolicitudController::class, 'index'])
        ->name('empresa.solicitudes.index');
Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('empresa.solicitudes.index');



    Route::get('/empresa/solicitudes/crear', [SolicitudController::class, 'create'])
        ->name('empresa.solicitudes.create');

    Route::post('/empresa/solicitudes', [SolicitudController::class, 'store'])
        ->name('empresa.solicitudes.store');
Route::delete('empresa/solicitudes/{solicitud}', [SolicitudController::class, 'destroy'])->name('empresa.solicitudes.destroy');



// EVALUADOR – Solicitudes







    



//no mover esto
    Route::get('/evaluador/dashboard', [App\Http\Controllers\Evaluador\DashboardController::class, 'index'])
    ->name('evaluador.dashboard');
    Route::get('/evaluador/historial', 
    [App\Http\Controllers\Evaluador\HistorialController::class, 'index']
)->name('evaluador.historial');


Route::get('/solicitud', [App\Http\Controllers\Evaluador\SolicitudController::class, 'index'])
        ->name('evaluador.solicitud');

    Route::get('/solicitud/{id}', [App\Http\Controllers\Evaluador\SolicitudController::class, 'show'])
        ->name('evaluador.solicitud.show');




Route::get('/evaluador/solicitudes', [App\Http\Controllers\Evaluador\SolicitudEvalController::class, 'index'])
    ->name('evaluador.solicitudes.index');

Route::get('/evaluador/solicitudes/{id}', [App\Http\Controllers\Evaluador\SolicitudEvalController::class, 'show'])
    ->name('evaluador.solicitudes.show');

Route::post('/evaluador/solicitudes/{id}/cambiar-estado', [App\Http\Controllers\Evaluador\SolicitudEvalController::class, 'cambiarEstado'])
    ->name('evaluador.solicitudes.cambiarEstado');

use App\Http\Controllers\Evaluador\EvaluadorController;

Route::prefix('evaluador')->name('evaluador.')->group(function() {
    Route::get('/historial', [App\Http\Controllers\Evaluador\EvaluadorController::class, 'historial'])
        ->name('historial');
});

Route::post('/evaluador/enviar-informe/{id}', 
    [\App\Http\Controllers\Evaluador\SolicitudController::class, 'enviar'])
    ->name('evaluador.enviar.informe');
    Route::post('/evaluador/guardar-evaluacion/{id}', [\App\Http\Controllers\Evaluador\SolicitudController::class, 'guardar'])
    ->name('evaluador.guardar.evaluacion');

    Route::get('/evaluacion/{id}/detalle', 
[\App\Http\Controllers\Evaluador\SolicitudController::class, 'verDetalle'])
->name('evaluador.ver.detalle');


Route::post('/evaluador/evaluacion/{id}/enviar-admin', 
    [\App\Http\Controllers\Evaluador\SolicitudController::class, 'enviarAdmin']
)->name('evaluador.enviar.admin');

//es para hacer las visitas o agenda



Route::get('/evaluador/visitas', 
[\App\Http\Controllers\Evaluador\VisitaController::class, 'visitas'])
->name('evaluador.visitas');

Route::get('/evaluador/agenda', 
    [\App\Http\Controllers\Evaluador\VisitaController::class, 'index']
)->name('evaluador.agenda');

// Guardar visita

     Route::post('/visitas', [\App\Http\Controllers\Evaluador\VisitaController::class, 'store'])
        ->name('visitas.store');

    // Obtener visitas en JSON para FullCalendar
    Route::get('/visitas-json', [\App\Http\Controllers\Evaluador\VisitaController::class, 'json'])
        ->name('visitas.json');

    // Ver detalle visita
    Route::get('/visita/{id}', [\App\Http\Controllers\Evaluador\VisitaController::class, 'show'])
        ->name('visitas.show');


Route::post('/evaluador/visitas/{id}/reprogramar', 
    [\App\Http\Controllers\Evaluador\VisitaController::class, 'reprogramar']
)->name('evaluador.visitas.reprogramar');
        

//Rutas del administrador

Route::prefix('empresa')->group(function () {

    // Listar empresas
    Route::get('index', [EmpresaController::class, 'index'])
        ->name('empresa.index');

    // Crear nueva empresa (formulario)
    Route::get('create', [EmpresaController::class, 'create'])
        ->name('empresa.create');

    // Guardar nueva empresa (POST del formulario)
    Route::post('store', [EmpresaController::class, 'store'])
        ->name('empresa.store');
});



//rutas para las solicitudes de pendiente , aprobado, rechazado

    // Solicitudes Pendientes
    Route::get('/empresa/solicitudes/pendiente',[App\Http\Controllers\Empresa\SolicitudController::class, 'pendientes'])
        ->name('solicitudes.pendientes');

    // Solicitudes Aprobadas
    Route::get('/empresa/solicitudes/aprobadas',[App\Http\Controllers\Empresa\SolicitudController::class, 'aprobadas'])
        ->name('solicitudes.aprobadas');

    Route::get('/empresa/solicitudes/{id}', [App\Http\Controllers\Empresa\SolicitudController::class, 'show'])
    ->name('empresa.solicitudes.show');

    // Solicitudes Rechazadas
    Route::get('/empresa/solicitudes/rechazadas', [App\Http\Controllers\Empresa\SolicitudController::class, 'rechazadas'])
        ->name('solicitudes.rechazadas');

// Generar certificado PDF con QR
Route::get('/certificados/certificado/{id}', [App\Http\Controllers\Empresa\SolicitudController::class, 'generarCertificado'])
    ->name('certificados.certificado');

  

Route::get('/certificados/certificado/{id}', 
    [SolicitudController::class, 'generarCertificado']
)->name('certificados.certificado');



    Route::post('/certificados/generar', [\App\Http\Controllers\CertificadoController::class, 'generar'])
    ->name('certificados.generar');



    //--------------------------------------------------------------------------------
    //es para la verificaion si realmete existe el certificado

Route::get('/certificados/verificar/{codigo}', [\App\Http\Controllers\CertificadoController::class, 'verificar'])
     ->name('certificados.verificar');


Route::get('/certificados/verificar/buscar', [CertificadoController::class, 'verificarBuscar'])
    ->name('certificados.verificar.buscar');

    // Ruta pública para ver el certificado final
Route::get('/certificados/ver/{id}', [CertificadoController::class, 'ver'])
    ->name('certificados.ver');





 Route::get('/certificados/activos', [CertificadoController::class, 'activos'])->name('certificados.activos');
 Route::post('/certificados/{id}/estado', [
    CertificadoController::class,
    'cambiarEstado'
])->name('certificados.estado');

    Route::get('certificados/vencidos', [CertificadoController::class, 'vencidos'])->name('certificados.vencidos');

    Route::get('certificados/revocados', [CertificadoController::class, 'revocados'])->name('certificados.revocados');

    Route::get('certifcados/{id}/ver', [CertificadoController::class, 'show'])->name('show');

    Route::post('certificados/{id}/revocar', [CertificadoController::class, 'revocar'])->name('revocar');

    Route::post('certificados/{id}/activar', [CertificadoController::class, 'activar'])->name('activar');


//EL ADMINISTRADOR PUEDE VER EL HISTORIAL DEL EVALUADOR

Route::get('/admin/evaluaciones', 
[\App\Http\Controllers\Admin\EvaluacionController::class, 'index'])
->name('admin.evaluaciones');
Route::get('/admin/evaluaciones/{id}', 
[\App\Http\Controllers\Admin\EvaluacionController::class, 'ver'])
->name('admin.evaluaciones.ver');

Route::post('/admin/evaluaciones/{id}/aprobar', 
[\App\Http\Controllers\Admin\EvaluacionController::class, 'aprobar'])
->name('admin.evaluaciones.aprobar');

Route::post('/admin/evaluaciones/{id}/rechazar', 
[\App\Http\Controllers\Admin\EvaluacionController::class, 'rechazar'])
->name('admin.evaluaciones.rechazar');


// FORMULARIO
Route::get('/empresa/verificacion', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'formAnexoA']
)->name('empresa.verificacion.anexoA');

// GUARDAR
Route::post('/empresa/verificacion', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'storeAnexoA']
)->name('empresa.verificacion.anexoA.store');

// MOSTRAR
Route::get('/empresa/verificacion/{id}', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'show']
)->name('empresa.verificacion.show');

// EDITAR
Route::get('/empresa/verificacion/{id}/editar', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'edit']
)->name('empresa.verificacion.edit');

// ACTUALIZAR
Route::post('/empresa/verificacion/{id}/actualizar', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'update']
)->name('empresa.verificacion.update');

// DESCARGAR PDF
Route::get('/empresa/verificacion/{id}/descargar', 
    [App\Http\Controllers\Empresa\VerificacionController::class, 'downloadPDF']
)->name('empresa.verificacion.pdf');





// ANEXO B – Carta
Route::get('/empresa/anexoB/carta', [App\Http\Controllers\Empresa\AnexoBController::class, 'cartaForm'])
    ->name('empresa.anexoB.carta');

Route::post('/empresa/anexoB/carta', [App\Http\Controllers\Empresa\AnexoBController::class, 'cartaStore'])
    ->name('empresa.anexoB.carta.store');

// ANEXO B – VAON
Route::get('/empresa/anexoB/carta', [App\Http\Controllers\Empresa\AnexoBController::class, 'vaonForm'])
    ->name('empresa.anexoB.carta');

Route::post('/empresa/anexoB/carta', [App\Http\Controllers\Empresa\AnexoBController::class, 'vaonStore'])
    ->name('empresa.anexoB.carta.store');



    Route::post('/empresa/anexoB/carta/anexoB', [App\Http\Controllers\Empresa\AnexoBController::class, 'generarPdf'])
    ->name('empresa.anexoB.anexoB-pdf');


Route::get('/empresa/certificados', [App\Http\Controllers\Empresa\CertificadoController::class,
    'index'
])->name('empresa.certificados');

Route::get('/empresa/certificados/pendientes', [App\Http\Controllers\Empresa\CertificadoController::class,
    'pendientes'
])->name('empresa.certificados.pendientes');

Route::get('/empresa/certificados/{id}', [App\Http\Controllers\Empresa\CertificadoController::class,
    'show'
])->name('empresa.certificados.show');

Route::get('/empresa/certificados/{id}/ver', [App\Http\Controllers\Empresa\CertificadoController::class,
    'ver'
])->name('empresa.certificados.ver');

Route::get('/empresa/certificados/{id}/descargar', [App\Http\Controllers\Empresa\CertificadoController::class,
    'descargar'
])->name('empresa.certificados.descargar');
/// es para enviar el mensaje al solicitante si le falto algun documento 

//Route::post('/evaluador/solicitud/comentario/enviar', [App\Http\Controllers\SolicitudEvalController::class, 'enviarComentario'])
 //   ->name('evaluador.solicitud.comentario.enviar');

/// ESTO ES PARA EL SITIO WEB PAGINA DE LOS CURSOS



//Route::post('/comentario/enviar', [SolicitudEvalController::class, 'enviarComentario'])
  //  ->name('solicitud.comentario.enviar');


Route::post('/comentario/enviar', [SolicitudController::class, 'enviarComentario'])
    ->name('solicitud.comentario.enviar');


Route::post('/notificacion/{id}/leer',
    [App\Http\Controllers\NotificacionController::class, 'marcarLeida'])
    ->name('notificacion.leer');

    
Route::get('/manual', function () {
    return view('solicitudes.manual');
})->name('manual');


  // 📌 Historial del evaluador
    Route::get('/historial', 
        [App\Http\Controllers\Evaluador\EvaluadorController::class, 'historial']
    )->name('evaluador.historial');