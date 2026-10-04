<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
    <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
  <style>
   
    @page {
        margin:0px;
        background-image: url('{{ public_path('img/0003.png') }}');
    }

    body {  text-align: center; margin: 0px;
        padding: 0px;
        
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    
   .qr {
    float: right;
    text-align: right;
    margin-right: 0px;  /* ajusta según necesites */
    margin:30px;
 
}
.tidio{
    margin:20px;
    background-image:url('{{ public_path('img/logo.png') }}');
    width: 190px;
        height: 190px;
    text-align: center;
     border-radius: 110px;
    
    margin-left:40%;

}

    .firma p {
        margin-bottom: 2px;
        margin-top: 10px;
        font-weight: bold;
    }
    .firma small {
        font-size: 13px;
    }

  </style>
</head>
<body style=" background-image:url('{{ public_path('img/0003.png') }}');">
    <div class="tidio" stily=" height:30px ;  "></div>
    <div class="header" style="line-height: 0.5; font-family: 'Arial', sans-serif;">
       <!--<img src="{{ asset('img/descarga.png') }}" width="150"><br><br>-->
       
     
          <h3>LA FUNDACIÓN HECHO EN BOLIVIA</h3>
            <h3>OTORGA EL PRESENTE</h3>
    
            <h3><b>CERTIFICADO DE USO DEL SELLO</b> </h3>
            <h1><b> VAON </b></h1>
            <h2><b>"VALOR AGREGADO DE ORIGEN NACIONAL"</b></h2>
        <h5>El Sello Certifica que los aspectos de Requisitos VAON, se cumple en el:</h5>
     
    </div>
    <div class="content" style="
    margin: 40px;
    padding-left:0%;
    width: 85%;
    font-family: 'Arial', sans-serif;
    line-height: 0.5;
    text-align: left;
    font-size:15px;">

        <p><strong>PRODUCTO:</strong> {{ $certificado->producto }} {{ $certificado->porcentaje_vaon }} % VAON {{$certificado->descripcion }}</p>
         
        <p><strong>MARCA COMERCIAL:</strong> {{ $certificado->empresa->razon_social }}</p>

        <p><strong>DE LA EMPRESA:</strong> {{ $certificado->motivos_cert }}</p>
        <div style="text-align: center;">

         @if($certificado->imagen)
            <p><strong></strong></p>
            <img src="{{ public_path('storage/' . $certificado->imagen) }}" style="max-width:100px;  text-align:right;">
        @endif
        </div>

        <p><strong>LUGAR DE FABRICACIÓN:</strong> {{ $certificado->lugar_fabricacion }}</p>
       <p><strong></strong> El presente certificado N°{{ $certificado->codigo }}, con R.D. {{ $certificado->fecha_emision }}, autoriza al titular de la empresa </p>
        <p><strong></strong> {{ $certificado->motivos_cert }}, hacer uso del sello VAON, por el periodode vigencia.</p>
        
        <p><strong>LUGAR DE FABRICACIÓN:</strong> {{ $certificado->lugar_fabricacion }}</p>
        <p><strong>Fecha de certificación:</strong> {{ $certificado->fecha_emision }}</p>
        <p><strong>Este certificado es válido hasta:</strong> {{ $certificado->fecha_vencimiento }}</p>
      

    </div>

    <div class="qr">
      <p><b></b></p>
      <img src="data:image/svg+xml;base64,{!! base64_encode(
    \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(100)
        ->errorCorrection('H')
        ->generate(route('certificados.verificar', $certificado->codigo))
) !!}">

    </div>
   

</div> 
    <div class="footer">

        <!--Generado automáticamente por el sistema-->
    </div>
</body>
</html>
