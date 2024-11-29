@extends('layouts.app')

@section('template_title')
Pagos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Pagos') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('pagos.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-plus"></i> Nuevo Pago
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success m-4">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Cliente</th>
                                    <th>Membresía</th>
                                    <th>Fecha Pago</th>
                                    <th>Total</th>
                                    <th>Días Restantes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagos as $pago)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        @if($pago->cliente)
                                        {{ $pago->cliente->nombre_completo }}
                                        @else
                                        <span class="text-muted">Cliente eliminado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($pago->detalles as $detalle)
                                        {{ $detalle->membresia->tipo }}
                                        @endforeach
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</td>
                                    <td>L. {{ number_format($pago->total, 2) }}</td>
                                    <td>
                                        @if($pago->dias_restantes > 0)
                                        <span class="badge bg-success">{{ $pago->dias_restantes }} días restantes</span>
                                        @else
                                        <span class="badge bg-danger">Membresía vencida</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST">
                                            <!-- Botón Ver siempre visible para usuarios con ver-pagos -->
                                            <a class="btn btn-sm btn-primary" href="{{ route('pagos.show', $pago->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            
                                            @if(auth()->user()->hasPermiso('editar-pagos'))
                                            <a class="btn btn-sm btn-success" href="{{ route('pagos.edit', $pago->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Está seguro de eliminar este pago?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! $pagos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection