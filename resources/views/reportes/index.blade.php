@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Generación de Reportes</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.generar') }}" method="GET">
                <div class="mb-3">
                    <label class="form-label">Tipo de Reporte</label>
                    <select name="tipo" class="form-select" id="tipoReporte" required>
                        <option value="">Seleccione un tipo de reporte...</option>
                        <option value="membresias-activas">Clientes con Membresías Activas</option>
                        <option value="clientes-vip">Clientes VIP</option>
                        <option value="proximos-vencer">Membresías Próximas a Vencer</option>
                        <option value="ingresos-mes">Ingresos por Período</option>
                        <option value="planilla-empleados">Planilla de Empleados</option>
                    </select>
                </div>

                <div id="fechasContainer" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Generar Reporte
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('tipoReporte').addEventListener('change', function() {
        const fechasContainer = document.getElementById('fechasContainer');
        if (this.value === 'ingresos-mes') {
            fechasContainer.style.display = 'block';
        } else {
            fechasContainer.style.display = 'none';
        }
    });
</script>
@endpush
@endsection