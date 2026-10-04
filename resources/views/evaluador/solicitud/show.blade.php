@extends('layouts.evaluador')

@section('content')

<style>

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.55);
backdrop-filter:blur(3px);
align-items:center;
justify-content:center;
z-index:9999;
}

.modal-box{
background:#fff;
width:650px;
max-height:85vh;
border-radius:10px;
box-shadow:0 15px 40px rgba(0,0,0,0.25);
animation:modalShow 0.3s ease;
display:flex;
flex-direction:column;
overflow:hidden;
}

.modal-header{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 20px;
background:#0f766e;
color:white;
}

.modal-header h3{
margin:0;
font-size:18px;
}

.close-btn{
background:none;
border:none;
font-size:22px;
color:white;
cursor:pointer;
}

.modal-body{
padding:20px;
overflow-y:auto;
}

.form-group{
margin-bottom:18px;
display:flex;
flex-direction:column;
}

.form-group label{
font-weight:600;
margin-bottom:6px;
color:#333;
}

.form-group select,
.form-group textarea{
padding:8px 10px;
border:1px solid #ccc;
border-radius:6px;
font-size:14px;
}

.form-group select:focus,
.form-group textarea:focus{
outline:none;
border-color:#0f766e;
}

.modal-footer{
display:flex;
justify-content:flex-end;
gap:10px;
margin-top:10px;
}

.btn-cancel{
background:#ddd;
border:none;
padding:8px 16px;
border-radius:6px;
cursor:pointer;
}

.btn-save{
background:#16a34a;
color:white;
border:none;
padding:8px 18px;
border-radius:6px;
cursor:pointer;
}

.btn-save:hover{
background:#15803d;
}

@keyframes modalShow{
from{
opacity:0;
transform:translateY(-30px);
}
to{
opacity:1;
transform:translateY(0);
}
}


/* Contenedor centrado  para el registro */
.modal-contenido {
    background: white;
    width: 800px;           /* 👈 tamaño fijo */
    max-width: 90%;         /* responsive */
    height: 80vh;           /* 👈 altura fija */
    margin: 50px auto;
    border-radius: 10px;
    overflow-y: auto;       /* scroll interno */
    padding: 30px;
}

/* Contenido interno */
.registro {
    margin: 20px;
}



/* Tabla centrada */

.tabla input {
    border: none;        /* ❌ quita el cuadro */
    outline: none;       /* ❌ quita el borde al hacer click */
    width: 100%;
    text-align: center;
    background: transparent; /* 👈 parece texto */
}
.tabla {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    table-layout: fixed; /* 👈 CLAVE */
   
}


.tabla th, .tabla td {
    border: 1px solid #ccc;
    padding: 2px;
    text-align: center;
    white-space: normal; /* 👈 permite salto */
    word-wrap: break-word;
    vertical-align: middle;
    border: 1px solid black;
}

/* Botón */
.btn-agregar {
    display: block;
    margin: 10px auto;
    background: green;
    color: white;
    padding: 8px;
    border: none;
    cursor: pointer;
}
</style>

<style>
@media print {

    /* Oculta TODO */
    body * {
        visibility: hidden;
    }

    /* Muestra SOLO el modal */
    .modal-contenido, 
    .modal-contenido * {
        visibility: visible;
    }

    /* Ajusta posición para que ocupe toda la hoja */
    .modal-contenido {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: auto;
        margin: 0;
        box-shadow: none;
        border-radius: 0;
    }

    /* Ocultar botones innecesarios */
  
    .btn-agregar,
    button {
        display: none !important;
    }
}

.tabla textarea {
    width: 100%;
    min-height: 30px;     /* 👈 pequeño por defecto */
    max-height: 80px;     /* 👈 no crece demasiado */
    border: none;         /* ❌ sin borde */
    outline: none;        /* ❌ sin borde azul */
    resize: none;         /* ❌ no se estira manual */
    background: transparent;
    text-align: center;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.2;

    overflow: hidden;     /* 👈 evita scroll feo */
}
.tabla textarea {
    pointer-events: auto; /* editable */
}

