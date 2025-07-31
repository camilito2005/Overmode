@extends('layouts.menu')

@section('titulo')
    Overmode - Tienda de Moda
@endsection

@push('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="shortcut icon" href="{{asset('storage/iconos/hogar.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('contenido')

    <body>

        {{-- SECCIÓN HERO --}}
        <section class="hero text-center py-5 mx-auto">
            <div class="container d-flex ">
                <div class="hero-text mb-4 mx-auto">
                    <h1 class="display-4 fw-bold">Bienvenido a Overmode</h1>
                    <h3 class="mb-4">Descubre lo último en moda y estilo.</h3>
                    <a href="{{ route('catalogo') }}" class="btn btn-primary btn-lg">Explorar la tienda</a>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('storage/modelo.png') }}" alt="Model" class="img-fluid"
                        style="max-height: 400px;">
                </div>
            </div>
        </section>

        {{-- SECCIÓN PRODUCTOS DESTACADOS --}}
        <section class="products py-5">
            <div class="container">
                <h2 class="mb-4 text-center">Productos Destacados</h2>

                <div class="row ">
                    @foreach ($productos as $producto)
                        <div class="col-6 col-sm-4 col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('productos.detalles', $producto->id) }}"
                                    class="text-decoration-none text-dark">
                                    <img src="{{ asset($producto->imagen_url) }}" class="card-img-top img-fluid"
                                        alt="{{ $producto->nombre }}" style="height: 260px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h6 class="mb-1">{{ Str::limit($producto->nombre, 20) }}</h6>
                                        <strong>${{ number_format($producto->precio, 0) }}</strong>
                                    </div>
                                </a>
                                <div class="card-footer text-center bg-white border-0">
                                    <a href="{{ route('catalogo') }}" class="btn btn-outline-primary btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SECCIÓN QUIÉNES SOMOS --}}
        <section class="bg-light py-5" id="quienes-somos">
            <div class="container text-center">
                <h2 class="mb-4">¿Quiénes somos?</h2>
                <p class="lead">
                    En <strong>Overmode</strong> somos una tienda apasionada por la moda urbana, moderna y accesible.
                    Nuestro objetivo es ofrecer ropa de calidad que refleje tu estilo único, combinando tendencias actuales
                    con precios justos. Nos esforzamos por brindar una experiencia de compra en línea cómoda, segura y
                    confiable.
                </p>
                <p>
                    Desde nuestros inicios, trabajamos para seleccionar cuidadosamente cada prenda, ofreciendo colecciones
                    que evolucionan con cada temporada.
                </p>
            </div>
        </section>

        {{-- SECCIÓN CONTÁCTANOS --}}
        <section class="py-5" id="contacto">
            <div class="container">
                <h2 class="text-center mb-4">Contáctanos</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                        </form>
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-center">
                        <p><strong>📍 Dirección:</strong> Calle 123, Bogotá, Colombia</p>
                        <p><strong>📞 Teléfono:</strong> +57 300 123 4567</p>
                        <p><strong>📧 Email:</strong> contacto@overmode.com</p>
                        <p><strong>⏰ Horario:</strong> Lunes a Viernes de 9:00 a.m. a 6:00 p.m.</p>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- FOOTER --}}
        @include('layouts.footer')

    </body>
@endsection
