<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visita programada</title>
</head>

<body style="
    margin: 0;
    padding: 30px;
    background-color: #f4f4f4;
    font-family: Arial, Helvetica, sans-serif;
">

    <div style="
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
    ">

        <h2 style="
            color: #1e3a8a;
            margin-top: 0;
        ">
            📅 Visita programada
        </h2>

        <p>
            Estimado/a
            <strong>
                {{ $visita->empresa->representante ?? 'representante de la empresa' }}
            </strong>:
        </p>

        <p>
            Le informamos que se ha programado una visita relacionada
            con su solicitud de certificación VAON.
        </p>

        <hr>

        <h3 style="color: #1e3a8a;">
            Datos de la visita
        </h3>

        <p>
            <strong>Solicitud:</strong>
            #{{ $visita->solicitud_id }}
        </p>

        <p>
            <strong>Empresa:</strong>
            {{ $visita->empresa->razon_social ?? 'No disponible' }}
        </p>

        <p>
            <strong>Producto:</strong>
            {{ $visita->solicitud->producto->nombre ?? 'No disponible' }}
        </p>

        <p>
            <strong>Fecha de visita:</strong>
            {{ \Carbon\Carbon::parse($visita->fecha_visita)->format('d/m/Y') }}
        </p>

        <p>
            <strong>Hora:</strong>
            {{ $visita->hora }}
        </p>

        <p>
            <strong>Evaluador:</strong>
            {{ $visita->evaluador->nombre ?? 'No disponible' }}
        </p>

        @if($visita->observaciones)

            <p>
                <strong>Observaciones:</strong>
            </p>

            <p>
                {{ $visita->observaciones }}
            </p>

        @endif

        <div style="
            margin-top: 30px;
            padding: 15px;
            background-color: #f0f4ff;
            border-left: 4px solid #1e3a8a;
        ">

            <strong>
                Importante:
            </strong>

            <p style="margin-bottom: 0;">
                Le solicitamos tomar las previsiones necesarias
                para atender la visita en la fecha y hora indicadas.
            </p>

        </div>

        <div style="
            text-align: center;
            margin-top: 30px;
        ">

            <a href="{{ url('/login') }}"
               style="
                    display: inline-block;
                    background-color: #1e3a8a;
                    color: #ffffff;
                    padding: 12px 25px;
                    text-decoration: none;
                    border-radius: 6px;
               ">
                Ingresar al sistema VAON
            </a>

        </div>

        <hr style="margin-top: 30px;">

        <p style="
            font-size: 12px;
            color: #777;
            text-align: center;
        ">
            Este es un mensaje automático del Sistema VAON
            de la Fundación Hecho en Bolivia.
        </p>

    </div>

</body>

</html>