@media print {
    .tabla textarea {
        border: none;
    }
}
</style>




<div class="container">

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">
<h4>Detalle de la Solicitud #{{ $solicitud->id }}</h4>
</div>

<div class="card-body">

    <div class="row">

<!-- Empresa -->
            <div class="col-md-6">

               <div class="card mb-3">
                   <div class="card-header bg-light">
                     <strong>Datos de la Empresa</strong>
               </div>

               <div class="card-body">

                <p><strong>Nombre:</strong> 
                  {{ $solicitud->empresa->nombre ?? 'No disponible' }}
                </p>

                <p><strong>Nombre de la Empresa:</strong> 
                {{ $solicitud->empresa->razon_social ?? '-' }}
                </p>
                <p><strong>Estado:</strong> 
<span class="badge bg-warning text-dark">
{{ $solicitud->estado }}
</span>
</p>

<p><strong>Fecha de solicitud:</strong> 
{{ $solicitud->created_at->format('d/m/Y') }}
</p>

<p><strong>Evaluador asignado:</strong> 
{{ $solicitud->evaluador_id ?? 'No asignado' }}
</p>
  


</div>
</div>

</div>

<!-- Producto -->
<div class="col-md-6">

<div class="card mb-3">
<div class="card-header bg-light">
<strong>Datos del Producto</strong>
</div>

<div class="card-body">


<p>
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


<p>
    <strong>Marca Comercial:</strong>
    {{ $solicitud->marca ?? '-' }}
</p>


<p>
    <strong>Dirección y Lugar de Fabricación:</strong>
    {{ $solicitud->descripcion ?? '-' }}
</p>

<!--este boton es para abrir el modal para hacer la evalaucion-->
<button id="btnEvaluar" class="btn btn-success btn-sm">
<i class="fa fa-check"></i>
Realizar Evaluación
</button>
<button >
<a href="{{ route('evaluador.agenda') }}"><i class="fa fa-circle-o"></i>Agendar Visitas </a>
</button>


<!--esto es el boton para pober ver el modal de registro -->
<button onclick="abrirModal()" class="btn-ver">
    Ver Solicitud
</button>
</div>

</div>

</div>

</div>


<div class="row">

<!-- Información de solicitud -->
<div class="col-md-6">

<div class="card mb-3">
<div class="card-header bg-light">
<strong>Información de la Solicitud</strong>
</div>

<div class="card-body">
    


</div>
</div>

</div>


<!-- Documentos -->
<div class="col-md-7">

<div class="card mb-3">
<div class="card-header bg-light">

<h4 class="text-primary">Archivos Cargados</h4>

           <p class="mt-3"><b>Declaración Jurada:</b></p>

@php
    $declaracion = $solicitud->documentos->where('tipo', 'declaracion')->first();
@endphp

@if($declaracion)
    <li class="list-group-item d-flex justify-content-between">
        <span>{{ $declaracion->nombre_original }}</span>

        <a href="{{ asset('storage/'.$declaracion->ruta) }}" 
           target="_blank" 
           class="btn btn-primary btn-sm">
            Ver
        </a>

        <a href="{{ asset('storage/' . $declaracion->ruta) }}" 
           download 
           class="btn btn-success btn-sm">
            Descargar
        </a>
    </li>
@else
    <p>No subido</p>
@endif

             <p class="mt-3"><b>Documento del Anexo B:</b></p>

@php
    $respaldos = $solicitud->documentos
        ->where('tipo', 'respaldo');
@endphp

