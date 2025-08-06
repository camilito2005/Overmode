@extends('layouts.menu')

@section('titulo', 'Overmode - Carrito de Compras')

@push('css')
    <meta name="auth" content="{{ Auth::check() ? '1' : '0' }}">
    <meta name="ruta-catalogo" content="{{ route('catalogo') }}">
    <meta name="ruta-vaciar" content="{{ route('carrito.vaciar') }}">
    <link rel="shortcut icon" href="{{asset('storage/iconos/carro.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .producto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
@endpush

@section('contenido')
    <div class="container mt-5">
        <h2 class="mb-4 text-center fw-bold text-primary">Carrito de Compras</h2>

        @if (session('mensaje'))
            @include('layouts.alertas', [
                'title' => session('type') == 'Danger' ? 'Error' : 'Info',
                'message' => session('mensaje'),
                'type' => session('type'),
            ])
        @endif
        @if (!Auth::check())
            <div id="carrito-local"></div>
        @endif

        @if ($carrito && count($carrito) > 0)
            <div class="table-responsive mb-4">
                <table class="table align-middle table-striped shadow-sm rounded">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Talla</th>
                            <th>Color</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($carrito as $item)
                            @php
                                $subtotal = $item['precio'] * $item['cantidad'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item['imagen_url']) }}" class="producto-img me-3"
                                            alt="{{ $item['nombre'] }}">

                                        <div>
                                            <strong>{{ $item['nombre'] }}</strong>
                                            <p class="mb-0 text-muted">{{ $item['descripcion'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($item['precio'], 0) }}</td>
                                <td>{{ $item['talla'] ?? 'N/A' }}</td>
                                <td>{{ $item['color'] ?? 'N/A' }}</td>
                                <td>
                                    <form action="{{ route('carrito.actualizar') }}" method="POST"
                                        class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['item_id'] }}">
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                            min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-success"><i
                                                class="bi bi-arrow-clockwise"></i></button>
                                    </form>
                                </td>
                                <td>${{ number_format($subtotal, 0) }}</td>
                                <td>
                                    <form action="{{ route('carrito.eliminar', $item['item_id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end mb-4">
                <h4 class="fw-bold">Total: ${{ number_format($total, 0) }}</h4>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Seguir comprando
                </a>

                <form action="{{route('carrito.vaciar')}}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-danger fw-semibold" id="vaciar-carrito">
                        <i class="bi bi-trash-fill me-1"></i> Vaciar carrito
                    </button>
                </form>

                <a href="" class="btn btn-success fw-semibold">
                    <i class="bi bi-credit-card-2-front me-1"></i> Proceder al pago
                </a>
            </div>
        @else
            <div class="alert alert-info text-center">
                Tu carrito está vacío. <a href="{{ route('catalogo') }}" class="fw-bold text-primary">Ir al catálogo</a>.
            </div>
        @endif
    </div>
    @push('js')
        <script src="{{ asset('js/carrito.js') }}"></script>
        <script>
           
        </script>
    @endpush

@endsection
