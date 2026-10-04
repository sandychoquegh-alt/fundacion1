<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 13px;
    line-height: 1.5;
    margin:45px;
}

h3, h4, h5 {
    text-align: center;
    margin: 0;
    padding: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
}

td, th {
    border: 1px solid #000;
    padding: 5px;
    font-size: 12px;
}

.bg {
    background: #eaeaea;
    font-weight: bold;
}

.section-title {
    font-weight: bold;
    font-size: 15px;
    margin-top: 15px;
    text-align: left;
}

.firma {
    text-align: center;
    margin-top: 40px;
    font-size: 14px;
}

</style>
</head>
<body>

<!-- ========================= -->
<!-- TITULO PRINCIPAL -->
<!-- ========================= -->
  <div style:margin:45px;>
<h3><strong>ANEXO B</strong></h3>
<h4><strong>DECLARACIÓN JURADA<br>(Por Producto Y Marca Comercial)</strong></h4>
<br>

<!-- ========================= -->
<!-- CARTA COMPLETA -->
<!-- ========================= -->


<p>
Yo, <strong>{{ $data['representante'] }}</strong>, con C.I. Nº <strong>{{ $data['ci'] }}</strong>,
en calidad de Representante Legal de la empresa <strong>{{ $data['empresa'] }}</strong>,
con NIT Nº <strong>{{ $data['nit'] }}</strong>, declaro que los datos que preceden son verdaderos
y garantizo su autenticidad.
</p>

<p>
Entiendo que brindar información falsa contraviene los términos de la convocatoria,
siendo un hecho ilícito, subsumible a los tipos penales de Falsedad Material,
Falsedad Ideológica y Uso de Instrumento Falsificado, conforme a los Arts. 198, 199 y 200 del Código Penal Boliviano.
</p>

<p>
Asimismo, acepto participar en el proceso de verificación de acuerdo a los requisitos VAON
y del organismo verificador, bajo confidencialidad entre ambas partes.
</p>

<br><br>
<div class="firma">
__________________________________________  
<br>
<strong>Firma del Representante Legal</strong><br>
{{ $data['representante'] }}
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<!-- ========================= -->
<!-- FORMULA VAON -->
<!-- ========================= -->

<h4 class="section-title">Fórmula del cálculo VAON</h4>
<p><strong>%VAON = ( CTPN / (CTPN + CTPI) ) × 100</strong></p>

<hr>

<!-- ========================= -->
<!-- TABLA COMPLETA CTPN -->
<!-- ========================= -->
<h4 class="section-title">Detalle de Costo Total de Producción Nacional</h4>

@foreach(($data['mpn_desc'] ?? []) as $bloqueIndex => $bloque)

<div @if($bloqueIndex > 0) style="page-break-before: always;" @endif>

    <h2 style="text-align:center;">
        DECLARACIÓN VAON #{{ $bloqueIndex + 1 }}
    </h2>

    <!-- DATOS -->
    <p><strong>Organización:</strong> {{ $data['organizacion'][$bloqueIndex] ?? '' }}</p>
    <p><strong>Producto:</strong> {{ $data['producto'][$bloqueIndex] ?? '' }}</p>
    <p><strong>Marca:</strong> {{ $data['marca'][$bloqueIndex] ?? '' }}</p>
    <p><strong>Dirección:</strong> {{ $data['direccion'][$bloqueIndex] ?? '' }}</p>

    <table border="1" width="80%" cellspacing="0" cellpadding="5">

        <!-- 1. MATERIA PRIMA -->
        <tr><td colspan="5" class="bg"><strong>1. Materia Prima Nacional</strong></td></tr>

        @foreach((array)$bloque as $i => $desc)
        <tr>
            <td>{{ $desc }}</td>
            <td>{{ $data['mpn_unidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mpn_cantidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mpn_unitario'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mpn_total'][$bloqueIndex][$i] ?? '' }}</td>
        </tr>
        @endforeach

        <!-- 2. INSUMOS -->
        <tr><td colspan="5" class="bg"><strong>2. Insumos Nacionales</strong></td></tr>

        @foreach((array)($data['insn_desc'][$bloqueIndex] ?? []) as $i => $desc)
        <tr>
            <td>{{ $desc }}</td>
            <td>{{ $data['insn_unidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['insn_cantidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['insn_unitario'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['insn_total'][$bloqueIndex][$i] ?? '' }}</td>
        </tr>
        @endforeach

        <!-- 3. MANO DE OBRA -->
        <tr><td colspan="5" class="bg"><strong>3. Mano de Obra Nacional</strong></td></tr>

        @foreach((array)($data['mon_desc'][$bloqueIndex] ?? []) as $i => $desc)
        <tr>
            <td>{{ $desc }}</td>
            <td>{{ $data['mon_unidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mon_cantidad'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mon_unitario'][$bloqueIndex][$i] ?? '' }}</td>
            <td>{{ $data['mon_total'][$bloqueIndex][$i] ?? '' }}</td>
        </tr>
        @endforeach

    </table>

</div>

@endforeach

</div>

<!-- ========================= -->
<!-- TABLA CTPI -->
<!-- ========================= -->


</body>
</html>
