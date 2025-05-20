<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('name')
    <title>Overmode - Tienda de Moda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('css')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('index')}}">Overmode</a>
            @if (Auth::check())
                <a class="navbar-brand">{{Auth::user()->nombre}}</a>
                
            @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                        <li class="nav-item"><a class="nav-link active" href="{{ route('index') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Carrito</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.listar') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a></li>
                        @if (Auth::user()->rol_id == 1)

                            <li class="nav-item"><a class="nav-link" href="{{ route('perfil') }}">perfil</a></li>
                            @if (Auth::user()->rol_id == 2)
                                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                            @else
                            @endif
                        @else
                            </li>

                        @endif
                    @else
                        <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('index') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('usuarios.formulario') }}">Formulario</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Formulario 2</a>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    

    <div class="container my-4">
        {{-- <p>{{Auth::user->nombre}}</p> --}}
        @yield('contenido')
    </div>

    <!-- Footer -->
    {{-- <footer class="bg-dark text-white mt-5 p-4 text-center">
        &copy; {{ date('Y') }} Overmode - Todos los derechos reservados.
    </footer> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('js')
</body>

</html>
