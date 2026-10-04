<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa</title>

    <style>
       /* ===== RESET GENERAL ===== */
body {font-family: "Poppins", sans-serif; margin: 0; height: 100vh; display: flex; } 
.left-section { width: 50%; background: url('{{ asset('img/imagen.png') }}') no-repeat center center; background-size: cover; position: relative; } 
.left-section::after { content: ""; position: absolute; width: 100%; height: 100%; background: rgba(8, 60, 40, 0.45); } 
.right-section { width: 50%; display: flex; justify-content: center; align-items: center; background: #F3F4F4; } 
.form-box { background: #ffffff; padding: 45px 40px; width: 80%; max-width: 650px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); animation: fade 0.8s ease-in-out; } @keyframes fade { from { opacity: 0; transform: translateY(25px); } to { opacity: 1; transform: translateY(0); } }
 h2 { text-align: center; margin-bottom: 25px; color: #0B3B24; font-size: 24px; font-weight: 700; } 
 .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 22px; } label { font-weight: 600; font-size: 14px; display: block; color: #0B3B24; transition: transform 0.3s ease,color 0.3s ease; } 
 input { width: 80%; padding: 12px; margin-top: 5px; border-radius: 4px; border: 2px solid #aeb8b5; outline: none; font-size: 15px; transition: 0.3s; transform: translateY(-25p); color:#0051ff;} input:focus { border-color: #0051ff; box-shadow: 0 0 6px rgba(13, 6, 78, 0.4); } button { width: 100%; padding: 14px; margin-top: 25px; border: none; color: white; font-size: 17px; font-weight: bold; border-radius: 4px; cursor: pointer; transition: 0.2s; } button:hover { background: #084d2e; } .link { margin-top: 15px; text-align: center; font-size: 14px; } .link a { color: #0B3B24; text-decoration: none; font-weight: bold; } .link a:hover { text-decoration: underline; } @media (max-width: 900px) { body { flex-direction: column; } .left-section, .right-section { width: 100%; height: 50%; } .grid-2 { grid-template-columns: 1fr; } }

/* ===== WIZARD ===== */
.steps {
  display:flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.step {
  width: 45%;
  text-align: center;
  padding: 10px;
  border-bottom: 3px solid #ccc;
}

.step.active {
  border-bottom: 3px solid #0d6efd;
  font-weight: bold;
}

.step-content {
  display:none;
}

.step-content.active {
  display:block;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
  body {
    flex-direction: column;
  }

  .left-section, .right-section {
    width: 100%;
    height: 50%;
  }

  .grid-2 {
    grid-template-columns: 1fr;
  }
}

    </style>
</head>
<body>

<div class="left-section"></div>

<div class="right-section">
    <div class="form-box">
        <h2>Registro de Empresa</h2>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- ERRORES DE VALIDACIÓN --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left:15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="wizardForm" action="{{ route('empresa.registrar.store') }}" method="POST">
@csrf

<!-- PROGRESO -->
<div class="steps">
    <div class="step active" data-step="1"><br><small>Datos personales</small></div>
    <div class="step" data-step="2"><br><small>Datos legales</small></div>
</div>

<!-- PASO 1 -->
<div class="step-content active" data-step="1">
    <h4>Datos del Representante</h4>

    <label>Nombre del Representante</label>
    <input type="text" name="nombre" required placeholder="Ingrese el nombre del represtante">
    <br><br>
    <label>Teléfono</label>
    <input type="text" name="telefono">
    <br><br>
    <label>Correo Electrónico</label>
    <input type="email" name="email" required>
    <br><br>
    

    <button type="button" onclick="nextStep()">Siguiente</button>
</div>

<!-- PASO 2 -->
<div class="step-content" data-step="2">
    <h4>Datos de la Empresa</h4>

    <label>Razón Social</label>
    <input type="text" name="razon_social" required>

    <label>NIT</label>
    <input type="text" name="nit" id="nit" required>

    <div id="nitError" class="text-danger" style="display:none;"></div>

    <button type="button" onclick="prevStep()">Atrás</button>
    <button type="submit">Registrar Empresa</button>
</div>
</form>

        <div class="link">
            ¿Ya tienes cuenta? <a href="/login">Inicia Sesión</a>
        </div>
    </div>
</div>




<script>
let currentStep = 1;

function showStep(step) {
    document.querySelectorAll('.step-content').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));

    document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');
    document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
}

function nextStep() {
    currentStep++;
    showStep(currentStep);
}

function prevStep() {
    currentStep--;
    showStep(currentStep);
}
</script>

</body>
</html>



