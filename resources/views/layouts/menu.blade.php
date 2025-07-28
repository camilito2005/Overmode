<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="auth" content="{{ Auth::check() ? '1' : '0' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('titulo')
    <title>@yield('titulo', 'Overmode - Tienda de Moda')</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index') }}">Overmode</a>

            @auth
                <a class="navbar-brand">{{ Auth::user()->nombre }}</a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Enlaces para todos --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalogo') }}">Tienda</a></li>

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.formulario') }}">Registrate</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contacto">Contáctanos</a></li>
                    @endguest

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a></li>

                        @if (Auth::user()->rol_id == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.listar') }}">Usuarios</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('productos.formulario') }}">Registrar
                                    P</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('productos.listar') }}">Productos</a>
                            </li>
                        @endif

                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>



    <div class="container my-4">
        @yield('contenido')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @push('js')
        <script src="{{ asset('js/global.js') }}"></script>
    @endpush

    @stack('js')

{{-- FOOTER --}}
        <footer class="bg-dark text-light pt-5 pb-4">
            <div class="container text-md-left">
                <div class="row text-md-left">

                    <!-- Marca -->
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold">Overmode</h5>
                        <p>Tu destino de moda en línea. Encuentra tu estilo con nuestras colecciones exclusivas.</p>
                    </div>

                    <!-- Navegación -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold">Navegación</h5>
                        <p><a href="{{route('index')}}" class="text-light text-decoration-none">Inicio</a></p>
                        <p><a href="{{ route('catalogo') }}" class="text-light text-decoration-none">Catálogo</a></p>
                        <p><a href="#quienes-somos" class="text-light text-decoration-none">¿Quiénes somos?</a></p>
                        <p><a href="#contacto" class="text-light text-decoration-none">Contáctanos</a></p>
                    </div>

                    <!-- Contacto -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold">Contacto</h5>
                        <p><i class="bi bi-house-door me-2"></i> Cartagena, Colombia</p>
                        <p><i class="bi bi-envelope me-2"></i> contacto@overmode.com</p>
                        <p><i class="bi bi-telephone me-2"></i> +57 300 123 4567</p>
                    </div>

                    <!-- Redes sociales -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold">Síguenos</h5>
                        <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-light me-3"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row align-items-center">
                    <div class="col-md-7 col-lg-8">
                        <p class="text-center text-md-start">© 2025 Overmode. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>

</body>

</html>
