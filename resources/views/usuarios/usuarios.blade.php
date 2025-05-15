@extends('layouts.menu')
@section('contenido')
    @if (session('mensaje'))
        @include('layouts.alertas', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif
    <div class="container">
        <h1 class="text-center">Bienvenido a la sección de administración de usuarios</h1>
        <p class="text-center">Aquí puedes gestionar todos los usuarios de la tienda.</p>
        <div class="container">
            <h2>usuarios</h2>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr class="text-center">
                        {{-- <th>ID</th> --}}
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo </th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->rol->nombre }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->ciudad }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar{{ $usuario->id }}">
                                    Editar
                                </button>
                                <form action="{{route('usuarios.eliminar',$usuario->id)}}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal específico para este usuario -->
                        <div class="modal fade" id="modalEditar{{ $usuario->id }}" tabindex="-1"
                            aria-labelledby="modalEditarLabel{{ $usuario->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('usuarios.actualizar', $usuario->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditarLabel{{ $usuario->id }}">Editar Usuario
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre"
                                                    value="{{ $usuario->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" name="apellidos"
                                                    value="{{ $usuario->apellido }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Dirección</label>
                                                <input type="text" class="form-control" name="direccion"
                                                    value="{{ $usuario->direccion }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" name="telefono"
                                                    value="{{ $usuario->telefono }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ciudad</label>
                                                <select class="form-select" name="ciudad" required>
                                                    @foreach ($ciudades as $ciudad)
                                                        <option value="{{ $ciudad }}"
                                                            {{ $ciudad == $usuario->ciudad ? 'selected' : '' }}>
                                                            {{ $ciudad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Rol</label>
                                                <select class="form-select" name="rol" required>
                                                    @foreach ($roles as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $usuario->rol_id ? 'selected' : '' }}>
                                                            {{ $item->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ $usuario->email }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex justify-content-center">
        {{ $usuarios->links() }}
    </div> --}}
        <div class="d-flex my-3">
            <a href="{{ route('usuarios.formulario') }}" class="btn btn-primary">Agregar Usuario</a>
        </div>
        <div class="d-flex my-3">
            <a href="{{ route('index') }}" class="btn btn-secondary">Volver</a>
        </div>

        {{-- <!-- Modal de edición -->
        <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEditarUsuario" method="POST" action="{{ route('usuarios.actualizar',$usuario->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editar_id" name="id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editar_nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="editar_apellidos" name="apellidos" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="editar_direccion" name="direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editar_telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="editar_ciudad" name="ciudad" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_rol" class="form-label">Rol</label>
                                <select class="form-select" id="editar_rol" name="rol" required>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editar_email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="editar_email" name="email" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    @endsection
