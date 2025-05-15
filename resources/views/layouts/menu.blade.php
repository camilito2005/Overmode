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
            <a class="navbar-brand" href="#">Overmode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('usuarios.listar')}}">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.formulario') }}">Iniciar
                            Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    

    <div class="container my-4">
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
