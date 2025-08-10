@extends('layouts.menu')
@section('contenido')

    <div class="container mt-4">
        @if (session('mensaje'))
            @include('layouts.alertas', [
                'title' => session('type') == 'Danger' ? 'Error' : 'Info',
                'message' => session('mensaje'),
                'type' => session('type'),
            ])
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Registrar nuevo producto</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('productos.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="{{ old('nombre') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca"
                                value="{{ old('marca') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del producto</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                            value="{{ old('descripcion') }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" id="precio" step="0.01"
                                value="{{ old('precio') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="imagen_url" class="form-label">Imagen del producto</label>
                            <input type="file" class="form-control" id="imagen_url" name="imagen_url" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <div class="input-group">
                            <select class="form-select" name="categoria_id" id="categoria_id">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalAgregarCategoria">+</button>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="subcategoria_id" class="form-label">Subcategoría</label>
                        <div class="input-group">
                            <select class="form-select" name="subcategoria_id" id="subcategoria_id">
                                <option value="">Seleccione una subcategoría</option>
                                @foreach ($subcategorias as $subcategoria)
                                    <option value="{{ $subcategoria->id }}"
                                        {{ old('subcategoria_id') == $subcategoria->id ? 'selected' : '' }}>
                                        {{ $subcategoria->subcategoria }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalAgregarSubcategoria">+</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subcategoria_id" class="form-label">Sub-sub-categoría</label>
                        <div class="input-group">
                            <select class="form-select" name="parent_id" id="sub-sub-categoria_id">
                                <option value="">Seleccione una subsubcategoría</option>
                                @foreach ($subsubcategorias as $otrascategoria)
                                    <option value="{{ $otrascategoria->id }}"
                                        {{ old('parent_id') == $subcategoria->parent_id ? 'selected' : '' }}>
                                        {{ $otrascategoria->subcategoria }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalAgregarSubSubcategoria">+</button>
                        </div>
                    </div>
                    {{--  --}}

                    <div class="mb-4">
                        <label class="form-label">Variantes de inventario</label>
                        <div id="variantes-container">
                            <div class="row g-2 align-items-end variante-item mb-2">
                                <div class="col-md-3">
                                    <select name="variantes[0][talla_id]" class="form-select">
                                        <option value="">Talla</option>
                                        @foreach ($tallas as $talla)
                                            <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100"
                                        data-bs-toggle="modal" data-bs-target="#modalAgregarTalla">+</button>
                                </div>

                                <div class="col-md-3">
                                    <select name="variantes[0][color_id]" class="form-select">
                                        <option value="">Color</option>
                                        @foreach ($colores as $color)
                                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100"
                                        data-bs-toggle="modal" data-bs-target="#modalAgregarColor">+</button>
                                </div>

                                <div class="col-md-4">
                                    <input type="number" name="variantes[0][stock]" min="0" class="form-control"
                                        placeholder="Stock">
                                </div>
                            </div>
                        </div>
                        <button type="button" id="agregar-variante" class="btn btn-sm btn-outline-secondary mt-2">
                            + Agregar otra combinación
                        </button>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-dark">Registrar producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para clonar variantes --}}
    <script>
        let contador = 1;
        document.getElementById('agregar-variante').addEventListener('click', function() {
            const contenedor = document.getElementById('variantes-container');
            const nuevaVariante = document.querySelector('.variante-item').cloneNode(true);

            nuevaVariante.querySelectorAll('select, input').forEach(el => {
                if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else el.value = '';
                if (el.name.includes('variantes')) {
                    el.name = el.name.replace(/\[\d+\]/, `[${contador}]`);
                }
            });

            contador++;
            contenedor.appendChild(nuevaVariante);
        });
    </script>

    {{-- Modales --}}
    @include('modales.agregar_talla')
    @include('modales.agregar_categoria')
    @include('modales.agregar_subcategorias')
    @include('modales.agregar_otrascategorias')
    @include('modales.agregar_color')

@endsection
