@extends('layouts.empresad')

@section('contenido')
<div class=" box-primar ">
    <form id="formAnexoB" action="#" method="POST">
                @csrf

    <h3 class="text-center mb-3"><strong>ANEXO B</strong></h3>
    <h4 class="text-center mb-4"><strong>DECLARACIÓN JURADA<br>(Por producto y marca comercial)</strong></h4>

    <!-- CARTA -->
    <div class="row">
    <!-- =============================================== -->
    <!--   AQUI ESTOY PONIENDO EL FORMULARIO (IZQUIERDA) -->
    <!-- ==================================================== -->
    <div class="col-md-6">
        <div class="card p-4 border">

            

                <h4><strong>Datos de la Empresa</strong></h4>

                <div class="form-group col-md-6">
                    <label>Representante Legal *</label>
                    <input type="text" name="representante" id="representante" class="form-control" placeholder="Nombre completo" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Cédula de Identidad *</label>
                    <input type="text" name="ci" id="ci" class="form-control" placeholder="C.I." required>
                </div>

                <div class="form-group col-md-6">
                    <label>Empresa *</label>
                    <input type="text" name="empresa" id="empresa" class="form-control" placeholder="Razón Social" required>
                </div>

                <div class="form-group col-md-6">
                    <label>NIT *</label>
                    <input type="text" name="nit" id="nit" class="form-control" placeholder="NIT" required>
                </div>

                

                <button class="btn btn-primary mt-3" type="submit">Guardar Anexo B</button>

          

        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- Y AQUI SE ESTA PONIENDO LA VISTA PREVIA DE LA CARTA (DERECHA) -->
    <!-- ================================================================== -->
    <div class="col-md-6">
        <div class="card p-4 border bg-light">
            <h4 class="text-center"><strong>Vista Previa de la Carta</strong></h4>
            <hr>

            <div id="previewCarta" style="white-space: pre-line; font-size: 15px; line-height: 1.6;">
                <!-- Aquí se mostrará en vivo la carta generada -->
                <p><em>Complete los datos del formulario para ver la carta...</em></p>
            </div>
        </div>
    </div>
</div>
    <hr>

    <!-- VAON FORMULA -->
    <div class="alert alert-info col-md-4">
        <strong>Fórmula del cálculo VAON</strong><br>
        %VAON = ( CTPN / (CTPN + CTPI) ) × 100
    </div>
    <br><br><br>
    <hr>
    <!-- ================= BLOQUES DINÁMICOS ================= -->
