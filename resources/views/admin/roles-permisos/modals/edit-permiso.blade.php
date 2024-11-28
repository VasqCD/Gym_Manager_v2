
@foreach($permisos as $permiso)
<div class="modal fade" id="editPermisoModal{{ $permiso->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Permiso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('permisos.update', $permiso->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre{{ $permiso->id }}" class="form-label">Nombre del Permiso</label>
                        <input type="text" class="form-control" id="nombre{{ $permiso->id }}" 
                               name="nombre" value="{{ $permiso->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion{{ $permiso->id }}" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion{{ $permiso->id }}" 
                                name="descripcion" rows="3">{{ $permiso->descripcion }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach