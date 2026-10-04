@extends('layouts.admin')
<!--ESTO TAMBIEN LA ESTA USANDO EL ADMINISTRADO ES PARA EL ADMINISRADOR-->
@section('contenido')

<div class="container mt-4">
    <div class="row">
    <div class="col-md-6"> 
        <h3 class="mb-3"> Detalle de Solicitud #{{ $solicitud->id }} </h3>
         <a href="{{ route('evaluador.solicitudes.index') }}" class="btn btn-primary btn-sm mb-3" > ← </a> 
         <div class="card shadow"> 
            <div class="card-body"> 
                <!-- INFORMACIÓN DE LA EMPRESA --> 
                 <h4 class="text-primary"> Información de la Empresa </h4> 
                 <p> <b>Nombre:</b> {{ $solicitud->empresa->razon_social ?? 'N/A' }} </p> 
                 <p> <b>Correo:</b> {{ $solicitud->empresa->email ?? 'N/A' }} </p> 
                 <hr> 
                 <!-- DATOS DE LA SOLICITUD --> 
                  <h4 class="text-primary"> Datos de la Solicitud </h4> 
                  <strong>Productos:</strong>
</p>

@if($solicitud->productos->count() > 0)

    <ul class="mb-3">
        @foreach($solicitud->productos as $producto)
            <li>
                {{ $producto->nombre }}
            </li>
        @endforeach
    </ul>

@else

    <p class="text-muted">
        No hay productos registrados.
    </p>

