
@foreach($roles as $rol)
<div class="modal fade" id="editRolModal{{ $rol->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Rol
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('roles.update', $rol->id) }}" id="editRolForm{{ $rol->id }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre{{ $rol->id }}" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre{{ $rol->id }}"
                            name="nombre" value="{{ $rol->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion{{ $rol->id }}" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion{{ $rol->id }}"
                            name="descripcion" rows="3">{{ $rol->descripcion }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permisos Asignados</label>
                        <div class="row">
                            @foreach($permisos as $permiso)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="permisos[]"
                                        value="{{ $permiso->id }}"
                                        id="permiso{{ $rol->id }}_{{ $permiso->id }}"
                                        {{ $rol->permisos->contains($permiso->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permiso{{ $rol->id }}_{{ $permiso->id }}">
                                        {{ $permiso->nombre }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endforeach