@if($respaldos->count())
    @foreach($respaldos as $respaldo)
        <li class="list-group-item d-flex justify-content-between">
            <span>{{ $respaldo->nombre_original }}</span>

            
                <a href="{{ url('storage/'.$respaldo->ruta) }}"
                   target="_blank"
                   class="btn btn-primary btn-sm">
                   Ver
                </a>

                <a href="{{ url('storage/'.$respaldo->ruta) }}"
                   download="{{ $respaldo->nombre_original }}"
                   class="btn btn-success btn-sm">
                   Descargar
                </a>
           
        </li>
    @endforeach
@else
    <p>No se subieron respaldos.</p>
@endif

          
<p><b>Diagrama:</b></p>

@php
$diagrama = $solicitud->documentos->where('tipo', 'diagrama')->first();
@endphp

@if($diagrama)
    <li class="list-group-item d-flex justify-content-between">
        <span>{{ $diagrama->nombre_original }}</span>

        <a href="{{ url('storage/'.$diagrama->ruta) }}"
           target="_blank"
           class="btn btn-primary btn-sm">
           Ver archivo
        </a>

        <a href="{{ url('storage/'.$diagrama->ruta) }}"
           download
           class="btn btn-success btn-sm">
           Descargar
        </a>
    </li>
@else
    <p>No subido</p>
@endif

         <p class="mt-3"><b>Imágenes de los Productos:</b></p>

@php
    $imagenes = $solicitud->documentos
        ->where('tipo', 'imagen');
@endphp

@if($imagenes->count())

    <div class="list-group">

        @foreach($imagenes as $index => $imagen)

            <div class="list-group-item d-flex justify-content-between align-items-center">

                <div>
                    <i class="fa-solid fa-image text-primary"></i>
                    <strong>Producto {{ $index + 1 }}</strong>
                    <br>
                    <small class="text-muted">
                        {{ $imagen->nombre_original }}
                    </small>
                </div>

                <div>
                    <a href="{{ url('storage/'.$imagen->ruta) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i>
                        Ver Imagen
                    </a>

                    <a href="{{ url('storage/'.$imagen->ruta) }}"
                       download="{{ $imagen->nombre_original }}"
                       class="btn btn-success btn-sm">
                        <i class="fa fa-download"></i>
                        Descargar
                    </a>
                </div>

            </div>

        @endforeach

    </div>

@else

    <p class="text-muted">
        No se subieron imágenes de productos.
    </p>

@endif


</div>
</div>

</div>

</div>

</div>


<div class="card-footer text-end">


</div>

</div>

</div>

<hr>
<div class="card-footer text-end">


</div>

