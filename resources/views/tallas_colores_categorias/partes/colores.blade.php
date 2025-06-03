<div class="card">
    @if ($errors->any())
        <div class="alert alert-danger mx-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Color</th>
                        <th>Código Hexadecimal</th>
                        <th>fecha de creacion</th>
                        <th>fecha de Actualizacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colores as $color)
                        <tr>
                            <td>{{ $color->nombre }}</td>
                            <td>{{ $color->codigo_hex }}</td>
                            <td>{{ $color->created_at }}</td>
                            <td>{{ $color->updated_at }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalEditarColor{{ $color->id }}">Modificar</button>
                                <form action="{{route('colores.eliminar',$color->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>

                            </td>
                        </tr>

                        <!-- Modal Editar Color -->
                        <div class="modal fade" id="modalEditarColor{{ $color->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Color</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('colores.actualizar',$color->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" name="color" class="form-control" value="{{ $color->nombre }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Código Hexadecimal</label>
                                                <input type="text" class="form-control" name="codigo_hex"
                                                    value="{{ $color->codigo_hex }}">
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
