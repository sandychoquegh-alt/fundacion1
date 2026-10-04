@extends('layouts.empresad')

@section('contenido')
<div class="box">
    <div class="box-header">
        <h3>Información registrada - Anexo A</h3>
    </div>

    <div class="box-body">

        <h4>1. Datos de la organización</h4>
        <p><strong>Razón Social:</strong> {{ $empresa->razon_social }}</p>
        <p><strong>NIT:</strong> {{ $empresa->nit }}</p>
        <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>

        <hr>

        <h4>2. Representante Legal</h4>
        <p><strong>Nombre:</strong> {{ $empresa->representante }}</p>
        <p><strong>Cargo:</strong> {{ $empresa->cargo }}</p>

        <hr>

        <h4>3. Persona de contacto</h4>
        <p><strong>Nombre:</strong> {{ $empresa->persona_contacto }}</p>
        <p><strong>Email:</strong> {{ $empresa->email }}</p>
        <p><strong>Teléfono:</strong> {{ $empresa->telefono }}</p>
        <p><strong>Celular:</strong> {{ $empresa->celular }}</p>

        <br>

        <a href="{{ route('empresa.verificacion.edit', $empresa->id) }}" class="btn btn-warning">
            Editar información
        </a>

        <a href="{{ route('empresa.verificacion.pdf', $empresa->id) }}" class="btn btn-primary">
            Descargar PDF
        </a>
        

    </div>
</div>
@endsection
