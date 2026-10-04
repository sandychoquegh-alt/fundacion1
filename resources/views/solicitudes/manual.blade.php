@extends('layouts.empresad')

@section('contenido')

<style>

.manual-container{
padding:20px;
}

.manual-header{
text-align:center;
margin-bottom:40px;
}

.manual-header h1{
font-weight:700;
color:#2c3e50;
}

.manual-card{
background:white;
border-radius:10px;
box-shadow:0px 3px 10px rgba(0,0,0,0.1);
padding:25px;
margin-bottom:25px;
}

.manual-steps{
margin-top:30px;
}

.step-card{
background:#f8f9fa;
border-radius:10px;
padding:20px;
text-align:center;
margin-bottom:20px;
transition:0.3s;
}

.step-card:hover{
transform:translateY(-5px);
box-shadow:0px 5px 15px rgba(0,0,0,0.15);
}

.step-number{
font-size:28px;
font-weight:bold;
color:white;
background:#3c8dbc;
width:45px;
height:45px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
margin:auto;
margin-bottom:10px;
}

.requisitos-list li{
margin-bottom:10px;
}

.btn-solicitud{
padding:14px 30px;
font-size:18px;
border-radius:8px;
}

.faq-item{
background:#f8f9fa;
padding:15px;
border-radius:8px;
margin-bottom:10px;
cursor:pointer;
}

.faq-answer{
display:none;
padding-top:10px;
color:#555;
}

/* Responsive */

@media(max-width:768px){

.manual-header h1{
font-size:24px;
}

.step-card{
margin-bottom:20px;
}

}

</style>


<div class="manual-container">

<!-- HEADER -->

<div class="manual-header">

<h1>Manual para Solicitar el Certificado VAON</h1>

<p class="text-muted">
El Sello de Certificación VAON  (Valor Agregado de Origen Nacional) reconoce a los productos
fabricados en Bolivia que cumplen con criterios de
producción nacional.
</p>

</div>


<!-- QUE ES VAON -->

<div class="manual-card">

<h3><b>¿Qué es el Certificado VAON?</b></h3>

<p>
El Certificado VAON acredita que un producto ha sido elaborado
principalmente con recursos nacionales, considerando materia
prima, insumos y mano de obra utilizados en la producción.
</p>

<div class="alert alert-success">

<b>Un producto es considerado de origen nacional cuando
el valor agregado nacional es igual o mayor al 51%.</b>

</div>

</div>



<!-- PASOS -->

<div class="manual-card">

<h3><b>Proceso para Solicitar el Certificado</b></h3>

<div class="row manual-steps">

<div class="col-lg-3 col-md-6 col-sm-12">

<div class="step-card">

<div class="step-number">1</div>
<div class="small-box ">
<div class="inner">
<h4>Enviar Solicitud</h4>

<p>
La empresa debe registrar la solicitud con los datos
de la organización y del producto.
</p>
<div class="icon">
<i class="fa fa-file-text"></i>
</div>
</div>
</div>
</div>

</div>



<div class="col-lg-3 col-md-6 col-sm-12">

<div class="step-card">

<div class="step-number">2</div>
<div class="small-box">
<div class="inner">
<h4>Declaración Jurada</h4>

<p>
La empresa declara los costos de materia prima,
insumos y mano de obra.
</p>
<div class="icon">
<i class="fa fa-pencil"></i>
</div>
</div>
</div>
</div>

</div>



<div class="col-lg-3 col-md-6 col-sm-12">

<div class="step-card">

<div class="step-number">3</div>
<div class="small-box ">
<div class="inner">
<h4>Verificación</h4>

<p>
El organismo verificador revisa la documentación
y realiza una inspección en la empresa.
</p>
<div class="icon">
<i class="fa fa-search"></i>
</div>
</div>
</div>
</div>

</div>



<div class="col-lg-3 col-md-6 col-sm-12">

<div class="step-card">

<div class="step-number">4</div>
<div class="small-box ">
<div class="inner">
<h4>Certificación</h4>

<p>
Si el producto cumple los requisitos VAON
se otorgará el sello de certificación.
</p>
<div class="icon">
<i class="fa fa-certificate"></i>
</div>
</div>
</div>
</div>

</div>

</div>

</div>



<!-- REQUISITOS -->

<div class="manual-card">

<h3><b>Requisitos para la Solicitud</b></h3>

<ul class="requisitos-list">

<li>Formulario de solicitud de verificación.</li>

<li>Declaración jurada con los costos de producción.</li>

<li>Diagrama de flujo del proceso productivo.</li>

<li>Documentación de respaldo de materia prima, insumos y mano de obra.</li>

<li>Información financiera de los últimos 12 meses.</li>

</ul>

</div>



<!-- VIGENCIA -->

<div class="manual-card">

<h3><b>Vigencia del Certificado</b></h3>

<p>

El certificado VAON tiene una validez de 
<b>1 año</b>. La renovación debe realizarse 
<b>45 días antes del vencimiento</b>.

</p>

</div>



<!-- FAQ -->

<div class="manual-card">

<h3><b>Preguntas Frecuentes</b></h3>

<div class="faq-item" onclick="toggleFaq(1)">
<b>¿Quién puede solicitar el certificado?</b>
<div id="faq1" class="faq-answer">
Empresas productivas que fabriquen productos en Bolivia.
</div>
</div>


<div class="faq-item" onclick="toggleFaq(2)">
<b>¿Qué pasa si no cumplo los requisitos?</b>
<div id="faq2" class="faq-answer">
La empresa puede corregir la información y volver a solicitar la verificación.
</div>
</div>


<div class="faq-item" onclick="toggleFaq(3)">
<b>¿Cuánto dura la certificación?</b>
<div id="faq3" class="faq-answer">
La certificación tiene una duración de 1 año.
</div>
</div>

</div>


</div>


<script>

function toggleFaq(id){

var faq=document.getElementById("faq"+id);

if(faq.style.display==="block"){
faq.style.display="none";
}else{
faq.style.display="block";
}

}

</script>

@endsection

