// =====================
// SINCRONIZAR CARRITO CUANDO INICIA SESIÓN
// =====================
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM completamente cargado y analizado');
    // Verificar si el usuario está autenticado
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    const auth = document.querySelector('meta[name="auth"]')?.content || '0';

    console.log('Carrito local:', carrito);
    // Si hay productos en el carrito y el usuario está autenticado, sincronizar con el servidor

    if (carrito.length > 0 && auth === '1') {
        fetch('/sincronizar-carrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ items: carrito })
        }).then(res => {
            if (res.ok) {
                localStorage.removeItem('carrito');
                console.log("Carrito sincronizado.");
            }
        });
    }

});