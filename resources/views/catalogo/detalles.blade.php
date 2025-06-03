@extends('layouts.menu')
@section('contenido')
    <div class="container mt-5">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-5 text-center p-3">
                    <img src="{{ asset($producto->imagen_url) }}" class="img-fluid rounded" alt="{{ $producto->nombre }}" style="max-height: 400px; object-fit: cover;">
                    <p class="mt-2"><strong>Stock disponible:</strong> {{ $stock }}</p>
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title">{{ $producto->nombre }}</h3>
                        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Cop:</strong> ${{ number_format($producto->precio, 0) }}</p>
                        <p><strong>Disponibles:</strong></p>

                        @if ($stock <= 0)
                            <p class="text-danger fw-bold">Agotado</p>
                        @endif

                        <form action="" method="post" class="mt-3">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id }}">
                            <input name="nombre" type="hidden" value="{{ $producto->nombre }}">
                            <input name="descripcion" type="hidden" value="{{ $producto->descripcion }}">
                            <input name="precio" type="hidden" value="{{ $producto->precio }}">
                            <input name="foto" type="hidden" value="{{ $producto->imagen_url }}">
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">

                            {{-- Tallas --}}
                            <div class="mb-3">
                                <label for="talla" class="form-label">Talla:</label>
                                <select name="talla" id="talla" class="form-select" required>
                                    <option value="">Seleccione una talla</option>
                                    @foreach ($tallasDisponibles as $talla)
                                        <option value="{{ $talla }}">{{ $talla}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Colores --}}
                            <div class="mb-3">
                                <label for="color" class="form-label">Color:</label>
                                <select name="color" id="color" class="form-select" required>
                                    <option value="">Seleccione un color</option>
                                    @foreach ($coloresDisponibles as $color)
                                        <option value="{{ $color }}">{{ $color }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Cantidad --}}
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1"
                                    min="1" max="{{ $stock }}" required>
                            </div>

                            @if ($stock > 0)
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-cart-plus"></i> Agregar al carrito
                                </button>
                            @endif
                        </form>

                        <p class="mt-3"><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Categoría:</strong> {{ $categoria->nombre }}</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
        </div>
    </div>
@endsection
