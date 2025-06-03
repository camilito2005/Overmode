<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('name')
    <title>Overmode - Tienda de Moda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('css')
</head>
@if (Auth::check() && Auth::user()->rol_id == 1)
@php
$ruta_formulario = route('register');
@endphp
@else
    @php
$ruta_formulario = route('usuarios.formulario');
    @endphp
@endif
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
                    @if (Auth::check() && Auth::user()->rol_id == 1)
                        <li class="nav-item"><a class="nav-link active" href="{{ route('index') }}">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('catalogo')}}">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">perfil</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Formulario</a> --}}
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.listar') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('productos.formulario')}}">Registrar P</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('productos.listar')}}">Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a></li>
                    @else
                        @if (!Auth::check())
                            <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('catalogo')}}">Tienda</a></li>
                            <li class="nav-item"><a class="nav-link"href="{{ $ruta_formulario }}">Registrate</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                        @elseif( Auth::user()->rol_id != 1)
                            {{-- <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Inicio</a></li> --}}
                            <li class="nav-item"><a class="nav-link" href="{{route('logout')}}">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a></li>
                        @endif
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
