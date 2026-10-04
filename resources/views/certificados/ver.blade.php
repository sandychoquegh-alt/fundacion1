<!DOCTYPE html>
<html>
<head>
    <title>Certificado #{{ $certificado->id }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f6f9;
        }
        .certificado {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .titulo {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .campo {
            margin-bottom: 12px;
        }
        .etiqueta {
            font-weight: bold;
            color: #333;
        }
        .qr {
            text-align: center;
            margin-top: 30px;
        }
    </style>

</head>
<body>

<div class="certificado">

    <div class="titulo">
        Certificado Oficial
    </div>

    <p class="campo"><span class="etiqueta">ID Certificado:</span> {{ $certificado->id }}</p>
    <p class="campo"><span class="etiqueta">Titular:</span> {{ $certificado->persona_nombre }}</p>
    <p class="campo"><span class="etiqueta">Empresa:</span> {{ $certificado->empresa }}</p>
    <p class="campo"><span class="etiqueta">Fecha de emisión:</span> {{ $certificado->fecha_emision }}</p>
    <p class="campo"><span class="etiqueta">Estado:</span> Válido</p>

    <div class="qr">
        <p><strong>Verificación:</strong></p>
        <img src="data:image/svg+xml;base64, {!! base64_encode(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(150)
                ->generate(url('certificados/verificar?codigo=' . $certificado->id))
        ) !!}">
    </div>

</div>

</body>
</html>
