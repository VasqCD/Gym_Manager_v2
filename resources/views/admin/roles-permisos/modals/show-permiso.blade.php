
@foreach($permisos as $permiso)
<div class="modal fade" id="showPermisoModal{{ $permiso->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i> Detalles del Permiso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Nombre:</dt>
                    <dd class="col-sm-8">{{ $permiso->nombre }}</dd>

                    <dt class="col-sm-4">Descripción:</dt>
                    <dd class="col-sm-8">{{ $permiso->descripcion ?: 'Sin descripción' }}</dd>

                    <dt class="col-sm-4">Roles Asignados:</dt>
                    <dd class="col-sm-8">
                        @if($permiso->roles && $permiso->roles->count() > 0)
                            @foreach($permiso->roles as $rol)
                                <span class="badge bg-secondary mb-1 me-1">
                                    <i class="fas fa-user-tag"></i> {{ $rol->nombre }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin roles asignados</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Fecha Creación:</dt>
                    <dd class="col-sm-8">
                        <i class="fas fa-calendar-alt"></i> 
                        {{ $permiso->created_at->format('d/m/Y H:i') }}
                    </dd>
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