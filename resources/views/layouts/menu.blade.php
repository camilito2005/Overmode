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


</body>

</html>
