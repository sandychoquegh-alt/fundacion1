
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nueva solicitud asignada</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

    <div style="
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
    ">

        <h2 style="color: #1e3a8a;">
            Nueva solicitud asignada
        </h2>

        <p>
            Hola <strong>{{ $solicitud->evaluador->nombre ?? 'Evaluador' }}</strong>,
        </p>

        <p>
            Se te ha asignado una nueva solicitud para realizar
            la evaluación correspondiente en el sistema VAON.
        </p>

        <hr>

        <p>
            <strong>Número de solicitud:</strong>
            #{{ $solicitud->id }}
        </p>

        <p>
            <strong>Empresa:</strong>
            {{ $solicitud->empresa->razon_social ?? 'No disponible' }}
        </p>

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
        </p>

        <p>
            <strong>Estado:</strong>
            En revisión
        </p>

        <p>
            Por favor, ingresa al sistema VAON para revisar la
            documentación y realizar la evaluación de la solicitud.
        </p>

        <div style="text-align: center; margin-top: 30px;">

            <a href="{{ url('/login') }}"
               style="
                    display: inline-block;
                    background-color: #1e3a8a;
                    color: white;
                    padding: 12px 25px;
                    text-decoration: none;
                    border-radius: 6px;
               ">
                Ingresar al sistema
            </a>

        </div>

        <hr style="margin-top: 30px;">

        <p style="font-size: 12px; color: #777;">
            Este es un mensaje automático del Sistema VAON
            de la Fundación Hecho en Bolivia.
        </p>

    </div>

</body>

</html>

