document.addEventListener('DOMContentLoaded', () => {
  const auth = document.querySelector('meta[name="auth"]').getAttribute('content');
  const pagarBtn = document.querySelector('.btn-success'); // botón "Proceder al pago"
  
  if (!pagarBtn) return;
  
  pagarBtn.addEventListener('click', async (e) => {
    e.preventDefault();

    if (auth !== '1') {
      alert('Debes iniciar sesión para proceder al pago.');
      window.location.href = '/login';  // Cambia esta ruta según tu login
      return;
    }

    // Preparar los datos del pedido para enviar
    const pedidoId = document.querySelector('meta[name="pedido-id"]').getAttribute('content');
    const usuarioId = document.querySelector('meta[name="usuario-id"]').getAttribute('content');
    const amount = document.querySelector('meta[name="total"]').getAttribute('content');    
    const currency = 'COP'; // Cambia esto si usas otra moneda

    if (!pedidoId || !usuarioId) {
      alert('Error: Datos del pedido o usuario faltantes.');
      return;
    }

    try {
      // 1. Crear orden en el microservicio
      const createResponse = await fetch('http://pagos-service/api/paypal/create-order', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          pedido_id: pedidoId,
          usuario_id: usuarioId,
          amount: amount,
          currency: currency
        }),
      });

      const createData = await createResponse.json();

      if (!createData.success) {
        alert('Error al crear la orden: ' + (createData.message || 'Error desconocido'));
        return;
      }

      // 2. Redirigir a PayPal para aprobar el pago
      window.location.href = createData.approval_url;

    } catch (error) {
      console.error('Error en el proceso de pago:', error);
      alert('Ocurrió un error al procesar el pago.');
    }
  });
});