@endif
                  <p> <b>Marca:</b> {{ $solicitud->marca }} </p> 
                  <p> <b>Descripción:</b> {{ $solicitud->descripcion }} </p> 
                  <hr> 
                  <!-- ARCHIVOS CARGADOS --> 
                   <h4 class="text-primary"> Archivos Cargados </h4> 
                   <!-- DECLARACIÓN JURADA --> 
                    <p class="mt-3"> <b>Declaración Jurada:</b> </p> 
                    @php $declaracion = $solicitud->documentos ->where('tipo', 'declaracion') ->first(); @endphp @if($declaracion) 
                    <li class="list-group-item d-flex justify-content-between align-items-center"> 
                        <span> {{ $declaracion->nombre_original }} </span> 
                        <div> 
                            <a href="{{ asset('storage/'.$declaracion->ruta) }}" target="_blank" class="btn btn-primary btn-sm"> 
                            Ver 
                            </a> 
                            <a href="{{ asset('storage/'.$declaracion->ruta) }}" download class="btn btn-success btn-sm"> 
                            Descargar 
                            </a> 
                        </div> 
                    </li> 
                    @else 
                    <p>No subido</p> 
                    @endif 
                    <!-- ANEXO B --> 
                     <p class="mt-3"> 
                        <b>Documento del Anexo B:</b> 
                     </p> 
                     @php $respaldos = $solicitud->documentos ->where('tipo', 'respaldo'); @endphp @if($respaldos->count()) @foreach($respaldos as $respaldo) 
                     <li class="list-group-item d-flex justify-content-between align-items-center"> 
                        <span> {{ $respaldo->nombre_original }} </span> 
                        <div> 
                            <a href="{{ url('storage/'.$respaldo->ruta) }}" target="_blank" class="btn btn-primary btn-sm"> 
                            Ver 
                            </a> 
                            <a href="{{ url('storage/'.$respaldo->ruta) }}" download="{{ $respaldo->nombre_original }}" class="btn btn-success btn-sm"> 
                            Descargar 
                            </a> 
                        </div> 
                     </li> 
                     @endforeach 
                     @else 
                     <p>No se subieron respaldos.</p> 
                     @endif 
                     <!-- DIAGRAMA --> 
                      <p class="mt-3"> <b>Diagrama:</b> </p> 
                      @php $diagrama = $solicitud->documentos ->where('tipo', 'diagrama') ->first(); @endphp @if($diagrama) 
                      <li class="list-group-item d-flex justify-content-between align-items-center"> 
                        <span> {{ $diagrama->nombre_original }} </span> 
                        <div> 
                            <a href="{{ url('storage/'.$diagrama->ruta) }}" target="_blank" class="btn btn-primary btn-sm"> 
                                Ver archivo 
                            </a> 
                            <a href="{{ url('storage/'.$diagrama->ruta) }}" download class="btn btn-success btn-sm"> 
                                Descargar 
                            </a> 
                        </div> 
                      </li> @else <p>No subido</p> 
                      @endif 
                      <!-- ================================================= --> 
                       <!-- IMÁGENES DEL PRODUCTO --> 
                        <!-- ================================================= --> 
                         <p class="mt-3"> <b>Imágenes del Producto:</b> 
                         </p> 
                         @php $imagenes = $solicitud->documentos ->where('tipo', 'imagen') ->values(); @endphp @if($imagenes->count() > 0) 
                         <div class="list-group"> 
                            <div class="list-group-item d-flex justify-content-between align-items-center"> 
                                <span> <i class="fa-solid fa-images"></i> 
                                {{ $imagenes->count() }} {{ $imagenes->count() == 1 ? 'imagen del producto' : 'imágenes de los productos' }} 
                               </span> 
                               <!-- SOLO SE MUESTRA ESTE BOTÓN --> 
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalImagenesProducto"> 
                                    <i class="fa fa-eye"></i> Ver imágenes 
                                </button> 
                            </div> 
                          </div> 
                          <!-- ================================================= --> 
                           <!-- MODAL DE IMÁGENES -->
                             <!-- ================================================= --> 
                              <div class="modal fade" id="modalImagenesProducto" tabindex="-1" role="dialog" aria-labelledby="modalImagenesProductoLabel" aria-hidden="true"> 
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> 
                                    <div class="modal-content"> 
                                        <!-- CABECERA --> 
                                         <div class="modal-header bg-primary text-white"> 
                                            <h5 class="modal-title" id="modalImagenesProductoLabel"> 
                                                <i class="fa fa-images"></i> 
                                                Imágenes de los productos 
                                            </h5> 
                                            <button type="button" class="close text-white" data-dismiss="modal"> 
                                                <span>&times;</span> 
                                            </button> 
                                        </div> 
                                        <!-- CUERPO --> 
                                         <div class="modal-body text-center"> 
                                            <!-- CONTADOR --> <div class="mb-3"> 
                                                <span id="contador-imagen" class="badge badge-secondary"> 
                                                    1 de {{ $imagenes->count() }} imágenes 
                                                </span> 
                                         </div> 
                                         <!-- IMAGEN --> 
                                          <div> 
                                            <img id="imagen-producto" src="{{ asset('storage/' . $imagenes[0]->ruta) }}" 
                                            alt="Imagen del producto" 
                                            style=" max-width: 100%; max-height: 500px; object-fit: 
                                            contain; border-radius: 10px; border: 1px solid #ddd; padding: 5px; "> 
                                          </div> 
                                          <!-- NOMBRE --> 
                                           <p id="nombre-imagen" class="mt-3"> 
                                            <strong> {{ $imagenes[0]->nombre_original }} </strong> 
                                           </p> 
                                           <!-- ANTERIOR / SIGUIENTE --> 
                                            <div class="d-flex justify-content-center mt-3"> 
                                                <button type="button" id="btn-anterior" class="btn btn-secondary mr-2" disabled> 
                                                    <i class="fa fa-chevron-left"></i> 
                                                    Anterior 
                                                </button> 
                                                <button type="button" id="btn-siguiente" class="btn btn-primary"> 
                                                    Siguiente 
                                                    <i class="fa fa-chevron-right"></i> 
                                                </button> 
                                            </div> 
                                        </div> 
                                        <!-- PIE --> 
                                         <div class="modal-footer"> 
                                            <a id="btn-descargar-imagen" href="{{ asset('storage/' . $imagenes[0]->ruta) }}" 
                                            download="{{ $imagenes[0]->nombre_original }}" class="btn btn-success"> 
                                              <i class="fa fa-download"></i> 
                                              Descargar imagen 
                                            </a> 
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> 
                                                Cerrar 
                                            </button> 
                                          </div> 
                                        </div> 
                                    </div> 
                                </div> 
                                <!-- ================================================= --> 
                                 <!-- JAVASCRIPT --> 
                                  <!-- ================================================= --> 
                                   <script> document.addEventListener('DOMContentLoaded', 
                                        function () { const imagenes = @json( $imagenes->map(function ($imagen)
                                         { return [ 'ruta' => asset('storage/' 
                                          . $imagen->ruta), 'nombre' => $imagen->nombre_original ]; 
                                          })->values() ); let indiceActual = 0;
                                           const imagen = document.getElementById('imagen-producto'); 
                                           const contador = document.getElementById('contador-imagen'); 
                                           const nombre = document.getElementById('nombre-imagen'); 
                                           const btnAnterior = document.getElementById('btn-anterior');
                                            const btnSiguiente = document.getElementById('btn-siguiente'); 
                                            const btnDescargar = document.getElementById('btn-descargar-imagen'); 
                                            function mostrarImagen(indice) { if (!imagenes[indice]) { return; } 
                                            const archivo = imagenes[indice]; imagen.src = archivo.ruta; 
                                            nombre.innerHTML = '<strong>' + archivo.nombre + '</strong>'; 
                                            contador.textContent = (indice + 1) + ' de ' + imagenes.length + ' imágenes'; 
                                            btnDescargar.href = archivo.ruta; btnDescargar.setAttribute( 'download', 
                                            archivo.nombre ); btnAnterior.disabled = indice === 0; 
                                            btnSiguiente.disabled = indice === imagenes.length - 1; } 
                                            btnAnterior.addEventListener( 'click', function () { if (indiceActual > 0) 
                                            { indiceActual--; mostrarImagen(indiceActual); } } );
                                             btnSiguiente.addEventListener( 'click', function () 
                                             { if ( indiceActual < imagenes.length - 1 ) 
                                             { indiceActual++; mostrarImagen(indiceActual); } } ); 
                                                 $('#modalImagenesProducto').on( 'show.bs.modal', 
                                                 function () { indiceActual = 0; mostrarImagen(indiceActual); } ); }); 
                                                 </script> @else <div class="alert alert-warning"> 
                                                    <i class="fa fa-image"></i> 
                                                    No se han subido imágenes del producto. 
                                                </div> @endif 
             </div> 
                                        
         </div> 
    </div> 
                                    
    <!-- COLUMNA DERECHA -->
    <div class="col-md-6">
            
                  <hr> 
                  <!-- COMENTARIO AL SOLICITANTE --> 
                   <form action="{{ route('solicitud.comentario.enviar') }}" method="POST"> @csrf 
                    <label> <strong>Añadir comentario si le faltó algún documento al solicitante</strong> 
                    </label> <textarea name="descripcion" class="form-control" required> 

                    </textarea> <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}" > 
                       <button class="btn btn-primary mt-2"> 
                           Enviar comentario 
                        </button> 
                    </form> 
                    <!-- FIN COMENTARIO --> 
                     <hr class="my-4"> 
                     <!-- ASIGNAR EVALUADOR Y CAMBIAR ESTADO --> 
                      <form action="{{ route('evaluador.solicitudes.cambiarEstado', $solicitud->id) }}" method="POST"> 
                        @csrf 
                        <label> <strong>Asignar a un Evaluador:</strong> 
                        </label> <select name="evaluador_id" class="form-control"> 
                            <option value="">-- Seleccionar Evaluador--</option> 
                            @foreach($evaluadores as $eval) 
                            <option value="{{ $eval->id }}"> 
                                {{ $eval->nombre }} 
                            </option> @endforeach </select> 
                            <hr>
                            <label class="mt-3"> 
                                <strong>Cambiar Estado: </strong> 
                                <p>Aprobado(generacion de certificado)</p>
                                <p>En revision (enviar a un evaluador)</p>
                            </label> 
                            <select name="estado" class="form-control"> 
                                <option value="Pendiente" {{ $solicitud->estado == 'Pendiente' ? 'selected' : '' }}> Pendiente </option> 
                                <option value="en_revision" {{ $solicitud->estado == 'en_revision' ? 'selected' : '' }}> En Revisión </option> 
                                <option value="Aprobado" {{ $solicitud->estado == 'Aprobado' ? 'selected' : '' }}> Aprobado </option> 
                                <option value="Rechazado" {{ $solicitud->estado == 'Rechazado' ? 'selected' : '' }}> Rechazado </option> 
                            </select> 
                            <button class="btn btn-primary mt-2"> Guardar Cambios </button> 
                            <a href="{{ route('evaluador.solicitudes.index') }}" class="btn btn-secondary mt-2"> 
                                Volver 
                            </a> 
                    </form> 
                        <!-- FIN ASIGNAR EVALUADOR -->
           
    </div>

    </div>
</div>
@endsection
<!--esto es para el mensaje que sde envio al usuario((empres))-->
@if(session('success'))
    <div id="alerta-flotante"
         style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            font-weight: 500;
            opacity: 1;
            transition: opacity 0.5s ease;
         ">
         {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            let alerta = document.getElementById('alerta-flotante');
            alerta.style.opacity = '0';

            setTimeout(function() {
                alerta.remove();
            }, 500);

        }, 5000); // desaparece después de 3 segundos
    </script>
@endif