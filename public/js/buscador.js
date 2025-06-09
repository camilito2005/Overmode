$(document).ready(function () {
    $('#search').keyup(function () {
        let search = $(this).val().trim();
        if (search !== "") {
            $.ajax({
                url: urlBuscar,
                type: "GET",
                data: { search: search },
                success: function (response) {
                    // console.log(response);
                    let template = "";

                    if (response.length > 0) {
                        response.forEach(function (producto) {
                            template += `
                                <div class="col-6 col-sm-4 col-md-3 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <a href="${rutadetalles.replace('id', producto.id)}" class="text-decoration-none text-dark">
                                             <img src="${producto.imagen_url.startsWith('/storage') ? producto.imagen_url : '/storage/' + producto.imagen_url}" class="card-img-top" alt="${producto.nombre}" style="height: 180px; object-fit: cover;">
                                            <div class="card-body p-2 text-center">
                                                <h6 class="mb-1">${producto.nombre.substring(0, 20)}</h6>
                                                <strong>$${Number(producto.precio).toLocaleString()}</strong>
                                            </div>
                                        </a>
                                    </div>
                                </div>`;
                        });

                        $('#resultado-productos').html(template);
                    } else {
                        $('#resultado-productos').html(`
                            <div class="col-12 text-center">
                                <p>No hay resultados</p>
                            </div>`);
                    }
                },
                error: function () {
                    $('#resultado-productos').html(`
                        <div class="col-12 text-center">
                            <p>Error al buscar productos</p>
                        </div>`);
                }
            });
        } else {
            location.reload(); // si borras el campo, recarga el catálogo completo
        }
    });
});
