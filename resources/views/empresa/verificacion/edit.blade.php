@extends('layouts.empresad')

@section('contenido')
<div class="box">
    <div class="box-header">
        <h3>Editar Anexo A</h3>
    </div>

    <div class="box-body">
        <form action="{{ route('empresa.verificacion.anexoA', $empresa->id) }}" method="POST">
            @csrf

            <label>Razón Social</label>
            <input type="text" name="razon_social" value="{{ $empresa->razon_social }}" class="form-control">

            <label>NIT</label>
            <input type="text" name="nit" value="{{ $empresa->nit }}" class="form-control">

            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ $empresa->direccion }}" class="form-control">

            <label>Representante Legal</label>
            <input type="text" name="representante" value="{{ $empresa->representante }}" class="form-control">

            <label>Cargo</label>
            <input type="text" name="cargo" value="{{ $empresa->cargo }}" class="form-control">

            <label>Persona contacto</label>
            <input type="text" name="persona_contacto" value="{{ $empresa->persona_contacto }}" class="form-control">

            <label>Email</label>
            <input type="email" name="correo" value="{{ $empresa->correo }}" class="form-control">

            <label>Telefono</label>
            <input type="text" name="telefono" value="{{ $empresa->telefono }}" class="form-control">

            <label>Celular</label>
            <input type="text" name="celular" value="{{ $empresa->celular }}" class="form-control">

            <br>

            <button class="btn btn-success">Guardar Cambios</button>
        </form>
    </div>

</div>
@endsection
