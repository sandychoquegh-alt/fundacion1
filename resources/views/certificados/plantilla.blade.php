<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body { font-family: DejaVu Sans, sans-serif; text-align: center; margin: 40px;  }
    
    .box {
      border: 4px double #006400;
      padding: 40px;
      border-radius: 10px;
      background: #f8fff8;
       width: 50%;
  height: 30%;
      
    }
    .firma { margin-top: 20px; text-align: center; }
    .qr { margin-top: 60px; text-align: right; font-size: 12px; }
  </style>
</head>
<body>
  <div class="box" style=" background-image: url('{{ asset('img/0001.pn') }}')">
    <img src="{{ asset('img/descarga.png') }}" width="250"><br><br>
    <h3>LA FUNDACIÓN HECHO EN BOLIVIA</h3>
    <h3>OTORGA EL PRESENTE</h3>
    <br>
    <h3><b>CERTIFICADO DE USO DEL SELLO</b> </h3>
     <h1><b> VAON </b></h1>
      <h2><b>"VALOR AGREGADO DE ORIGEN NACIONAL"</b></h2>
      <h5>El Sello Certifica que los aspectos de Requisitos VAON, se cumple en el:</h5>
      <br><br>
    <!--<p>
      Se certifica que la empresa <b>{{ $empresa->razon_social }}</b><br>
      cumple con los requisitos del <b>Valor Agregado de Origen Nacional (VAON)</b>.
    </p>-->
    <div style="
    padding-left: 20%;
    width: 85%;
    font-family: 'Arial', sans-serif;
    line-height: 2;
    text-align: left;
    font-size:5px;
    
">

    <h5 style="margin: 5px 0; font-size: 16px;">
        <b>PRODUCTO:</b> {{ $certificado->porcentaje_vaon }}%, {{ $producto }}
    </h5>
    <br>

    <h5 style="margin: 5px 0; font-size: 16px;">
        <b>MARCA COMERCIAL:</b> {{ $empresa->razon_social }}
    </h5>
    <br>

    <h5 style="margin: 5px 0; font-size: 16px;">
        <b>DE LA EMPRESA:</b>
    </h5>
    <br>

    <h5 >imagen</h5>
    <br>

    <h5 style="margin: 5px 0; font-size: 16px;">
        <b>LUGAR DE FABRICACIÓN:</b>
    </h5><br>

    <h5 style="margin: 5px 0; font-size: 16px;">
        El presente certificado N° {{ $certificado->codigo }} con R.D. {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }},
        autoriza al titular de la empresa <br>COOPERATIVA, hacer el uso del Sello VAON, por el periodo de vigencia.
    </h5>
    <br>

    <h5 style="margin: 10px 0; font-size: 16px;">
        <b>Fecha de certificación:</b> {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }} <br>
        <b>Este certificado es válido hasta:</b> {{ \Carbon\Carbon::parse($certificado->fecha_vencimiento)->format('d/m/Y') }}
    </h5>

</div>


    <div class="qr">
      <p><b>Verificación en línea:</b></p>
      <img src="data:image/png;base64, {!! base64_encode(
    \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(150)
        ->errorCorrection('H')
        ->generate('Vista previa - ' . now())
) !!}">

    </div>
    <div class="row">
    <div class="col-md-6 firma">
      <p>______________________________ </p>
      <small>Director Ejecutivo<br>Fundación Hecho en Bolivia</small>
    </div>
    <div class=" col-md-6 firma">
      <p>______________________________</p>
      <small>Director2<br>Fundación Hecho en Bolivia</small>
    </div>
  </div>
  </div>
</body>
</html>
