{{-- @extends('layouts.menu')

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

    <div class="container mt-5"> --}}

{{-- Tarjeta del producto --}}

{{-- <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0"> --}}

{{-- Imagen del producto --}}

{{-- <div class="col-md-5 text-center p-4 bg-light">
                    <img src="{{ asset($producto->imagen_url) }}" class="img-fluid rounded-4 mb-3"
                        alt="{{ $producto->nombre }}" style="max-height: 400px; object-fit: cover;">
                    <p class="fw-bold text-secondary mb-0">Stock disponible:</p>
                    <p class="{{ $stock <= 0 ? 'text-danger fw-bold' : 'text-success fw-semibold' }}">
                        {{ $stock > 0 ? $stock . ' unidades' : 'Agotado' }}
                    </p>
                </div> --}}

{{-- Detalles del producto --}}
{{-- <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="card-title fw-bold mb-3">{{ $producto->nombre }}</h2>

                        <p><i class="bi bi-info-circle-fill text-primary"></i> <strong>Descripción:</strong>
                            {{ $producto->descripcion }}</p>
                        <p><i class="bi bi-cash-coin text-success"></i> <strong>Precio:</strong>
                            ${{ number_format($producto->precio, 0) }}</p>
                        <p><i class="bi bi-tags-fill text-warning"></i> <strong>Categoría:</strong> {{ $categoria->nombre }}
                        </p> --}}

{{-- Formulario de agregar al carrito --}}
{{-- <form action="" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="descripcion" value="{{ $producto->descripcion }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="foto" value="{{ $producto->imagen_url }}">

                            <div class="row"> --}}
{{-- Talla --}}
{{-- <div class="col-md-6 mb-3">
                                    <label for="talla" class="form-label">Talla:</label>
                                    <select name="talla" id="talla" class="form-select" required>
                                        <option value="">Seleccione una talla</option>
                                        @foreach ($tallasDisponibles as $talla)
                                            <option value="{{ $talla }}">{{ $talla }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

{{-- Color --}}
{{-- <div class="col-md-6 mb-3">
                                    <label for="color" class="form-label">Color:</label>
                                    <select name="color" id="color" class="form-select" required>
                                        <option value="">Seleccione un color</option>
                                        @foreach ($coloresDisponibles as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

{{-- Cantidad --}}
{{-- <div class="col-md-12 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="1"
                                        min="1" max="{{ $stock }}" required>
                                </div>
                            </div> --}}
{{-- 
                            @if ($stock > 0)
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-cart-plus-fill"></i> Agregar al carrito
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-x-circle"></i> Producto agotado
                                </button>
                            @endif
                        </form> --}}

{{-- <p class="mt-4"><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div> --}}

{{-- Botón de regreso --}}
{{-- <div class="text-center mt-4">
            <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al catálogo
            </a>
        </div> --}}


{{-- Sección de Opiniones --}}
{{-- <div class="container mt-5 mb-5">
    <h5 class="text-center text-primary mb-4">Deja tu opinión sobre este producto</h5>

    @auth
        <form action="" method="POST" class="mx-auto p-4 bg-white shadow rounded-4" style="max-width: 600px;">
            @csrf --}}

{{-- Calificación con estrellas --}}
{{-- <div class="mb-3 text-center">
                <label class="form-label d-block">Calificación:</label>
                <div id="rating" class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star fs-3 text-secondary star" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="calificacion" id="calificacion" required>
            </div> --}}

{{-- Comentario --}}
{{-- <div class="mb-3">
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
        <a href="{{route('login.html')}}" class="text-decoration-none text-center">iniciar sesion</a>
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
@endsection --}}

@extends('layouts.menu')

@section('contenido')
    <style>
        .chip {
            display: inline-block;
            padding: 10px 16px;
            margin: 4px;
            border-radius: 50px;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chip.selected {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .chip.disabled {
            background-color: #e9ecef;
            color: #999;
            border-color: #ccc;
            cursor: not-allowed;
        }

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

                        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($producto->precio, 0) }}</p>
                        <p><strong>Categoría:</strong> {{ $categoria->nombre }}</p>

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

    <script>
        const inventario = @json($inventarioMapped);



        let talla = null,
            color = null;
        const cantidadInput = document.getElementById('cantidad');
        const btnAgregar = document.getElementById('btnAgregar');
        const stockInfo = document.getElementById('stock-info');

        document.querySelectorAll('.talla-chip').forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.talla-chip').forEach(chip => chip.classList.remove('selected'));
                el.classList.add('selected');
                talla = el.dataset.talla;
                document.getElementById('tallaSeleccionada').value = talla;
                actualizarStock();
            });
        });

        document.querySelectorAll('.color-chip').forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.color-chip').forEach(chip => chip.classList.remove('selected'));
                el.classList.add('selected');
                color = el.dataset.color;
                document.getElementById('colorSeleccionado').value = color;
                actualizarStock();
            });
        });

        cantidadInput.addEventListener('input', () => {
            actualizarStock();
        });

        function actualizarStock() {
            btnAgregar.disabled = true;
            stockInfo.innerText = '';
            if (!talla || !color) return;
            const combinacion = inventario.find(item => item.talla === talla && item.color === color);
            if (combinacion) {
                cantidadInput.max = combinacion.stock;
                stockInfo.innerText = `Stock disponible para esta combinación: ${combinacion.stock}`;
                if (parseInt(cantidadInput.value) <= combinacion.stock && combinacion.stock > 0) {
                    btnAgregar.disabled = false;
                }
            } else {
                stockInfo.innerText = 'No hay stock para esta combinación';
            }
        }

        // Estrellas
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
