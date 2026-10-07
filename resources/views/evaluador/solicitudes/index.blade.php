@extends('layouts.admin')

<!-- ESTO TAMBIÉN LO ESTÁ USANDO EL ADMINISTRADOR -->

@section('contenido')

<div class="container mt-4">

<h2 class="mb-4">Solicitudes Recepcionadas</h2>

@if(session('success'))

    <div id="alert-success" class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if ($solicitudes->isEmpty())

    <div class="alert alert-info text-center">
        No existen solicitudes pendientes o en revisión.
    </div>

@else

    <table class="table table-bordered table-striped">

        <thead class="bg-dark text-white">

            <tr>
                <th>Empresa</th>
                <th>Marca</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>

        </thead>


        <tbody>

            @foreach ($solicitudes as $s)

                <tr>

                    <td>
                        {{ $s->empresa->razon_social ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $s->marca }}
                    </td>


                    <td>

                        <span class="badge
                            @if($s->estado == 'Pendiente')
                                bg-warning
                            @elseif($s->estado == 'en_revision')
                                bg-info
                            @endif
                        ">

                            {{ $s->estado }}

                        </span>

                    </td>


                    <td>
                        {{ $s->created_at->format('d/m/Y') }}
                    </td>


                    <td>

                        <a href="{{ route('evaluador.solicitudes.show', $s->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="fa fa-eye"></i>
                            Revisar

                        </a>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endif


</div>

@endsection

@push('scripts')

<script>

setTimeout(() => {

    let alert =
        document.getElementById('alert-success');

    if (alert) {

        alert.style.transition =
            "opacity 0.5s";

        alert.style.opacity = 0;

        setTimeout(() => {
            alert.remove();
        }, 500);

    }

}, 1000);

</script>

@endpush
