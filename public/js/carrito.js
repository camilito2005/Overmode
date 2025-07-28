
// =====================
// EVENTO DOM CARGADO
// =====================
document.addEventListener('DOMContentLoaded', () => {

    const Auth = document.querySelector('meta[name="auth"]').getAttribute('content');
    const Rutacatalogo = document.querySelector('meta[name="ruta-catalogo"]').getAttribute('content');
    const RutaVaciar = document.querySelector('meta[name="ruta-vaciar"]').getAttribute('content');

    if (Auth == 0) {
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

        if (carrito.length > 0) {

            var total = 0;
            let html = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>precio</th>
                            <th>talla</th>
                            <th>Color</th>
                            <th>Cantidad</th>
                            <th>subtotal</th>
                            <th>accion</th>
                            
                        </tr>
                    </thead>
                    <tbody>
            `;

            carrito.forEach(item => {
                const subtotal = item.precio * item.cantidad;
                total += item.precio * item.cantidad;
                html += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="${item.foto}" class="producto-img me-3" alt="${item.nombre}">
                                <div>
                                    <strong>${item.nombre}</strong>
                                    <p class="mb-0 text-muted">${item.descripcion}</p>
                                </div>
                            </div>
                        </td>
                        <td>$${Number(item.precio).toLocaleString()}</td>
                        <td>${item.talla_nombre || item.talla_id}</td>
                        <td>${item.color_nombre || item.color_id}</td>
                        <td >
                            <form class="d-flex align-items-center actualizar-form">
                                <input type="hidden" name="producto_id" value="${item.producto_id}">
                                <input type="hidden" name="talla_id" value="${item.talla_id}">
                                <input type="hidden" name="color_id" value="${item.color_id}">
                                <input type="number" name="cantidad" value="${item.cantidad}" min="1" class="form-control" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-success mt-1">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>



                        </td>
                        <td>${Number(subtotal).toLocaleString()}</td>
                        <td>
                            <form  class="d-inline eliminar-form">
                                
                                <input type="hidden" name="producto_id" value="${item.producto_id}">
                                <input type="hidden" name="talla_id" value="${item.talla_id}">
                                <input type="hidden" name="color_id" value="${item.color_id}">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    

                
                `;
            });
            html += `
            </tbody>
                    </table>

                    <div class="text-end mb-4">
                    <h3 class="fw-bold">Total: ${Number(total).toLocaleString()}</h3>
                </div>
                <div class="d-flex justify-content-between">
                <a href="${Rutacatalogo}" class="btn btn-outline-secondary fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Seguir comprando
                </a>

                <a href="${RutaVaciar}" class="btn btn-outline-secondary fw-semibold">
                    <i class=""></i> vaciar carrito
                </a>

                <a href="" class="btn btn-success fw-semibold">
                    <i class="bi bi-credit-card-2-front me-1"></i> Proceder al pago
                </a>
            </div>
            `;
            document.getElementById('carrito-local').innerHTML = html;
        } else {
            document.getElementById('carrito-local').innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
        }
    }

    console.log('DOM completamente cargado y analizado'); // Mensaje de depuración para verificar que el script se ha cargado correctamente
    const auth = document.querySelector('meta[name="auth"]')?.content || '0'; // Obtener el estado de autenticación desde un meta tag
    console.log('Estado de autenticación:', auth); // Verificar el estado de autenticación

    // =====================

    document.querySelectorAll('.actualizar-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();

            const producto_id = form.querySelector('input[name="producto_id"]').value;
            const talla_id = form.querySelector('input[name="talla_id"]').value;
            const color_id = form.querySelector('input[name="color_id"]').value;
            const cantidad = parseInt(form.querySelector('input[name="cantidad"]').value);

            if (auth === '0') {
                let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

                const item = carrito.find(i =>
                    i.producto_id === producto_id &&
                    i.talla_id === talla_id &&
                    i.color_id === color_id
                );

                if (!item) {
                    alert('Producto no encontrado en el carrito.');
                    return;
                }

                if (isNaN(cantidad) || cantidad <= 0) {
                    alert('Por favor ingresa una cantidad válida.');
                    return;
                }

                if (cantidad > item.stock) {
                    alert(`No hay suficiente stock. Disponible: ${item.stock}`);
                    return;
                }

                item.cantidad = cantidad;
                localStorage.setItem('carrito', JSON.stringify(carrito));
                alert('Cantidad actualizada en el carrito local.');
                location.reload(); // si deseas recargar
            } else {
                fetch('/carrito/actualizar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ producto_id, talla_id, color_id, cantidad })
                }).then(res => {
                    if (res.ok) {
                        alert('Cantidad actualizada en el servidor.');
                        location.reload();
                    } else {
                        alert('Error al actualizar.');
                    }
                });
            }
        });
    });
    document.querySelectorAll('.eliminar-form').forEach(form => { // Manejo del evento submit para eliminar un producto del carrito
        form.addEventListener('submit', e => {
            e.preventDefault();

            const producto_id = form.querySelector('input[name="producto_id"]').value;
            const talla_id = form.querySelector('input[name="talla_id"]').value;
            const color_id = form.querySelector('input[name="color_id"]').value;

            if (auth === '0') {
                let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
                carrito = carrito.filter(i =>
                    !(i.producto_id === producto_id &&
                        i.talla_id === talla_id &&
                        i.color_id === color_id)
                );
                localStorage.setItem('carrito', JSON.stringify(carrito));
                alert('Producto eliminado del carrito local.');
                location.reload();
            } else {
                fetch('/carrito/eliminar', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ producto_id, talla_id, color_id })
                }).then(res => {
                    if (res.ok) {
                        alert('Producto eliminado del servidor.');
                        location.reload();
                    } else {
                        alert('Error al eliminar el producto.');
                    }
                });
            }
        });
    });
    document.querySelector('#vaciar-carrito').addEventListener('click', e => {
        e.preventDefault();

        if (auth === '0') {
            localStorage.removeItem('carrito');
            alert('Carrito local vaciado.');
            location.reload();
        } else {
            fetch('/carrito/vaciar', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(res => {
                if (res.ok) {
                    alert('Carrito del servidor vaciado.');
                    location.reload();
                } else {
                    alert('Error al vaciar el carrito.');
                }
            });
        }
    }
    );
});
