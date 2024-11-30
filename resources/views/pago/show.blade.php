@extends('layouts.app')

@section('template_title')
Detalle de Pago
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title"><i class="fas fa-receipt"></i> Detalle de Pago</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('pagos.index') }}">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="row">
                        <!-- Información del Cliente -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Información del Cliente</h4>
                            <div class="form-group mb-2">
                                <strong><i class="fas fa-user"></i> Cliente:</strong>
                                {{ $pago->cliente->nombre_completo }}
                            </div>
                            <!-- Agregar más detalles del cliente si es necesario -->
                        </div>

                        <!-- Información del Pago -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Información del Pago</h4>
                            <div class="form-group mb-2">
                                <strong><i class="fas fa-calendar"></i> Fecha de Pago:</strong>
                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}
                            </div>
                            <div class="form-group mb-2">
                                <strong><i class="fas fa-money-bill"></i> Total:</strong>
                                L. {{ number_format($pago->total, 2) }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Detalles de la Membresía -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 class="mb-3">Detalles de Membresía</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tipo de Membresía</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                            <th>Descuento</th>
                                            <th>ISV</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pago->detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->membresia->tipo }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                            <td>L. {{ number_format($detalle->membresia->costo, 2) }}</td>
                                            <td>L. {{ number_format($detalle->subtotal, 2) }}</td>
                                            <td>L. {{ number_format($detalle->descuento, 2) }}</td>
                                            <td>L. {{ number_format($detalle->impuesto, 2) }}</td>
                                            <td>L. {{ number_format($detalle->subtotal - $detalle->descuento + $detalle->impuesto, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de la Membresía -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert {{ $pago->dias_restantes > 0 ? 'alert-success' : 'alert-danger' }}">
                                <h5 class="mb-0">
                                    <i class="fas {{ $pago->dias_restantes > 0 ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                                    Estado de Membresía:
                                    @if($pago->dias_restantes > 0)
                                    <span class="badge bg-success">{{ $pago->dias_restantes }} días restantes</span>
                                    @else
                                    <span class="badge bg-danger">Membresía vencida</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('pagos.factura', $pago->id) }}" class="btn btn-info me-2" target="_blank">
                                    <i class="fa fa-file-pdf"></i> Generar Factura
                                </a>
                                <a href="{{ route('pagos.edit', $pago->id) }}" class="btn btn-success me-2">
                                    <i class="fa fa-edit"></i> Editar Pago
                                </a>
                                <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Está seguro de eliminar este pago?')">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection