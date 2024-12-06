
@extends('layouts.app')

@section('template_title')
    Crear Nuevo Pago
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title"><i class="fas fa-plus-circle"></i> Crear Nuevo Pago</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('pagos.index') }}">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('pagos.store') }}" role="form">
                        @csrf
                        
                        <!-- Campos ocultos -->
                        <input type="hidden" name="subtotal" id="subtotal_hidden" value="0">
                        <input type="hidden" name="impuesto" id="impuesto_hidden" value="0">

                        <div class="row">
                            <!-- Información del Cliente -->
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h4 class="mb-3"><i class="fas fa-user"></i> Información del Cliente</h4>
                                        
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label for="cliente_id">
                                                    <i class="fas fa-user"></i> Cliente <span class="text-danger">*</span>
                                                </label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#creaClienteModal">
                                                    <i class="fas fa-user-plus"></i> Nuevo Cliente
                                                </button>
                                            </div>
                                            <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                                <option value="">Seleccione un cliente</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}">
                                                        {{ $cliente->nombre_completo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cliente_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="metodo_pago">
                                                <i class="fas fa-credit-card"></i> Método de Pago
                                            </label>
                                            <select name="metodo_pago" class="form-select">
                                                <option value="efectivo">Efectivo</option>
                                                <option value="tarjeta">Tarjeta</option>
                                                <option value="transferencia">Transferencia</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="observaciones">
                                                <i class="fas fa-comment"></i> Observaciones
                                            </label>
                                            <textarea name="observaciones" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles del Pago -->
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h4 class="mb-3"><i class="fas fa-file-invoice"></i> Detalles del Pago</h4>
                                        
                                        <div class="form-group mb-3">
                                            <label for="membresia_id">
                                                <i class="fas fa-id-card"></i> Membresía <span class="text-danger">*</span>
                                            </label>
                                            <select name="membresia_id" id="membresia_id" 
                                                    class="form-select @error('membresia_id') is-invalid @enderror" 
                                                    required onchange="calcularTotal()">
                                                <option value="">Seleccione una membresía</option>
                                                @foreach($membresias as $membresia)
                                                    <option value="{{ $membresia->id }}" 
                                                            data-precio="{{ $membresia->costo }}">
                                                        {{ $membresia->tipo }} - L. {{ number_format($membresia->costo, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('membresia_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="cantidad">
                                                        <i class="fas fa-hashtag"></i> Cantidad
                                                    </label>
                                                    <input type="number" name="cantidad" id="cantidad"
                                                           class="form-control" value="1" min="1" 
                                                           onchange="calcularTotal()">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="descuento">
                                                        <i class="fas fa-percentage"></i> Descuento (%)
                                                    </label>
                                                    <input type="number" name="descuento" id="descuento"
                                                           class="form-control" value="0" min="0" max="100"
                                                           onchange="calcularTotal()">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Subtotal</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">L.</span>
                                                        <input type="number" id="subtotal" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>ISV (15%)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">L.</span>
                                                        <input type="number" id="isv" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Total</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">L.</span>
                                                        <input type="number" id="total" name="total" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Guardar Pago
                            </button>
                            <a class="btn btn-danger ms-2" href="{{ route('pagos.index') }}">
                                <i class="fa fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
// modal de creacion cliente
@include('pago.modals.create-cliente')

@push('scripts')
<script>
function calcularTotal() {
    const membresia = document.getElementById('membresia_id');
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const precio = parseFloat(membresia.options[membresia.selectedIndex].dataset.precio) || 0;

    const subtotal = precio * cantidad;
    const descuentoMonto = (subtotal * descuento) / 100;
    const subtotalConDescuento = subtotal - descuentoMonto;
    const isv = subtotalConDescuento * 0.15;
    const total = subtotalConDescuento + isv;

    // Actualizar campos visibles y ocultos
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('subtotal_hidden').value = subtotal.toFixed(2);
    document.getElementById('isv').value = isv.toFixed(2);
    document.getElementById('impuesto_hidden').value = isv.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', calcularTotal);
</script>
@endpush


@endsection