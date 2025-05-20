<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overmode - Tienda de Moda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Hero -->
    <div class="container mt-5">
        <div class="p-5 mb-4 bg-light rounded-3 shadow">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold">Bienvenido a Overmode</h1>
                <p class="fs-4">Descubre lo último en moda y estilo.</p>
                <a href="#" class="btn btn-primary btn-lg">Explorar la tienda</a>
            </div>
        </div>

        <!-- Productos destacados -->
        <h2 class="text-center my-4">Productos Destacados</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @for ($i = 0; $i < 3; $i++)
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Producto">
                        <div class="card-body">
                            <h5 class="card-title">Producto {{ $i + 1 }}</h5>
                            <p class="card-text">Descripción del producto destacado.</p>
                            <a href="#" class="btn btn-outline-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 p-4 text-center">
        &copy; {{ date('Y') }} Overmode - Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
