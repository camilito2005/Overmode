{{-- @extends('layouts.menu')

@section('contenido') --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>
    <x-guest-layout>
        <div class="mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="mb-4">
            @if (session('mensaje'))
                @include('layouts.alertas', [
                    'title' => session('type') == 'Danger' ? 'Error' : 'Info',
                    'message' => session('mensaje'),
                    'type' => session('type'),
                ])
            @endif
            <form action="{{ route('productos.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')

                <!-- Nombre -->
                <div class="mt-4">
                    <x-input-label for="nombre" :value="__('Nombre del producto')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                        :value="$producto->nombre" required autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Descripción -->
                <div class="mt-4">
                    <x-input-label for="descripcion" :value="__('Descripción del producto')" />
                    <textarea id="descripcion" class="block mt-1 w-full" name="descripcion" required>{{ $producto->descripcion }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>


                <!-- Precio -->
                <div class="mt-4">
                    <x-input-label for="precio" :value="__('Precio del producto')" />
                    <x-text-input id="precio" class="block mt-1 w-full" type="number" name="precio"
                        :value="$producto->precio" required step="0.01" />
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <!-- Categoría -->
                <div class="mt-4">
                    <x-input-label for="categoria_id" :value="__('Categoría')" />
                    <select name="categoria_id" id="categoria_id"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>

                <!-- Marca -->
                <div class="mt-4">
                    <x-input-label for="marca" :value="__('Marca')" />
                    <x-text-input id="marca" class="block mt-1 w-full" type="text" name="marca"
                        :value="$producto->marca" required />
                    <x-input-error :messages="$errors->get('marca')" class="mt-2" />
                </div>


                {{-- Combinaciones de inventario --}}
                <div id="variantes-container">
                    <x-input-label for="marca" :value="__('Combinacion')" />
                    @foreach ($inventario as $i => $variante)
                        <div class="flex space-x-4 mb-2 variante-item">
                            {{-- Talla --}}
                            <div class="flex-1">
                                <select name="variantes[{{ $i }}][talla_id]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Talla</option>
                                    @foreach ($tallasDisponibles as $talla)
                                        <option value="{{ $talla->id }}"
                                            {{ $talla->id == $variante->talla_id ? 'selected' : '' }}>
                                            {{ $talla->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Color --}}
                            <div class="flex-1">
                                <select name="variantes[{{ $i }}][color_id]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Color</option>
                                    @foreach ($coloresDisponibles as $color)
                                        <option value="{{ $color->id }}"
                                            {{ $color->id == $variante->color_id ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Stock --}}
                            <div class="flex-1">
                                <input type="number" name="variantes[{{ $i }}][stock]" min="0"
                                    class="block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ $variante->stock }}">
                            </div>
                        </div>
                    @endforeach
                    {{-- Botón para agregar más variantes --}}
                    <button type="button" id="agregar-variante" class="mt-2 text-sm text-blue-500 hover:underline">
                        + Agregar otra combinación
                    </button>
                </div>

                <!-- Imagen -->
                <div class="mt-4">
                    <x-input-label for="imagen_url" :value="__('Imagen del producto')" />
                    <image src="{{ asset($producto->imagen_url) }}" alt="Imagen actual" class="mb-2 rounded-md"
                        style="max-width: 150px; max-height: 150px;">
                        <x-text-input id="imagen_url" class="block mt-1 w-full" type="file" name="imagen_url"
                            accept="image/*" />
                        <x-input-error :messages="$errors->get('imagen_url')" class="mt-2" />
                </div>
                <!-- Botón -->
                <div class="mt-4">
                    <x-primary-button class="w-full">
                        {{ __('Actualizar Producto') }}
                    </x-primary-button>
                </div>
            </form>
            @push('js')
            <script src="{{asset('js/variantes.js')}}"></script>
            @endpush
        </div>
    </x-guest-layout>
</x-app-layout>
