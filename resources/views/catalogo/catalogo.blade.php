@extends('layouts.menu')

@section('contenido')

<h4 class="text-center text-secondary mt-3">Productos</h4>

<div class="input-search text-center mb-3">
    <input type="search" id="search" class="form-control mx-auto" placeholder="Buscar" style="max-width: 300px;">
</div>

@if(session('mensaje'))
    <div class="alert alert-{{ session('type') }} mx-3">
        {{ session('mensaje') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mx-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid text-end px-4 mb-3">
    @auth
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </form>
    @else
        <a href="{{ route('login.html') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Iniciar sesión
        </a>
    @endauth
</div>

<div class="container">
    <div class="row">
        @forelse ($productos as $producto)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                <div class="card w-100 mb-4">
                    <a href="{{ route('productos.detalles', $producto->id) }}" class="text-decoration-none text-dark">
                        <img src="{{ asset($producto->imagen_url) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text"><strong>Precio: ${{ number_format($producto->precio, 0) }}</strong></p>
                            @if ($stock <= 0)
                                <p class="text-danger fw-bold">Agotado</p>
                            @endif
                        </div>
                    </a>
                    <div class="card-footer d-flex flex-column gap-2">
                        <button type="button" class="btn btn-success comprar-btn" 
                            data-id="{{ $producto->id }}" 
                            data-nombre="{{ $producto->nombre }}" 
                            data-cantidad="1"
                            {{ $stock <= 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-bag-shopping"></i> Comprar
                        </button>

                        <form action="" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="descripcion" value="{{ $producto->descripcion }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="stock" value="{{ $stock }}">
                            <input type="hidden" name="foto" value="{{ $producto->imagen }}">
                            <button type="submit" class="btn btn-primary w-100" {{ $stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus"></i> Agregar al carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay productos registrados.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <form action="" method="get">
            @csrf
            <button id="carrito" class="btn btn-info">
                <i class="fa-solid fa-cart-shopping"></i> Ver carrito
            </button>
        </form>
    </div>

    <p class="text-center mt-3">Total de productos: {{ $productos->count() }}</p>

    <form action="{{ url('index') }}" method="get" class="text-center mt-3 mb-5">
        <button class="btn btn-outline-secondary">
            <i class="fa-solid fa-house"></i> Inicio
        </button>
    </form>
</div>

@push('estilos')
    <script src="{{ asset('js/api-compras.js') }}"></script>
@endpush

@endsection
