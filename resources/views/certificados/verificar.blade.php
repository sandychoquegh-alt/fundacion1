<div style="max-width: 750px; margin: 60px auto; font-family: 'Segoe UI', Tahoma, sans-serif; border: 1px solid #dcdcdc; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.08); background: #fff;">

    <!-- HEADER -->
    <div style="background: #1f3a5f; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0; font-weight: 600;">
            <i class="fa-solid fa-circle-check"></i> Certificado Verificado
        </h2>
        <small style="opacity: 0.9;">Sistema Oficial de Validación</small>
    </div>

    <!-- ESTADO -->
    <div style="text-align:center; margin-top:20px;">

    @if($verificar == 'valido')
        <span style="background:#198754; color:white; padding:8px 20px; border-radius:20px;">
            <i class="fa-solid fa-circle-check"></i>VÁLIDO
        </span>

    @elseif($verificar == 'vencido')
        <span style="background:#ffc107; color:black; padding:8px 20px; border-radius:20px;">
         <i class="fa-solid fa-triangle-exclamation"></i> VENCIDO
        </span>

    @else
        <span style="background:#dc3545; color:white; padding:8px 20px; border-radius:20px;">
            <i class="fa-solid fa-triangle-exclamation"></i> NO VÁLIDO
        </span>
    @endif

</div>

    <!-- BODY -->
    <div style="padding: 30px;">

        <!-- CÓDIGO DESTACADO -->
        <div style="text-align:center; margin-bottom: 20px;">
            <div style="font-size: 14px; color:#777;">Código de Certificación</div>
            <div style="font-size: 22px; font-weight: bold; letter-spacing:1px;">
                {{ $certificado->codigo }}
            </div>
        </div>

        <table style="width:100%; border-collapse: collapse; font-size: 15px;">
            
            <tr>
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-box"></i> <strong>Producto</strong>
                </td>
                <td style="padding: 10px; text-align:right;">
                    {{ $certificado->producto }}
                </td>
            </tr>

            <tr style="border-top:1px solid #eee;">
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-building"></i> <strong>Empresa</strong>
                </td>
                <td style="padding: 10px; text-align:right;">
                    {{ $certificado->empresa_id ?? 'N/A' }}
                </td>
            </tr>

            <tr style="border-top:1px solid #eee;">
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-location-dot"></i> <strong>Lugar de Fabricación</strong>
                </td>
                <td style="padding: 10px; text-align:right;">
                    {{ $certificado->lugar_fabricacion }}
                </td>
            </tr>

            <tr style="border-top:1px solid #eee;">
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-percent"></i> <strong>Porcentaje VAON</strong>
                </td>
                <td style="padding: 10px; text-align:right;">
                    {{ $certificado->porcentaje_vaon }} %
                </td>
            </tr>

            <tr style="border-top:1px solid #eee;">
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-calendar-days"></i> <strong>Fecha de Emisión</strong>
                </td>
                <td style="padding: 10px; text-align:right;">
                    {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
                </td>
            </tr>

            <tr style="border-top:1px solid #eee;">
                <td style="padding: 10px; color:#555;">
                    <i class="fa-solid fa-calendar-xmark"></i> <strong>Vigencia hasta</strong>
                </td>
                <td style="padding: 10px; text-align:right; color:#b02a37; font-weight:500;">
                    {{ \Carbon\Carbon::parse($certificado->fecha_vencimiento)->format('d/m/Y') }}
                </td>
            </tr>

        </table>

        <!-- QR (OPCIONAL) -->
        @isset($qr)
        <div style="text-align:center; margin-top: 30px;">
            {!! $qr !!}
            <p style="font-size:12px; color:#777;">Escanee para verificar autenticidad</p>
        </div>
        @endisset

        <!-- BOTÓN -->
        <div style="text-align:center; margin-top: 30px;">
            <a href="{{ asset('storage/'.$certificado->archivo_pdf) }}" 
               target="_blank"
               style="background:#0d6efd; color:white; padding:12px 30px; text-decoration:none; border-radius:5px; font-weight:500;">
                <i class="fa-solid fa-file-pdf"></i> Ver Documento PDF
            </a>
        </div>

    </div>

    <!-- FOOTER -->
    <div style="background:#f1f3f5; text-align:center; padding:12px; font-size:13px; color:#555;">
        <i class="fa-solid fa-shield-halved"></i> Validación electrónica segura |
        Documento generado automáticamente
    </div>

</div>