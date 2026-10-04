<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Anexo A - Declaración Jurada</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0;
        }

        h3 {
            background: #e5e5e5;
            padding: 6px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table td {
            padding: 6px;
            border: 1px solid #666;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .firma {
            margin-top: 60px;
            text-align: center;
        }

        .firma-line {
            width: 60%;
            border-top: 1px solid black;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h2>ANEXO A</h2>
        <p><strong>DECLARACIÓN JURADA PARA CERTIFICACIÓN VAON</strong></p>
        <p>Fundación Hecho en Bolivia - Sistema VAON</p>
    </div>

    <!-- 1. DATOS DE LA ORGANIZACIÓN -->
    <h3>1. DATOS DE LA ORGANIZACIÓN</h3>
    <table>
        <tr>
            <td><strong>Razón Social:</strong></td>
            <td>{{ $empresa->razon_social }}</td>
        </tr>
        <tr>
            <td><strong>NIT:</strong></td>
            <td>{{ $empresa->nit }}</td>
        </tr>
        <tr>
            <td><strong>Dirección de fabricación:</strong></td>
            <td>{{ $empresa->direccion }}</td>
        </tr>
    </table>

    <!-- 2. REPRESENTANTE LEGAL -->
    <h3>2. REPRESENTANTE LEGAL</h3>
    <table>
        <tr>
            <td><strong>Nombre completo:</strong></td>
            <td>{{ $empresa->representante }}</td>
        </tr>
        <tr>
            <td><strong>Cargo:</strong></td>
            <td>{{ $empresa->cargo }}</td>
        </tr>
    </table>

    <!-- 3. PERSONA DE CONTACTO -->
    <h3>3. PERSONA DE CONTACTO</h3>
    <table>
        <tr>
            <td><strong>Nombre:</strong></td>
            <td>{{ $empresa->persona_contacto }}</td>
        </tr>
        <tr>
            <td><strong>Correo electrónico:</strong></td>
            <td>{{ $empresa->email }}</td>
        </tr>
        <tr>
            <td><strong>Teléfono:</strong></td>
            <td>{{ $empresa->telefono }}</td>
        </tr>
        <tr>
            <td><strong>Celular:</strong></td>
            <td>{{ $empresa->celular ?? '—' }}</td>
        </tr>
    </table>

    <!-- DECLARACIÓN -->
    <h3>DECLARACIÓN</h3>
    <p style="text-align: justify;">
        Declaro bajo juramento que la información presentada en este formulario es verídica y corresponde a los datos
        reales de la empresa solicitante. Me comprometo a presentar documentación adicional si la Fundación Hecho en
        Bolivia así lo requiere.
    </p>

    <!-- FIRMA -->
    <div class="firma">
        <p class="firma-line"></p>
        <p>Firma del Representante Legal</p>
    </div>

    <br><br>

    <!-- FOOTER -->
    <div class="footer">
        <small>Documento generado automáticamente por el Sistema VAON</small>
    </div>

</body>

</html>
