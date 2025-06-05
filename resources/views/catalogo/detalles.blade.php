@extends('layouts.menu')
@section('titulo', 'Detalles')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/detalles_old.css') }}">
@endpush

@section('contenido')

    <div class="container mt-5">

        <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">
                <!-- Imagen y stock -->
                <div
                    class="col-md-5 p-4 bg-light d-flex flex-column align-items-center justify-content-center text-center rounded-start">
                    <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}"
                        class="img-fluid rounded-4 mb-3" style="max-height: 350px; object-fit: cover;">
                    <p class="fw-bold text-secondary mb-1">Stock total disponible:</p>
                    <p class="{{ $stock <= 0 ? 'text-danger fw-bold' : 'text-success fw-semibold fs-5' }}">
                        {{ $stock > 0 ? $stock . ' unidades' : 'Agotado' }}
                    </p>
                </div>

                <!-- Detalles -->
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="card-title fw-bold mb-3">{{ $producto->nombre }}</h2>

                        <p><i class="bi bi-info-circle-fill text-primary me-2"></i><strong>Descripción:</strong>
                            {{ $producto->descripcion }}</p>
                        <p><i class="bi bi-cash-coin text-success me-2"></i><strong>Precio:</strong>
                            ${{ number_format($producto->precio, 0) }}</p>
                        <p><i class="bi bi-tags-fill text-warning me-2"></i><strong>Categoría:</strong>
                            {{ $categoria->nombre }}</p>

                        <form action="" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="descripcion" value="{{ $producto->descripcion }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="foto" value="{{ $producto->imagen_url }}">

                            <input type="hidden" name="talla" id="tallaSeleccionada">
                            <input type="hidden" name="color" id="colorSeleccionado">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Talla:</label>
                                <div>
                                    @foreach ($tallasDisponibles as $talla)
                                        <span class="chip talla-chip"
                                            data-talla="{{ $talla }}">{{ $talla }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Color:</label>
                                <div>
                                    @foreach ($coloresDisponibles as $color)
                                        <span class="chip color-chip"
                                            data-color="{{ $color }}">{{ $color }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="cantidad" class="form-label fw-semibold">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1"
                                    min="1" required>
                                <small id="stock-info" class="form-text text-muted"></small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold" id="btnAgregar" disabled>
                                <i class="bi bi-cart-plus-fill me-2"></i>Agregar al carrito
                            </button>
                        </form>

                        <hr>

                        <p><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary fw-semibold">
                <i class="bi bi-arrow-left-circle me-2"></i>Volver al catálogo
            </a>
        </div>

        @if ($relacionados->count() > 0)
            <div class="mt-5">
                <h4 class="text-center text-primary mb-4 fw-bold">los usuarios tambien vieron</h4>
                <div class="row justify-content-center g-3">
                    @foreach ($relacionados as $rel)
                        <div class="col-6 col-md-3">
                            <div class="card h-100 shadow-sm rounded-4">
                                <img src="{{ asset($rel->imagen_url) }}" alt="{{ $rel->nombre }}"
                                    class="card-img-top rounded-top-4" style="height: 180px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-truncate" title="{{ $rel->nombre }}">{{ $rel->nombre }}
                                    </h6>
                                    <p class="text-success fw-bold">${{ number_format($rel->precio, 0) }}</p>
                                    <a href="{{ route('productos.detalles', $rel->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($relacionados->count() >= 4)
                <form action="{{ route('catalogo.filtrar') }}" method="GET">
                    @csrf
                    <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">
                    <input type="submit" value="ver mas">
                </form>
            @endif
        @endif

        {{-- Opiniones --}}
        <div class="mt-5 mb-5">
            <h5 class="text-center text-primary mb-4 fw-bold">Deja tu opinión sobre este producto</h5>
            @auth
                <form action="" method="POST" class="mx-auto p-4 bg-white shadow rounded-4" style="max-width: 600px;">
                    @csrf
                    <div class="mb-3 text-center">
                        <label class="form-label d-block fw-semibold">Calificación:</label>
                        <div id="rating" class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star fs-3 text-secondary star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="calificacion" id="calificacion" required>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label fw-semibold">Comentario</label>
                        <textarea name="comentario" id="comentario" rows="4" class="form-control" placeholder="Escribe tu opinión..."
                            required></textarea>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-success fw-semibold" type="submit">
                            <i class="bi bi-send me-2"></i>Enviar opinión
                        </button>
                    </div>
                </form>
            @else
                <p class="text-center text-muted">Inicia sesión para dejar tu opinión sobre un producto.</p>
                <a href="{{ route('login.html') }}"
                    class="d-block text-center text-decoration-none text-primary fw-semibold">Iniciar sesión</a>
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
        <script src="{{ asset('js/detalles.js') }}"></script>

        <script>
            const inventario = @json($inventarioMapped);
        </script>
    @endpush

@endsection
