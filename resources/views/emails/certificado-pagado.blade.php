<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado VAON disponible</title>
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

    <h2 style="text-align: center; color: #198754;">
        Certificado VAON disponible
    </h2>

    <p>
        Estimado representante de la empresa:
    </p>

    <p>
        Le informamos que el pago correspondiente al
        <strong>Certificado VAON</strong> ha sido confirmado
        correctamente.
    </p>

    <hr>

    <p>
        <strong>Producto:</strong>
        {{ $certificado->producto }}
    </p>

    <p>
        <strong>N.º de certificado:</strong>
        {{ $certificado->codigo }}
    </p>

    <p>
        <strong>Porcentaje VAON:</strong>
        {{ $certificado->porcentaje_vaon }}%
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
        background-color: #d1e7dd;
        border: 1px solid #198754;
        padding: 15px;
        border-radius: 8px;
        margin: 20px 0;
    ">

        <p style="margin: 0; color: #0f5132;">
            <strong>Pago confirmado</strong>
        </p>

        <p style="margin-bottom: 0; color: #0f5132;">
            Su certificado ya se encuentra disponible
            en el sistema.
        </p>

    </div>

    <p>
        Puede ingresar a su cuenta para visualizar y descargar
        su certificado desde la sección
        <strong>Certificados activos</strong>.
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