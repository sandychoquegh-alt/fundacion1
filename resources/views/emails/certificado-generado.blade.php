<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado VAON generado</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

<div style="
    max-width: 650px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #ddd;
">

    <h2 style="text-align: center; color: #1e3a8a;">
        Certificado VAON generado correctamente
    </h2>

    <p>
        Estimado representante de la empresa:
    </p>

    <p>
        Le informamos que el producto indicado a continuación
        ha obtenido el <strong>Certificado VAON</strong>.
    </p>

    <hr>

    <p>
        <strong>Producto:</strong>
        {{ $certificado->producto }}
    </p>


    <p>
        <strong>Fecha de emisión:</strong>
        {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
    </p>

    <p>
        <strong>Fecha de vencimiento:</strong>
        {{ \Carbon\Carbon::parse($certificado->fecha_vencimiento)->format('d/m/Y') }}
    </p>

    <hr>

    <div style="
        background-color: #fff3cd;
        border: 1px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin: 20px 0;
    ">

        <p style="margin: 0; color: #856404;">
            <strong>Pago pendiente</strong>
        </p>

        <p style="margin-bottom: 0; color: #856404;">
            Para continuar con el proceso de certificación,
            le solicitamos acercarse a las instalaciones de la
            <strong>Fundación Hecho en Bolivia</strong> para
            realizar el pago correspondiente.
            o cominicarce al numero: 65351816
        </p>

    </div>

    <p>
        Una vez confirmado el pago, recibirá una nueva notificación
        por correo electrónico informándole que su certificado
        se encuentra disponible para su visualización y descarga
        desde el sistema.
    </p>

    <p>
        Atentamente,
    </p>

    <p>
        <strong>Fundación Hecho en Bolivia</strong>
    </p>

</div>

</body>
</html>