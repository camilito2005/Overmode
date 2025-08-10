// =====================
// VARIABLES Y ELEMENTOS
// =====================
const tallaChips = document.querySelectorAll('.talla-chip');
const colorChips = document.querySelectorAll('.color-chip');
const inputTalla = document.getElementById('tallaSeleccionada');
const inputColor = document.getElementById('colorSeleccionado');
const inputCantidad = document.getElementById('cantidad');

const stockInfo = document.getElementById('stock-info');
const btnAgregar = document.getElementById('btnAgregar');

let tallaSeleccionada = null;
let colorSeleccionada = null;

// =====================
// ACTUALIZAR STOCK Y HABILITAR BOTÓN
// =====================
function actualizarEstado() {
    if (tallaSeleccionada && colorSeleccionada) {
        const item = inventario.find(i =>
            i.talla_id == tallaSeleccionada && i.color_id == colorSeleccionada
        );

        if (item) {
            stockInfo.textContent = `Stock disponible: ${item.stock}`;
            inputCantidad.max = item.stock;
            inputCantidad.disabled = false;
            btnAgregar.disabled = item.stock <= 0;
        } else {
            stockInfo.textContent = "Combinación no disponible.";
            inputCantidad.disabled = true;
            btnAgregar.disabled = true;
        }
    } else {
        stockInfo.textContent = "";
        inputCantidad.disabled = true;
        btnAgregar.disabled = true;
    }

    // Actualizar inputs ocultos
    inputTalla.value = tallaSeleccionada || '';
    inputColor.value = colorSeleccionada || '';
}

// =====================
// EVENTOS DE SELECCIÓN
// =====================
tallaChips.forEach(chip => {
    chip.addEventListener('click', () => {
        tallaChips.forEach(c => c.classList.remove('active', 'selected'));
        chip.classList.add('active', 'selected');
        tallaSeleccionada = chip.dataset.talla;
        actualizarEstado();
    });
});

colorChips.forEach(chip => {
    chip.addEventListener('click', () => {
        colorChips.forEach(c => c.classList.remove('active', 'selected'));
        chip.classList.add('active', 'selected');
        colorSeleccionada = chip.dataset.color;
        actualizarEstado();
    });
});

// =====================
// EVENTO DOM CARGADO
// =====================
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formAgregarCarrito');
    const auth = document.querySelector('meta[name="auth"]')?.content || '0';

    if (form) {
        form.addEventListener('submit', async function (e) {
            if (auth === '0') {
                e.preventDefault();

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                // Validar selección
                if (!data.talla_id || !data.color_id) {
                    alert('Por favor selecciona una talla y un color.');
                    return;
                }

                // Validar cantidad > 0
                if (parseInt(data.cantidad) <= 0) {
                    alert('La cantidad debe ser mayor a 0.');
                    return;
                }

                // 🔹 Validar stock
                const itemStock = inventario.find(i =>
                    i.talla_id == data.talla_id && i.color_id == data.color_id
                );

                if (!itemStock) {
                    alert('Esta combinación no está disponible.');
                    return;
                }

                if (parseInt(data.cantidad) > itemStock.stock) {
                    alert(`Solo hay ${itemStock.stock} unidades disponibles para esta combinación.`);
                    return;
                }

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (res.ok) {
                        const producto = {
                            producto_id: data.producto_id,
                            talla_id: data.talla_id,
                            talla_nombre: document.querySelector(`.talla-chip[data-talla="${data.talla_id}"]`)?.textContent || '',
                            color_nombre: document.querySelector(`.color-chip[data-color="${data.color_id}"]`)?.textContent || '',
                            color_id: data.color_id,
                            nombre: data.nombre,
                            descripcion: data.descripcion,
                            precio: data.precio,
                            foto: data.foto,
                            cantidad: parseInt(data.cantidad),
                        };

                        let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

                        const existente = carrito.find(item =>
                            item.producto_id === producto.producto_id &&
                            item.talla_id === producto.talla_id &&
                            item.color_id === producto.color_id
                        );

                        if (existente) {
                            // 🔹 Validar que sumando no supere el stock
                            if (existente.cantidad + producto.cantidad > itemStock.stock) {
                                alert(`Ya tienes ${existente.cantidad} en el carrito. Solo puedes agregar ${itemStock.stock - existente.cantidad} más.`);
                                return;
                            }
                            existente.cantidad += producto.cantidad;
                        } else {
                            carrito.push(producto);
                        }

                        localStorage.setItem('carrito', JSON.stringify(carrito));
                        alert('Producto agregado al carrito local.');
                    } else {
                        alert('Error al intentar agregar el producto.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ocurrió un error al agregar el producto.');
                }
            }
        });
    }
});
