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

    // Actualizar inputs ocultos del formulario
    inputTalla.value = tallaSeleccionada || '';
    inputColor.value = colorSeleccionada || '';
}

// =====================
// EVENTOS DE SELECCIÓN DE TALLA Y COLOR
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
    console.log(form);

    // ⚠️ CORREGIDO:
    // Antes: const auth = '{{ Auth::check() ? '1' : '0' }}'; (esto no funciona en archivos JS externos)
    // Ahora: auth es leído como atributo data en el HTML (recomiendo usar: <meta name="auth" content="{{ Auth::check() }}">)
    const auth = document.querySelector('meta[name="auth"]')?.content || '0';

    // =====================
    // FORMULARIO: AGREGAR AL CARRITO
    // =====================
    if (form) {
        form.addEventListener('submit', async function (e) {
            // Si no está autenticado, manejar con LocalStorage
            if (auth === '0') {
                e.preventDefault(); // Prevenir envío por navegador

                const formData = new FormData(form);
                console.log('Datos del formulario 1:', Object.fromEntries(formData.entries()));
                // Validar que se haya seleccionado talla y color

                const data = Object.fromEntries(formData.entries());
                console.log('Datos del formulario 2:', data);

                if (!data.talla_id || !data.color_id) {
                    alert('Por favor selecciona una talla y un color.');
                    return;
                }

                try {
                    const res = await fetch(form.action, { // Enviar datos al servidor
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData // Enviar FormData directamente
                    });

                    if (res.ok) {
                        const producto = {
                            producto_id: data.producto_id,
                            talla_id: data.talla_id,
                            color_id: data.color_id,
                            nombre: data.nombre,
                            descripcion: data.descripcion,
                            precio: data.precio,
                            foto: data.foto,
                            cantidad: parseInt(data.cantidad),
                        };

                        let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');// Obtener carrito del LocalStorage
                        console.log('Carrito actual:', carrito);

                        // Verificar si ya está en el carrito
                        const existente = carrito.find(item =>
                            item.producto_id === producto.producto_id &&
                            item.talla_id === producto.talla_id &&
                            item.color_id === producto.color_id
                        );

                        if (existente) {
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