<!--modal del registro-->
<div id="miModal" class="modal">
    
  <div class="modal-contenido">
     
    <div style="position: relative; text-align: center; margin: 0; padding: 0; background:#0f766e;">

        <h3 style="margin: 0; padding: 10px; color: white;">
            REGISTRO
        </h3>

        <span onclick="cerrarModal()" 
              style="
                  position: absolute;
                  right: 0;
                  top: 0; 
                  cursor: pointer;
                  font-size: 18px;
                  color:red;
                  margin:3px;
              ">
            x
        </span>
    </div>
    <div class="registro">
       
        <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">

            <h5>SOLICITUD DE VERIFICACIÓN "VAON"</h5>

            <p><strong>Organización:</strong> {{ $solicitud->empresa->razon_social }}</p>
            <p><strong>NIT:</strong> {{ $solicitud->empresa->nit }}</p>
            <p><strong>Dirección:</strong> {{ $solicitud->descripcion ?? '-' }}</p>
            <p><strong>Representante legal:</strong> {{ $solicitud->empresa->representante }}</p>
             <p><strong>Cargo:</strong> {{ $solicitud->empresa->cargo }}</p>
        <p><strong>Contacto:</strong> {{ $solicitud->empresa->persona_contacto }}</p>
        <p><strong>Correo:</strong> {{ $solicitud->empresa->email }}</p>
        <p><strong>Teléfono:</strong> {{ $solicitud->empresa->telefono }}</p>
        <p><strong>Celular:</strong> {{ $solicitud->empresa->celular }}</p>

        <p><strong>Requisitos:</strong> Sello de certificación VAON</p>
        <p><strong>Objeto de la verificaión:</strong> Verificación de declaración jurada basada en los  requisitos VAON </p>


            <h4 style="text-align:center; margin-top:20px;">Alcance de la verificación</h4>

            <table class="tabla" style="width:80%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border:1px solid black; padding:8px;">N°</th>
                        <th style="border:1px solid black; padding:8px;">Producto</th>
                        <th style="border:1px solid black; padding:8px;">Marca Comercial</th>
                    </tr>
                </thead>
                <tbody id="tablaProductos">
                    <tr>
                        <td style="border:1px solid black; padding:8px;">1</td>
                        <td style="border:1px solid black; padding:8px;">
                            <textarea name="productos[]" rows="2" placeholder="Ingrese producto"></textarea>
                        </td>
                        <td style="border:1px solid black; padding:8px;">{{ $solicitud->marca ?? '-no hay' }}</td>
                         <td>
            <button onclick="eliminarFila(this)">x</button>
        </td>
                    </tr>
                </tbody>
            </table>
            <button onclick="agregarFila()" class="btn-agregar">
            + Agregar fila
        </button>
       
        <div class="pie">
            <p>Adjuntar Diagramas de flujo y la descripción de los procesos, que permitan conocer de manera global los procesos implicados en la elaboración de los productos. </p>
            <p><strong>Revisión del Organismo Verificador:</strong> Se verificó que la información es veraz y exacta, (Este campo es completado por el organismo verificador).</p>
        </div>

       
</div>

        <button onclick="imprimirModal()" class="btn-imprimir">
            🖨 Imprimir / Guardar PDF
        </button>
       <form action="{{ route('evaluador.enviar.informe', $solicitud->id) }}" method="POST" onsubmit="guardarContenidoModal()">
    @csrf
<input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}" >
    <input type="hidden" name="contenido_modal" id="contenido_modal">
    

    <button type="submit">📤 Enviar</button>
</form>


    </div>
</div>
</div>

<script>
function guardarContenidoModal() {
   
    let modal = document.querySelector(".modal-contenido").cloneNode(true);
  
    // 🔥 Reemplazar textarea por su contenido
    modal.querySelectorAll("textarea").forEach(textarea => {
        let texto = textarea.value || '';

        let div = document.createElement("div");
        div.style.whiteSpace = "pre-wrap"; // respeta saltos de línea
        div.textContent = texto;
        div.style.border = "none";
div.style.textAlign = "center";

        textarea.parentNode.replaceChild(div, textarea);
    });

    // ❌ eliminar botones
    modal.querySelectorAll("button, .cerrar").forEach(e => e.remove());

    document.getElementById("contenido_modal").value = modal.innerHTML;
}
</script>
<script>

    document.addEventListener("input", function(e) {
    if (e.target.tagName.toLowerCase() === "textarea") {
        e.target.style.height = "auto";
        e.target.style.height = e.target.scrollHeight + "px";
    }
});
function abrirModal() {
    document.getElementById("miModal").style.display = "block";
}

function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}

