@extends('layouts.menu')

@section('contenido')
    <style>
        .star-rating .star {
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating .star.hovered,
        .star-rating .star.selected {
            color: gold;
        }
    </style>

    <div class="container mt-5">

        {{-- Tarjeta del producto --}}
        <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">

                {{-- Imagen del producto --}}
                <div class="col-md-5 text-center p-4 bg-light">
                    <img src="{{ asset($producto->imagen_url) }}" class="img-fluid rounded-4 mb-3"
                        alt="{{ $producto->nombre }}" style="max-height: 400px; object-fit: cover;">
                    <p class="fw-bold text-secondary mb-0">Stock disponible:</p>
                    <p class="{{ $stock <= 0 ? 'text-danger fw-bold' : 'text-success fw-semibold' }}">
                        {{ $stock > 0 ? $stock . ' unidades' : 'Agotado' }}
                    </p>
                </div>

                {{-- Detalles del producto --}}
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="card-title fw-bold mb-3">{{ $producto->nombre }}</h2>

                        <p><i class="bi bi-info-circle-fill text-primary"></i> <strong>Descripción:</strong>
                            {{ $producto->descripcion }}</p>
                        <p><i class="bi bi-cash-coin text-success"></i> <strong>Precio:</strong>
                            ${{ number_format($producto->precio, 0) }}</p>
                        <p><i class="bi bi-tags-fill text-warning"></i> <strong>Categoría:</strong> {{ $categoria->nombre }}
                        </p>

                        {{-- Formulario de agregar al carrito --}}
                        <form action="" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="descripcion" value="{{ $producto->descripcion }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="foto" value="{{ $producto->imagen_url }}">

                            <div class="row">
                                {{-- Talla --}}
                                <div class="col-md-6 mb-3">
                                    <label for="talla" class="form-label">Talla:</label>
                                    <select name="talla" id="talla" class="form-select" required>
                                        <option value="">Seleccione una talla</option>
                                        @foreach ($tallasDisponibles as $talla)
                                            <option value="{{ $talla }}">{{ $talla }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Color --}}
                                <div class="col-md-6 mb-3">
                                    <label for="color" class="form-label">Color:</label>
                                    <select name="color" id="color" class="form-select" required>
                                        <option value="">Seleccione un color</option>
                                        @foreach ($coloresDisponibles as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Cantidad --}}
                                <div class="col-md-12 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="1"
                                        min="1" max="{{ $stock }}" required>
                                </div>
                            </div>

                            @if ($stock > 0)
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-cart-plus-fill"></i> Agregar al carrito
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-x-circle"></i> Producto agotado
                                </button>
                            @endif
                        </form>

                        <p class="mt-4"><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botón de regreso --}}
        <div class="text-center mt-4">
            <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al catálogo
            </a>
        </div>

        
{{-- Sección de Opiniones --}}
<div class="container mt-5 mb-5">
    <h5 class="text-center text-primary mb-4">Deja tu opinión sobre este producto</h5>

    @auth
        <form action="" method="POST" class="mx-auto p-4 bg-white shadow rounded-4" style="max-width: 600px;">
            @csrf

            {{-- Calificación con estrellas --}}
            <div class="mb-3 text-center">
                <label class="form-label d-block">Calificación:</label>
                <div id="rating" class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star fs-3 text-secondary star" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="calificacion" id="calificacion" required>
            </div>

            {{-- Comentario --}}
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea name="comentario" id="comentario" rows="4" class="form-control" placeholder="Escribe tu opinión..." required></textarea>
            </div>

            <div class="text-center">
                <button class="btn btn-success" type="submit">
                    <i class="bi bi-send"></i> Enviar opinión
                </button>
            </div>
        </form>
    @else
        <p class="text-center text-muted">Inicia sesión para dejar tu opinión sobre un producto.</p>
    @endauth
</div>
    <script>
        const stars = document.querySelectorAll('.star-rating .star');
        const calificacionInput = document.getElementById('calificacion');
        let rating = 0;

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                resetStars();
                highlightStars(index);
            });

            star.addEventListener('mouseout', () => {
                resetStars();
                if (rating > 0) highlightStars(rating - 1, true);
            });

            star.addEventListener('click', () => {
                rating = index + 1;
                calificacionInput.value = rating;
                resetStars();
                highlightStars(index, true);
            });
        });

        function highlightStars(index, selected = false) {
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add(selected ? 'selected' : 'hovered');
            }
        }

        function resetStars() {
            stars.forEach(star => {
                star.classList.remove('hovered');
                star.classList.remove('selected');
            });
        }
    </script>
@endsection
