<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contraseña Sistema VAON</title>
</head>
<body>
    <p>Hola,</p>
    <p>Tu cuenta fue creada en el sistema VAON.</p>
    <p><strong>Correo:</strong> {{ $correo ?? 'No disponible' }}</p>
    <p><strong>Contraseña temporal:</strong> {{ $password }}</p>
    <p>Te recomendamos cambiarla al ingresar.</p>
</body>
</html>
