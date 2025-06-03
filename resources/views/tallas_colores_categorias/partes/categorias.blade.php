<div class="container py-4">
    {{-- Categorías --}}
    <div class="card mb-4">
        {{-- <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Categorías</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">Agregar</button>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th>Fecha de creacion</th>
                            <th>Fecha de Actualizacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->created_at }}</td>
                                <td>{{ $categoria->updated_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarCategoria{{ $categoria->id }}">Modificar</button>
                                    <form action="{{ route('categorias.eliminar', $categoria->id) }}" method="POST"
                                        class="d-inline"
                                        onclick="return comfirm('¿ estas seguro de eliminar este registro ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Editar Categoría -->
                            <div class="modal fade" id="modalEditarCategoria{{ $categoria->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Categoría</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('categorias.Actualizar', $categoria->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control"
                                                        value="{{ $categoria->nombre }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    