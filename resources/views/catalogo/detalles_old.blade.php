@extends('layouts.menu')
@section('titulo', 'detalles')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
@section('contenido')
@push('css')
   <link rel="stylesheet" href="{{asset('css/detalles_old.css')}}"> 
@endpush

    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">
                <div class="col-md-5 text-center p-4 bg-light">
                    <img src="{{ asset($producto->imagen_url) }}" class="img-fluid rounded-4 mb-3"
                        alt="{{ $producto->nombre }}" style="max-height: 400px; object-fit: cover;">
                    <p class="fw-bold text-secondary mb-0">Stock total disponible:</p>
                    <p class="{{ $stock <= 0 ? 'text-danger fw-bold' : 'text-success fw-semibold' }}">
                        {{ $stock > 0 ? $stock . ' unidades' : 'Agotado' }}
                    </p>
                </div>

                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="card-title fw-bold mb-3">{{ $producto->nombre }}</h2>

                        <p><i class="bi bi-info-circle-fill text-primary"></i> <strong>Descripción:</strong>
                            {{ $producto->descripcion }}</p>
                        <p><i class="bi bi-cash-coin text-success"></i> <strong>Precio:</strong>
                            ${{ number_format($producto->precio, 0) }}</p>
                        <p><i class="bi bi-tags-fill text-warning"></i> <strong>Categoría:</strong>
                            {{ $categoria->nombre }}
                        </p>

                        <form action="" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="descripcion" value="{{ $producto->descripcion }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="foto" value="{{ $producto->imagen_url }}">

                            <input type="hidden" name="talla" id="tallaSeleccionada">
                            <input type="hidden" name="color" id="colorSeleccionado">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Talla:</label><br>
                                    @foreach ($tallasDisponibles as $talla)
                                        <span class="chip talla-chip"
                                            data-talla="{{ $talla }}">{{ $talla }}</span>
                                    @endforeach
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Color:</label><br>
                                    @foreach ($coloresDisponibles as $color)
                                        <span class="chip color-chip"
                                            data-color="{{ $color }}">{{ $color }}</span>
                                    @endforeach
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="1"
                                        min="1" required>
                                    <div id="stock-info" class="mt-1 text-muted small"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="btnAgregar" disabled>
                                <i class="bi bi-cart-plus-fill"></i> Agregar al carrito
                            </button>
                        </form>

                        <p class="mt-4"><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al catálogo
            </a>
        </div>

        @if ($relacionados->count() > 0)
            <div class="container mt-5">
                <h4 class="text-center text-primary mb-4">Productos relacionados</h4>
                <div class="row justify-content-center">
                    @foreach ($relacionados as $rel)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm rounded-4">
                                <img src="{{ asset($rel->imagen_url) }}" class="card-img-top rounded-top-4"
                                    alt="{{ $rel->nombre }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ $rel->nombre }}</h6>
                                    <p class="text-success fw-bold">${{ number_format($rel->precio, 0) }}</p>
                                    <a href="{{ route('productos.detalles', $rel->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Opiniones --}}
        <div class="container mt-5 mb-5">
            <h5 class="text-center text-primary mb-4">Deja tu opinión sobre este producto</h5>
            @auth
                <form action="" method="POST" class="mx-auto p-4 bg-white shadow rounded-4" style="max-width: 600px;">
                    @csrf
                    <div class="mb-3 text-center">
                        <label class="form-label d-block">Calificación:</label>
                        <div id="rating" class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star fs-3 text-secondary star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="calificacion" id="calificacion" required>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario</label>
                        <textarea name="comentario" id="comentario" rows="4" class="form-control" placeholder="Escribe tu opinión..."
                            required></textarea>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-send"></i> Enviar opinión
                        </button>
                    </div>
                </form>
            @else
                <p class="text-center text-muted">Inicia sesión para dejar tu opinión sobre un producto.</p>
                <a href="{{ route('login.html') }}" class="text-decoration-none text-center">Iniciar sesión</a>
            @endauth
        </div>
    </div>

    @php
        $inventarioMapped = $producto->inventario->map(function ($i) {
            return [
                'talla' => $i->talla->nombre,
                'color' => $i->color->nombre,
                'stock' => $i->stock,
            ];
        });
    @endphp

    @push('js')
    <script src="{{asset('js/detalles.js')}}"></script>
<script>

const inventario = @json($inventarioMapped);
    
</script>
    @endpush

@endsection
