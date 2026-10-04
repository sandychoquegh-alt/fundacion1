@extends('layouts.app')

@section('content')

<a href="{{ route('solicitud.create') }}" class="btn btn-success">
    <i class="fa fa-upload"></i> Solicitar Certificado VAON
</a>

<div class="container mt-5">
    <h3>Bienvenido, {{ Auth::user()->nombre }}</h3>
    <p>Rol: {{ Auth::user()->rol }}</p>

    <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
</div>
@endsection

