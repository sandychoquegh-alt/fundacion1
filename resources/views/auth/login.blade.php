<div class="login-container">
    
    <!-- LOGO INSTITUCIONAL -->
    <div class="logo-box">
        <img src="{{ asset('img/object1092908693.gif') }}" alt="Logo Institucional" class="login-logo">
    </div>

    <div class="login-card">
        <!-- Botón lateral para cambiar modo -->
<div class="theme-toggle" onclick="toggleTheme()">
    <span id="theme-icon">🌙</span>
</div>

        <div class="login-header">
            <h4>Iniciar Sesión</h4>
        </div>

        <div class="login-body">

            @if(session('success'))
                <div class="alert alert-success custom-alert">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger custom-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3 password-wrapper">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" name="password" type="password" class="input" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        👁️
                    </span>
                </div>

                <button class="btn-login" type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <a href="/register" class="btn-registrarse">Registrarse</a>
</div>

<style>
    * { font-family: "Segoe UI", Arial, sans-serif; }

    /* Modo Claro / Oscuro */
    :root {
        --bg-main: #f4f6f9;
        --card-bg: #ffffff;
        --text-color: #222;
        --border-color: #d3d3d3;
        --primary: #003366;   
        --primary-hover: #002244;
        --success: #28a745;
    }
    /* Modo oscuro manual */
.manual-dark {
    --bg-main: #111315;
    --card-bg: #1d1f23;
    --text-color: #e6e6e6;
    --border-color: #333;
    --primary: #4d88ff;
    --primary-hover: #2e63cc;
}


    @media (prefers-color-scheme: dark) {
        :root {
            --bg-main: #181a1d;
            --card-bg: #24272b;
            --text-color: #e6e6e6;
            --border-color: #444;
            --primary: #4d88ff;
            --primary-hover: #2e63cc;
        }
    }

    body {
        background: var(--bg-main);
        margin: 0;
        padding: 0;
        color: var(--text-color);
    }

    /* Contenedor */
    .login-container {
        max-width: 400px;
        margin: 70px auto;
        text-align: center;
    }

    /* Caja del Logo */
    .logo-box {
        margin-bottom: 25px;
    }

    /* LOGO */
    .login-logo {
        width: 120px;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.3));
        transition: 0.3s ease;
    }

    @media (prefers-color-scheme: dark) {
        .login-logo {
            filter: brightness(0.9) drop-shadow(0px 2px 4px rgba(255,255,255,0.2));
        }
    }

    /* Tarjeta */
    .login-card {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 3px 18px rgba(0,0,0,0.15);
        border: 1px solid var(--border-color);
        transition: 0.2s ease;
    }

    .login-card:hover {
        transform: translateY(-2px);
    }

    /* Título */
    .login-header h4 {
        margin-bottom: 15px;
        color: var(--primary);
        font-weight: 700;
        font-size: 22px;
    }

    /* Inputs */
    .input {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: #f7f9fc;
        font-size: 15px;
        color: var(--text-color);
        transition: 0.2s ease;
    }

    @media (prefers-color-scheme: dark) {
        .input {
            background: #1e1f23;
        }
    }

    .input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 5px rgba(0,80,180,0.3);
        outline: none;
    }

    /* Mostrar Contraseña */
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 40px;
        cursor: pointer;
        opacity: 0.7;
        font-size: 18px;
        transition: 0.2s ease;
    }

    .toggle-password:hover {
        opacity: 1;
    }

    /* Botón Login */
    .btn-login {
        width: 100%;
        padding: 12px;
        background: var(--primary);
        color: #fff;
        font-size: 17px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.2s;
    }

    .btn-login:hover {
        background: var(--primary-hover);
    }

    /* Botón Registrarse */
    .btn-registrarse {
        display: inline-block;
        margin-top: 18px;
        padding: 10px 22px;
        background: var(--success);
        color: #fff;
        font-size: 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-registrarse:hover {
        background: #1e7e34;
    }

    /* Alertas */
    .custom-alert {
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
    }

    /* Botón flotante modo oscuro/claro */
.theme-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--card-bg);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.25);
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border: 1px solid var(--border-color);
    transition: 0.2s ease;
    z-index: 9999;
}

.theme-toggle:hover {
    transform: scale(1.08);
}

#theme-icon {
    font-size: 22px;
    transition: 0.2s ease;
}

</style>

<script>
    function togglePassword() {
        let input = document.getElementById("password");
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
<script>
function toggleTheme() {
    const body = document.body;
    const icon = document.getElementById('theme-icon');

    // Alternar clase "dark-mode"
    body.classList.toggle('manual-dark');

    // Cambiar icono
    if (body.classList.contains('manual-dark')) {
        icon.textContent = "☀️"; // Claro
        localStorage.setItem("theme", "dark");
    } else {
        icon.textContent = "🌙"; // Oscuro
        localStorage.setItem("theme", "light");
    }
}

// Cargar el tema guardado
window.onload = function() {
    const icon = document.getElementById('theme-icon');
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        document.body.classList.add("manual-dark");
        icon.textContent = "☀️";
    } else {
        icon.textContent = "🌙";
    }
}
</script>

