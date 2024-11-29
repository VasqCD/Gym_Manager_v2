<div class="modal fade" id="creaClienteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i> Registrar Nuevo Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('clientes.store') }}">
                @csrf
                <input type="hidden" name="es_modal" value="1">
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_completo" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input type="text" name="dni" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <input type="text" name="telefono" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Dirección</label>
                                <textarea name="direccion" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Fecha Nacimiento <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Género <span class="text-danger">*</span></label>
                                <select name="genero" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Condiciones Médicas</label>
                                <textarea name="condiciones_medicas" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar y Seleccionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>