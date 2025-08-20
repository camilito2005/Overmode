@extends('layouts.menu')

@section('titulo', 'Procesar pago')

@section('contenido')
    <div class="container text-center mt-5">
        <h3>Procesando tu pago...</h3>
        <p>Pedido #{{ $pedidoId }} - Total: ${{ number_format($total, 2) }}</p>
    </div>

    <script>
        fetch('http://localhost:8001/api/paypal/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    pedido_id: {{ $pedidoId }},
                    usuario_id: {{ $usuario_id }},
                    amount: {{ $total }},
                    currency: 'USD'
                })
            })
            .then(res => res.json())
            .then(data => {
                const approveLink = data.links?.find(link => link.rel === 'approve');
                if (approveLink) {
                    window.location.href = approveLink.href;
                } else {
                    alert('Error: no se encontró el link de aprobación de PayPal.');
                    console.error(data);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error en la comunicación con el microservicio de pagos.');
            });
    </script>
@endsection
