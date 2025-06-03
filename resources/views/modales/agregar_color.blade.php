{{-- Modal Agregar Color --}}
<div class="modal fade" id="modalAgregarColor" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('colores.agregar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="color" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código Hexadecimal</label>
                        <input type="text" name="cod_hex" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
