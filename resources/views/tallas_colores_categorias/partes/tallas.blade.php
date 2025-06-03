 {{-- Tallas --}}
 <div class="card mb-4">
     {{-- <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0">Tallas</h5>
         <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarTalla">Agregar</button>
     </div> --}}
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered">
                 <thead class="table-light">
                     <tr>
                         <th>Talla</th>
                         <th>Fechas de creacion</th>
                         <th>Fechas de Actualizacion</th>
                         <th>Acciones</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($tallas as $talla)
                         <tr>
                             <td>{{ $talla->nombre }}</td>
                             <td>{{ $talla->created_at }}</td>
                             <td>{{ $talla->updated_at }}</td>
                             <td>
                                 <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                     data-bs-target="#modalEditarTalla{{ $talla->id }}">Modificar</button>
                                 <form action="{{route('tallas.eliminar',$talla->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                     <button class="btn btn-sm btn-danger">Eliminar</button>
                                 </form>
                             </td>
                         </tr>

                         <!-- Modal Editar Talla -->
                         <div class="modal fade" id="modalEditarTalla{{ $talla->id }}" tabindex="-1">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title">Editar Talla</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                     </div>
                                     <div class="modal-body">
                                         <form action="{{route('tallas.actualizar',$talla->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                             <div class="mb-3">
                                                 <label class="form-label">Nombre</label>
                                                 <input type="text" name="talla" class="form-control"
                                                     value="{{ $talla->nombre }}">
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
