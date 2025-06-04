@extends('layouts.contenido')

@section('contenido')

<h4 class="text-center text-secondary mt-3">Catálogo de Productos</h4>

<div class="container my-3">
    <div class="row">
        <!-- Filtros -->
        <div class="col-md-3 mb-3">
            <h5>Filtros</h5>

            <form method="GET" action="{{route('catalogo.filtrar')}}">
                @csrf
                <!-- Categorías -->
                <div class="mb-2">
                    <label for="categoria">Categoría</label>
                    <select name="categoria_id" id="categoria" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Precio -->
                <div class="mb-2">
                    <label>Precio</label>
                    <input type="number" name="min_precio" class="form-control mb-1" placeholder="Mínimo">
                    <input type="number" name="max_precio" class="form-control" placeholder="Máximo">
                </div>

                <!-- Marca -->
                <div class="mb-2">
                    <label for="marca">Marca</label>
                    <select name="marca" id="marca" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca }}">{{ $marca }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Talla -->
                <div class="mb-2">
                    <label for="talla">Talla</label>
                    <select name="talla_id" id="talla" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($tallas as $talla)
                            <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Color -->
                <div class="mb-3">
                    <label for="color">Color</label>
                    <select name="color_id" id="color" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($colores as $color)
                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-filter"></i> Aplicar filtros
                </button>
            </form>
        </div>

        <!-- Productos -->
        <div class="col-md-9">
            <div class="input-search text-center mb-3">
                <input type="search" id="search" class="form-control mx-auto" placeholder="Buscar producto..." style="max-width: 300px;">
            </div>

            @if(session('mensaje'))
                <div class="alert alert-{{ session('type') }}">
                    {{ session('mensaje') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                @forelse ($productos as $producto)
                    <div class="col-6 col-sm-4 col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('productos.detalles', $producto->id) }}" class="text-decoration-none text-dark">
                                <img src="{{ asset($producto->imagen_url) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 180px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <h6 class="mb-1">{{ Str::limit($producto->nombre, 20) }}</h6>
                                    <strong>${{ number_format($producto->precio, 0) }}</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No hay productos disponibles.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-3">
                <a href="" class="btn btn-info">
                    <i class="fa-solid fa-cart-shopping"></i> Ver carrito
                </a>
            </div>

            <p class="text-center mt-3">Total de productos: {{ $productos->count() }}</p>
        </div>
    </div>

    <form action="{{ url('index') }}" method="get" class="text-center mt-4 mb-5">
        <button class="btn btn-outline-secondary">
            <i class="fa-solid fa-house"></i> Inicio
        </button>
    </form>
</div>

@push('js')
    {{-- <script src="{{ asset('js/api-compras.js') }}"></script> --}}

    <script>
        const buscador = document.getElementById('search');
        console.log(buscador);
    </script>
@endpush

@endsection
