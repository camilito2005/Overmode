@extends('layouts.menu')

@section('title', 'Perfil')
@section('name', 'Perfil de Usuario')

@section('contenido')
<h2>Bienvenido, {{ $usuario->nombre }} {{ $usuario->apellido }}</h2>
<p>DNI: {{ $usuario->dni }}</p>
<p>Correo: {{ $usuario->correo }}</p>
<p>Teléfono: {{ $usuario->telefono }}</p>
<p>Dirección: {{ $usuario->direccion }}</p>
<p>Rol ID: {{ $usuario->rol_id }}</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>
@endsection
