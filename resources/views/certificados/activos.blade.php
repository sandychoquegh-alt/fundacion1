@extends('layouts.admin')

@section('contenido')
<h2>Certificados Activos</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Vence</th>
            <th>Estado</th>
            <th>Pago</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($certificados as $c)

        @php
            $hoy = \Carbon\Carbon::now();

            // ESTE ESTADO SE MANTIENE IGUAL
            $estado = $c->fecha_vencimiento >= $hoy ? 'valido' : 'vencido';
        @endphp

        <tr>

            {{-- CÓDIGO --}}
            <td>
                {{ $c->codigo }}
            </td>

            {{-- PRODUCTO --}}
            <td>
                {{ $c->producto }}
            </td>

            {{-- VENCIMIENTO --}}
            <td>
                {{ \Carbon\Carbon::parse($c->fecha_vencimiento)->format('d/m/Y') }}
            </td>

            {{-- ESTADO ACTUAL --}}
            <td>

                @if($estado == 'valido')

                    <span style="background:#198754; color:white; padding:5px 12px; border-radius:12px; font-size:13px;">
                        <i class="fa-solid fa-circle-check"></i>
                        VÁLIDO
                    </span>

                @else

                    <span style="background:#ffc107; color:black; padding:5px 12px; border-radius:12px; font-size:13px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        VENCIDO
                    </span>

                @endif

            </td>


            {{-- ESTADO DE PAGO --}}
            <td>

                @if($c->estados == 'pagado')

                    <span style="background:#198754; color:white; padding:5px 10px; border-radius:12px; font-size:12px;">
                        <i class="fa-solid fa-check"></i>
                        PAGADO
                    </span>

                @else

                    <span style="background:#ffc107; color:black; padding:5px 10px; border-radius:12px; font-size:12px;">
                        <i class="fa-solid fa-clock"></i>
                        PENDIENTE
                    </span>

                @endif

            </td>


            {{-- ACCIONES --}}
            <td>

           

    {{-- VER PDF --}}
    <a href="{{ asset('storage/'.$c->archivo_pdf) }}" 
       target="_blank"
       class="btn btn-sm btn-primary"
       title="Ver PDF">
        <i class="fa-solid fa-eye"></i>
    </a>

    {{-- DESCARGAR PDF --}}
    <a href="{{ asset('storage/'.$c->archivo_pdf) }}" 
       download
       class="btn btn-sm btn-success"
       title="Descargar PDF">
        <i class="fa-solid fa-download"></i>
    </a>

    {{-- VERIFICAR --}}
    <a href="{{ route('certificados.verificar', $c->codigo) }}" 
       target="_blank"
       class="btn btn-sm btn-secondary"
       title="Verificar">
        <i class="fa-solid fa-shield-halved"></i>
    </a>


    {{-- PAGADO --}}
    <form action="{{ route('certificados.estado', $c->id) }}"
          method="POST"
          class="form-pago"
          style="display:inline-block;">

        @csrf

        <input type="hidden" name="estados" value="pagado">

        <button type="submit"
                class="btn btn-sm btn-success">
            <i class="fa-solid fa-circle-check"></i>
            Pagado
        </button>

    </form>


    {{-- NO PAGADO --}}
    <form action="{{ route('certificados.estado', $c->id) }}"
          method="POST"
          class="form-pago"
          style="display:inline-block;">

        @csrf

        <input type="hidden" name="estados" value="no_pagado">

        <button type="submit"
                class="btn btn-sm btn-warning">
            <i class="fa-solid fa-clock"></i>
            No pagado
        </button>

    </form>

</td>
            

        </tr>

        @endforeach
    </tbody>
</table>


{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-pago').forEach(function(form) {

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            const estado = form.querySelector('input[name="estados"]').value;

            if (estado === 'pagado') {

                Swal.fire({
                    title: '¿Confirmar pago?',
                    text: 'El estado del certificado cambiará a PAGADO.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, confirmar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            } else {

                Swal.fire({
                    title: '¿Marcar como no pagado?',
                    text: 'El estado del certificado cambiará a NO PAGADO.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, cambiar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            }

        });

    });

});

</script>

@endsection