<div id="contenedorBloques">
<div class="informacion">
        <div class="informacion-producto p-3 border rounded" style="background-color: #f9f9f9;">
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-4 mb-3">
            <label for="organizacion" class="form-label"><strong>Organización:</strong></label>
            <input type="text" id="organizacion" name="organizacion[]" class="form-control" 
                   value="COBOCE RL. – UNIDAD CERÁMICA">
        </div>

        <div class="col-md-4 mb-3">
            <label for="producto" class="form-label"><strong>Producto:</strong></label>
            <input type="text" id="producto" name="producto[]" class="form-control" 
                   value="Baldosas cerámicas esmaltadas prensadas en seco para paredes 3% < Ev ≤ 6%, grupo BIIa, formato 30x45">
        </div>
    </div>

    <div class="row">
        <!-- Columna 2 -->
        <div class="col-md-4 mb-3">
            <label for="marca" class="form-label"><strong>Marca comercial:</strong></label>
            <input type="text" id="marca" name="marca[]" class="form-control" 
                   value="COBOCE CERÁMICA">
        </div>

        <div class="col-md-4 mb-3">
            <label for="direccion" class="form-label"><strong>Dirección y Lugar de fabricación:</strong></label>
            <input type="text" id="direccion" name="direccion[]" class="form-control" 
                   value="Av. Barrientos km. 11 acera Norte Nº 685, Sacaba, Cochabamba – Bolivia">
        </div>
    </div>



    <!-- TABLAS DE COSTOS NACIONAL -->
    <h5 class=""><strong>Detalle de Costo Total Producción Nacional</strong></h5>

    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                <th>Costo Unitario (BOB)</th>
                <th>Costo Total (BOB)</th>
            </tr>
        </thead>
        <tbody class="tablaMateriales">
            <!-- Materiales nacionales -->
            <tr><td colspan="5" class="bg-light"><strong>1. Materia Prima Nacional</strong></td></tr>
            <tr class="mpn-fila">
                <td>
                    <input type="text" name="mpn_desc[0][]" class="form-control" placeholder="Ej.Azucar, quinua, maiz, aroz," required></td>
                <td><input type="text" name="mpn_unidad[0][]" class="form-control" placeholder="Ej.kg, g, lb, mg." required></td>
                <td><input type="text"  name="mpn_cantidad[0][]" class="form-control" placeholder="Ej.100, 200...." required></td>
                <td><input type="text"  name="mpn_unitario[0][]" class="form-control" placeholder="Ej. 1.50, 2.00...." required></td>
                <td><input type="text"  name="mpn_total[0][]" class="form-control"placeholder="Ej.poner 200.00 , 300.00.....)" required></td>
                <td><button type="button" class="btn btn-danger btn-sm eliminarFila"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
              <tr>
        <td colspan="5">
            <button type="button" class="btn btn-info addFila" data-prefijo="mpn_">
                <i class="fa-solid fa-circle-plus"></i> Agregar Materia Prima
            </button>
        </td>
    </tr>

            <!-- Insumos nacionales -->
            <tr><td colspan="5" class="bg-light"><strong>2. Insumos Nacionales</strong></td></tr>
            <tr class="insn-fila">
                <td><input type="text" name="insn_desc[0][]" class="form-control" placeholder="Ej.Envase PET, Energía (mes proporcional)"></td>
                <td><input type="text" name="insn_unidad[0][]" class="form-control" placeholder="Ej. unidad, mes...."></td>
                <td><input type="textr"  name="insn_cantidad[0][]" class="form-control" placeholder="Ej. 100 , 1 ...."></td>
                <td><input type="text"  name="insn_unitario[0][]" class="form-control" placeholder="Ej. 0.50 , 100.00......"></td>
                <td><input type="text"  name="insn_total[0][]" class="form-control" placeholder="Ej. 50.00 , 100.00......"></td>
                <td> <button type="button" class="btn btn-danger btn-sm eliminarFila"><i class="fa-solid fa-trash"></i></button></td>
                
            </tr>
            <tr>
        <td colspan="5">
            <button type="button" class="btn btn-info addFila" data-prefijo="insn_">
                <i class="fa-solid fa-circle-plus"></i> Agregar Insumo
            </button>
        </td>
    </tr>

            <!-- Mano de obra nacional -->
            <tr><td colspan="5" class="bg-light"><strong>3. Mano de Obra Nacional</strong></td></tr>
            <tr class="mon-fila">
                <td><input type="text" name="mon_desc[0][]" class="form-control" placeholder="Ej. Sueldos (proporcional al producto)" re></td>
                <td><input type="text" name="mon_unidad[0][]" class="form-control" placeholder="Ej. mes"></td>
                <td><input type="text"  name="mon_cantidad[0][]" class="form-control" placeholder="Ej. 1"></td>
                <td><input type="text" name="mon_unitario[0][]" class="form-control" placeholder="Ej. 300.00"></td>
                <td><input type="text"  name="mon_total[0][]" class="form-control" placeholder=" Ej. 300.00"></td>
                <td><button type="button" class="btn btn-danger btn-sm eliminarFila"><i class="fa-solid fa-trash"></i> </button></td>
            </tr>
            <tr>
        <td colspan="5">
            <button type="button" class="btn btn-info addFila" data-prefijo="mon_">
                <i class="fa-solid fa-circle-plus"></i> Agregar Mano de Obra
            </button>
        </td>
    </tr>
        
        </tbody>
        
    </table>
</div><!-- aqui se terminan para el div informacion -->
</div>
<button type="button" class="btn btn-info mt-2" id="addBloque">
    <i class="fa-solid fa-circle-plus"></i> Agregar DECLARACIÓN DE % VAON informacion
</button>
    <hr>

    <!-- TABLAS DE COSTOS IMPORTADOS -->
   

    <hr>

    <button class="btn btn-danger mt-3" type="submit"
        formaction="{{ route('empresa.anexoB.anexoB-pdf') }}"
        formtarget="_blank">
    Descargar ANEXO B en PDF
</button>

  </form>
</div>

@endsection


<!-- ===================== -->
<!--   SCRIPT VISTA PREVIA EN VIVO   -->
<!-- ===================== -->