function agregarFila() { 
    let textareas = document.querySelectorAll("textarea[name='productos[]']");

    // Validar campos vacíos
    for (let textarea of textareas) {
        if (textarea.value.trim() === "") {
            alert("Primero debes llenar todos los productos");
            textarea.focus();
            return;
        }
    }

    let tbody = document.getElementById("tablaProductos");

    let numero = tbody.rows.length + 1;

    let marca = tbody.rows[0].cells[2].innerText;

    let nuevaFila = document.createElement("tr");

    nuevaFila.innerHTML = `
        <td style="border:1px solid black; padding:8px;">${numero}</td>
        <td style="border:1px solid black; padding:8px;">
            <textarea name="productos[]" placeholder="Ingrese producto"></textarea>
        </td>
        <td style="border:1px solid black; padding:8px;">${marca}</td>
        <td>
            <button onclick="eliminarFila(this)">x</button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
}

function eliminarFila(boton) {
    let filas = document.querySelectorAll("#tablaProductos tr");

    if (filas.length === 1) {
        alert("Debe existir al menos una fila");
        return;
    }

    let fila = boton.closest("tr");
    fila.remove();

    actualizarNumeracion();
}

/* 🔢 Reordenar números después de eliminar */
function actualizarNumeracion() {
    let filas = document.querySelectorAll("#tablaProductos tr");
    filas.forEach((fila, index) => {
        fila.cells[0].innerText = index + 1;
    });
}

/* 🖨 Imprimir */
function imprimirModal() {
    window.print();
}

/* ✅ VALIDACIÓN (AHORA CORRECTA) */
function validarProductos() {
    let textareas = document.querySelectorAll("textarea[name='productos[]']");

    for (let textarea of textareas) {
        if (textarea.value.trim() === "") {
            alert("Todos los productos deben llenarse");
            return false;
        }
    }

    return true;
}
</script>

    




<!-- Modal para vista de Evaluación de Solicitud #---  http://127.0.0.1:8000/solicitud/64    Evaluación -->
<div id="modalEvaluacion" class="modal">

<div class="modal-box">

<div class="modal-header">

<h3>Evaluación de Solicitud #{{ $solicitud->id }}</h3>

<button id="cerrarModal" class="close-btn">&times;</button>

</div>

<div class="modal-body">

<form action="{{ route('evaluador.guardar.evaluacion', $solicitud->id) }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
<input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">

<div class="form-group">
<label>Verificación de Instalaciones</label>
<select name="instalaciones">
<option value="cumple">Cumple</option>
<option value="no_cumple">No cumple</option>
</select>
</div>

<div class="form-group">
<label>Revisión Documental</label>
<select name="documentacion">
<option value="completa">Documentación completa</option>
<option value="incompleta">Documentación incompleta</option>
</select>
</div>

<div class="form-group">
<label>Origen de Insumos</label>
<select name="origen_insumos">
<option value="verificado">Verificado</option>
<option value="no_verificado">No verificado</option>
</select>
</div>

<div class="form-group">
<label>Observaciones</label>
<textarea name="observaciones" rows="4"></textarea>
</div>


    <div class="form-group">
        <label>Resultado Final</label>
        <select name="resultado" required>
            <option value="">nop</option>
            <option value="cumple">Cumple requisitos VAON</option>
            <option value="no_cumple">No cumple requisitos VAON</option>
        </select>
    </div>

    <div class="form-group">
        <label>Evidencia</label>
        <input type="file" name="evidencia" accept="image/*" required>
      @if(isset($evaluacion) && $evaluacion->evidencia)
    <img src="{{ asset('storage/' . $evaluacion->evidencia) }}" width="100">
@endif
    </div>

    <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn-cancel">
            Cancelar
        </button>

        <button type="submit" class="btn-save">
            Guardar Evaluación
        </button>
    </div>

</div>

</form>

</div>

</div>

</div>





<script>

const botonEvaluar = document.getElementById("btnEvaluar");
const modal = document.getElementById("modalEvaluacion");
const cerrar = document.getElementById("cerrarModal");
const cancelar = document.getElementById("cancelarModal");

botonEvaluar.addEventListener("click", function(){
modal.style.display = "flex";
});

cerrar.addEventListener("click", function(){
modal.style.display = "none";
});

cancelar.addEventListener("click", function(){
modal.style.display = "none";
});

</script>

<!--modal para el registro-->
<script>
function abrirModal() {
    document.getElementById("miModal").style.display = "block";
}

function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}

// cerrar haciendo click fuera
window.onclick = function(event) {
    let modal = document.getElementById("miModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

@endsection




