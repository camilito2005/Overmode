@extends('layouts.menu')
@section('contenido')
<div class="container my-4">
@if (session('mensaje'))
    @include('layouts.alertas', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
    
@endif
    {{-- Categorías --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Categorías</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">Agregar</button>
        </div>
        <div class="card-body p-0">
            @include('tallas_colores_categorias.partes.categorias')
        </div>
    </div>

    {{-- Tallas --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tallas</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarTalla">Agregar</button>
        </div>
        <div class="card-body p-0">
            @include('tallas_colores_categorias.partes.tallas')
        </div>
    </div>

    {{-- Colores --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Colores</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarColor">Agregar</button>
        </div>
        <div class="card-body p-0">
            @include('tallas_colores_categorias.partes.colores')
        </div>
    </div>

</div>
 {{-- Modales para agregar talla, categoría y color --}}
    @include('modales.agregar_talla')
    @include('modales.agregar_categoria')
    @include('modales.agregar_color')

@endsection