@push('scripts')
<script>
function generarCarta() {
    let rep  = document.getElementById("representante").value || "________________";
    let ci   = document.getElementById("ci").value || "__________";
    let emp  = document.getElementById("empresa").value || "_________________________";
    let nit  = document.getElementById("nit").value || "__________";

    let carta = `
Yo, ${rep}, con C.I. Nº ${ci},
en calidad de Representante Legal de la empresa ${emp}, con NIT Nº ${nit},
declaro que  los  datos  que  preceden  son  verdaderos  y  garantizo 
 su  autenticidad,  entiendo  que  brindar información falsa contraviene
  los términos de la convocatoria, siendo esta conducta conocida como un 
  hecho ilícito, subsumible(s) a los tipos penales de Falsedad Material
   y/o Falsedad Ideológica y/o Uso de Instrumento falsificado, dentro de 
   la normativa de la legislación boliviana en los art. 198, 199, y 200 del
    Código Penal Boliviano. 
Asimismo,  acepto  participar  en  proceso  de  verificación  de  acuerdo 
 a  los  requisitos  VAON  y  del organismo  de  verificación  y  que 
  esta  evaluación  se  realizará  en  el  marco  de  confidencialidad 
   entre ambas partes.
   

   ${rep}
______________________________________
Firma del Representante Legal
    `;

    document.getElementById("previewCarta").textContent = carta;
}

// Ejecutar en tiempo real
document.addEventListener("input", generarCarta);

// Cargar una vista inicial
window.onload = generarCarta;
</script>



<script>
document.addEventListener("click", function(e) {

    // ============================
    // ➕ AGREGAR FILA POR SECCIÓN
    // ============================
    if (e.target.closest(".addFila")) {

        let boton = e.target.closest(".addFila");
        let prefijo = boton.getAttribute("data-prefijo");

        let bloque = boton.closest(".informacion");
        let tabla = bloque.querySelector(".tablaMateriales");

        let inputs = tabla.querySelectorAll(`input[name^="${prefijo}"]`);
        if (inputs.length === 0) return;

        let ultimaFila = inputs[inputs.length - 1].closest("tr");

        // 🔴 VALIDAR
        let incompletos = Array.from(ultimaFila.querySelectorAll("input"))
            .filter(i => i.value.trim() === "");

        if (incompletos.length > 0) {
            incompletos[0].focus();
            incompletos.forEach(i => i.classList.add("is-invalid"));

            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Completa la fila antes de agregar otra.'
            });
            return;
        }

        // 🔥 CLONAR FILA
        let nueva = ultimaFila.cloneNode(true);

        nueva.querySelectorAll("input").forEach(i => {
            i.value = "";
            i.classList.remove("is-invalid");
        });

        ultimaFila.parentNode.insertBefore(nueva, ultimaFila.nextSibling);
    }


    // ============================
    // 🗑️ ELIMINAR FILA
    // ============================
    if (e.target.closest(".eliminarFila")) {

        let fila = e.target.closest("tr");
        let bloque = fila.closest(".informacion");
        let tabla = bloque.querySelector(".tablaMateriales");

        let input = fila.querySelector("input");
        if (!input) return;

        let prefijo = input.name.split("_")[0] + "_";

        let filas = tabla.querySelectorAll(`input[name^="${prefijo}"]`);

        if (filas.length <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'No permitido',
                text: 'Debe existir al menos una fila.'
            });
            return;
        }

        fila.remove();
    }

});
</script>

<script>
document.getElementById("addBloque").addEventListener("click", function () {

    if (this.disabled) return;
    this.disabled = true;

    // ✅ contenedor correcto
    let contenedor = document.getElementById("contenedorBloques");

    // ✅ bloques actuales
    let bloques = contenedor.querySelectorAll(".informacion");

    let index = bloques.length; // 0,1,2...

    let ultimo = bloques[bloques.length - 1];
    let nuevo = ultimo.cloneNode(true);

    // 🔥 limpiar y actualizar nombres
    nuevo.querySelectorAll("input").forEach(input => {

        input.value = "";
        input.classList.remove("is-invalid");

        if (input.name) {

          // 🔥 SOLO aplicar índice a tablas (mpn, insn, mon)
            if (
                input.name.includes("mpn_") ||
                input.name.includes("insn_") ||
                input.name.includes("mon_")
            ) {

            // 👉 CASO 1: ya tiene índice [0]
            if (input.name.match(/\[\d+\]/)) {
                input.name = input.name.replace(/\[\d+\]/, '[' + index + ']');
            } 
            // 👉 CASO 2: no tiene índice (primer bloque mal definido)
            else if (input.name.includes("[]")) {
                input.name = input.name.replace("[]", '[' + index + '][]');
            }
        }
        // ✅ estos NO se tocan
            // organizacion[], producto[], marca[], direccion[]
        }
    });

    // ✅ limpiar textareas si existen
    nuevo.querySelectorAll("textarea").forEach(t => t.value = "");

    // ✅ evitar conflictos de IDs
    nuevo.querySelectorAll("[id]").forEach(el => el.removeAttribute("id"));

    // ✅ agregar bloque
    contenedor.appendChild(nuevo);

    // desbloquear botón
    setTimeout(() => {
        this.disabled = false;
    }, 300);
});
</script>

@endpush
