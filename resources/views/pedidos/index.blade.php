<h2>Mis pedidos</h2>

@if (session('mensaje'))
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif
@foreach ($pedidos as $pedido)
    <div>
        <strong>Pedido #{{ $pedido->id }} - {{ $pedido->created_at }}</strong><br>
        Total: ${{ number_format($pedido->total, 2) }}
        <ul>
            @foreach ($pedido->items as $item)
                <li>
                    {{ $item->producto->nombre }} - Talla: {{ $item->talla->nombre }} - Color: {{ $item->color->nombre }} - Cantidad: {{ $item->cantidad }}
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
@if ($pedidos->isEmpty())
    <p>No tienes pedidos.</p>
@endif