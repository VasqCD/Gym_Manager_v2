
@foreach($roles as $rol)
<div class="modal fade" id="showRolModal{{ $rol->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i> Detalles del Rol
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Nombre:</dt>
                    <dd class="col-sm-8">{{ $rol->nombre }}</dd>

                    <dt class="col-sm-4">Descripción:</dt>
                    <dd class="col-sm-8">{{ $rol->descripcion }}</dd>

                    <dt class="col-sm-4">Permisos:</dt>
                    <dd class="col-sm-8">
                        @foreach($rol->permisos as $permiso)
                            <span class="badge bg-info mb-1">{{ $permiso->nombre }}</span>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4">Fecha Creación:</dt>
                    <dd class="col-sm-8">{{ $rol->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach