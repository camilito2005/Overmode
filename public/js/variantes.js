console.log('Script de variantes cargado');

let contador = document.querySelectorAll('#variantes-container .variante-item').length || 0;

const contenedor = document.getElementById('variantes-container');
const btnAgregar = document.getElementById('agregar-variante');
const template = document.getElementById('variante-template');

function agregarVariante() {
    if (!template) {
        console.error('No se encontró el template para variantes');
        return;
    }

    // Clonar plantilla
    const nuevaVariante = template.cloneNode(true);
    nuevaVariante.style.display = ''; // Mostrar el clon

    // Limpiar y actualizar names
    nuevaVariante.querySelectorAll('select, input').forEach(el => {
        if (el.tagName === 'SELECT') el.selectedIndex = 0;
        else el.value = '';

        if (el.name.includes('variantes')) {
            el.name = el.name.replace(/\[\d+\]/, `[${contador}]`);
        }
    });

    contador++;
    contenedor.appendChild(nuevaVariante);
}

function eliminarVariante(boton) {
    const variante = boton.closest('.variante-item');
    if (variante) variante.remove();
}

// Evento agregar
if (btnAgregar) {
    btnAgregar.addEventListener('click', agregarVariante);
}

// Evento eliminar (delegado para funcionar en elementos existentes y nuevos)
contenedor.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-eliminar')) {
        eliminarVariante(e.target);
    }
});
