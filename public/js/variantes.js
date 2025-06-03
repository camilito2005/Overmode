
console.log('Script de variantes cargado'); // Mensaje de depuración para verificar que el script se ha cargado correctamente
let contador = 1; // Contador para las variantes

document.getElementById('agregar-variante').addEventListener('click', function () { // escucha el evento click para agregar una nueva variante
    const contenedor = document.getElementById('variantes-container'); // selecciona el contenedor de variantes
    const nuevaVariante = document.querySelector('.variante-item').cloneNode(true); // Clona el primer elemento variante

    // Limpia los valores del nuevo clon
    nuevaVariante.querySelectorAll('select, input').forEach((el) => {
        if (el.tagName === 'SELECT') el.selectedIndex = 0;
        else el.value = '';
    }); // Limpia los valores de los selects e inputs

    // Renombra los atributos name con el nuevo índice
    nuevaVariante.querySelectorAll('select, input').forEach((el) => {
        if (el.name.includes('variantes')) {
            const nuevoName = el.name.replace(/\[\d+\]/, `[${contador}]`);
            el.name = nuevoName;
        } // Renombra el atributo name de los selects e inputs
    });

    contador++; // Incrementa el contador para la siguiente variante
    contenedor.appendChild(nuevaVariante); // Agrega el nuevo clon al contenedor
});