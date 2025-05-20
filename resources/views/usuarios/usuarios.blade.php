@extends('layouts.menu')
@section('contenido')
    @if (session('mensaje'))
        @include('layouts.alertas', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif

    <div class="container my-4">
        <h1 class="text-center mb-3">Bienvenido a la sección de administración de usuarios</h1>
        <p class="text-center">Aquí puedes gestionar todos los usuarios de la tienda.</p>

        <div class="d-flex flex-column flex-md-row justify-content-between my-3">
            <a href="{{ route('usuarios.formulario') }}" class="btn btn-primary mb-2 mb-md-0">Agregar Usuario</a>
            <a href="{{ route('index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <h2>Usuarios</h2>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
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
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditar{{ $usuario->id }}">
                                        Editar
                                    </button>
                                    <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal para editar usuario -->
                        <div class="modal fade" id="modalEditar{{ $usuario->id }}" tabindex="-1"
                            aria-labelledby="modalEditarLabel{{ $usuario->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('usuarios.actualizar', $usuario->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" name="nombre"
                                                        value="{{ $usuario->nombre }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" name="apellidos"
                                                        value="{{ $usuario->apellido }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Dirección</label>
                                                    <input type="text" class="form-control" name="direccion"
                                                        value="{{ $usuario->direccion }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" name="telefono"
                                                        value="{{ $usuario->telefono }}" required>
                                                </div>
                                                <div class="col-md-6">
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
                                                <div class="col-md-6">
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
                                                <div class="col-12">
                                                    <label class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ $usuario->email }}" required>
                                                </div>
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
    </div>
@endsection
