<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema VAON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #005AA7, #FFFDE4);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            width: 420px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .toggle-btn {
            background: none;
            border: none;
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <h4 id="form-title">Iniciar Sesión</h4>
    </div>
    <div class="card-body">

        {{-- ALERTAS --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
        @endif

        {{-- FORMULARIO LOGIN --}}
        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label>Correo Electrónico</label>
                <input type="email" class="form-control" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary w-100">Ingresar</button>
            <p class="mt-3 text-center">
                ¿No tienes cuenta? 
                <button type="button" class="toggle-btn" id="show-register">Registrar Empresa</button>
            </p>
        </form>

        {{-- FORMULARIO REGISTRO --}}
        <form id="register-form" class="hidden" method="POST" action="{{ route('empresa.registrar') }}">
            @csrf
            <div class="mb-2">
                <label>Razón Social</label>
                <input type="text" name="razon_social" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>NIT</label>
                <input type="text" name="nit" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Representante</label>
                <input type="text" name="representante" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Registrar Empresa</button>
            <p class="mt-3 text-center">
                ¿Ya tienes cuenta? 
                <button type="button" class="toggle-btn" id="show-login">Iniciar Sesión</button>
            </p>
        </form>

    </div>
</div>

<script>
document.getElementById('show-register').addEventListener('click', function() {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('register-form').classList.remove('hidden');
    document.getElementById('form-title').textContent = 'Registrar Empresa';
});

document.getElementById('show-login').addEventListener('click', function() {
    document.getElementById('register-form').classList.add('hidden');
    document.getElementById('login-form').classList.remove('hidden');
    document.getElementById('form-title').textContent = 'Iniciar Sesión';
});
</script>

</body>
</html>
