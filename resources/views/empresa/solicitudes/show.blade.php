@extends('layouts.admin')

@section('contenido')
<h2 class="text-2xl font-bold mb-4">Detalle de Solicitud</h2>

<div class="box">
    <!-- BOTÓN VOLVER -->
<a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Volver</a>


    <div class="box-body">

        <div class="row">
            <div class="col-md-6">
               
                <p><strong>Producto:</strong> {{ $solicitud->producto_nombre }}</p>
                <p><strong>Fecha:</strong> {{ $solicitud->created_at->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> 
                    <span class="label label-success">Aprobada</span>
                </p>
            </div>

            <div class="col-md-6">
                <h4>Datos de la Empresa</h4>
                <p><strong>Nombre:</strong> {{ $solicitud->empresa->razon_social ?? 'Sin empresa' }}</p>
               
            </div>
        </div>

        <hr>

    </div>
</div>



<hr>

<h4>Productos de la Solicitud</h4>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acion</th>
            </tr>
        </thead>
      <tbody>
    @forelse($solicitud->productos as $prod)
    <tr>
        <td>{{ $prod->nombre }}</td>
        <td>{{ $prod->descripcion ?? 'Sin descripción' }}</td>
        <td>
            <button type="button"
                class="btn btn-primary btn-open-cert"
                data-toggle="modal"
                data-target="#modalCertificado"
                data-id="{{ $prod->id }}"  {{-- ✅ producto_id --}}
                data-empresa="{{ $solicitud->empresa_id }}" {{-- ✅ empresa_id --}}
                data-producto="{{ $prod->nombre }}"
                data-empresa-nombre="{{ $solicitud->empresa->razon_social ?? 'Sin empresa' }}">
                
                Generar Certificado
            </button>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-center">
            No hay productos registrados
        </td>
    </tr>
    @endforelse
</tbody>
    </table>
</div>

@endsection

{{-- MODAL --}}
@include('certificados.modalCertificado')

{{-- SCRIPTS --}}
@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const botones = document.querySelectorAll(".btn-open-cert");

    botones.forEach(btn => {
        btn.addEventListener("click", function () {
            let id = this.dataset.id;
            let empresa = this.dataset.empresa;
            let producto = this.dataset.producto;
            let empresaNombre = this.dataset.empresaNombre;

           
            console.log("Empresa:", empresa);
            console.log("Producto:", producto);
            console.log("Empresa Nombre:", empresaNombre);

            // Aquí luego puedes llenar inputs del modal
        });
    });
});
</script>