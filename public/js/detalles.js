



let talla = null,
    color = null;
const cantidadInput = document.getElementById('cantidad');
const btnAgregar = document.getElementById('btnAgregar');
const stockInfo = document.getElementById('stock-info');

document.querySelectorAll('.talla-chip').forEach(el => {
    el.addEventListener('click', () => {
        document.querySelectorAll('.talla-chip').forEach(chip => chip.classList.remove('selected'));
        el.classList.add('selected');
        talla = el.dataset.talla;
        document.getElementById('tallaSeleccionada').value = talla;
        actualizarStock();
    });
});

document.querySelectorAll('.color-chip').forEach(el => {
    el.addEventListener('click', () => {
        document.querySelectorAll('.color-chip').forEach(chip => chip.classList.remove('selected'));
        el.classList.add('selected');
        color = el.dataset.color;
        document.getElementById('colorSeleccionado').value = color;
        actualizarStock();
    });
});

cantidadInput.addEventListener('input', () => {
    actualizarStock();
});

function actualizarStock() {
    btnAgregar.disabled = true;
    stockInfo.innerText = '';
    if (!talla || !color) return;
    const combinacion = inventario.find(item => item.talla === talla && item.color === color);
    if (combinacion) {
        cantidadInput.max = combinacion.stock;
        stockInfo.innerText = `Stock disponible para esta combinación: ${combinacion.stock}`;
        if (parseInt(cantidadInput.value) <= combinacion.stock && combinacion.stock > 0) {
            btnAgregar.disabled = false;
        }
    } else {
        stockInfo.innerText = 'No hay stock para esta combinación';
    }
}

// Estrellas
const stars = document.querySelectorAll('.star-rating .star');
const calificacionInput = document.getElementById('calificacion');
let rating = 0;

stars.forEach((star, index) => {
    star.addEventListener('mouseover', () => {
        resetStars();
        highlightStars(index);
    });

    star.addEventListener('mouseout', () => {
        resetStars();
        if (rating > 0) highlightStars(rating - 1, true);
    });

    star.addEventListener('click', () => {
        rating = index + 1;
        calificacionInput.value = rating;
        resetStars();
        highlightStars(index, true);
    });
});

// Función para resaltar las estrellas al pasar el mouse
function highlightStars(index) {
    for (let i = 0; i <= index; i++) {
        stars[i].classList.add('hovered');
    }
}

// Función para marcar las estrellas seleccionadas
function selectStars(ratingValue) {
    stars.forEach((star, i) => {
        star.classList.remove('selected');
        if (i < ratingValue) {
            star.classList.add('selected');
        }
    });
}

// Función para reiniciar los estilos
function resetStars() {
    stars.forEach(star => {
        star.classList.remove('hovered');
    });
}

// Eventos para cada estrella
stars.forEach((star, index) => {
    star.addEventListener('mouseover', () => {
        resetStars();
        highlightStars(index);
    });

    star.addEventListener('mouseout', () => {
        resetStars();
    });

    star.addEventListener('click', () => {
        rating = index + 1;
        calificacionInput.value = rating;
        selectStars(rating);
    });
});