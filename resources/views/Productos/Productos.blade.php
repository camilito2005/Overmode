@extends('layouts.menu')
@section('contenido')
@section('titulo')
    Overmode - Productos
@endsection
@push('css')
    <link rel="shortcut icon" href="{{ asset('storage/iconos/catalogar.png') }}" type="image/x-icon">
@endpush
<div class="container mt-4">

    @if (session('mensaje'))
        @include('layouts.alertas', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif

    <div class="table-responsive mb-4">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Subcategoría</th>
                    {{-- <th>Sub-subcategoría</th> --}}
                    <th>talla</th>
                    <th>color</th>
                    <th>Imagen</th>
                    <th>Creado</th>
                    <th>Modificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->marca }}</td>
                        <td>${{ number_format($producto->precio, 0) }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>{{ $producto->subcategoria ? $producto->subcategoria->subcategoria : 'Sin subcategoría' }}</td>
                        {{-- <td>{{ $producto->parent ? $producto->parent->nombre : 'Sin sub-subcategoría' }}</td> --}}


                        <td>
                            @if ($producto->inventario->count())
                                @foreach ($producto->inventario->pluck('talla.nombre')->unique() as $talla)
                                    <span class="badge bg-primary">{{ $talla }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin talla</span>
                            @endif
                        </td>
                        <td>
                            @if ($producto->inventario->count())
                                @foreach ($producto->inventario->pluck('color.nombre')->unique() as $color)
                                    <span class="badge bg-secondary">{{ $color }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin color</span>
                            @endif
                        </td>


                        <td>
                            <img src="{{ asset($producto->imagen_url) }}" alt="Imagen del producto" width="80"
                                class="img-thumbnail">
                        </td>
                        <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="{{ route('productos.editar', $producto->id) }}"
                                    class="btn btn-sm btn-success">Modificar</a>

                                <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST"
                                    onsubmit="return preguntas()">
                                    @csrf
                                    <input class="btn btn-sm btn-danger" type="submit" value="Eliminar">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('productos.formulario') }}" class="text-decoration-none">+ agregar productos</a>

</div>

<script>
    function preguntas() {
        return confirm("¿Estás seguro de eliminar el producto?");
    }
</script>
@endsection
