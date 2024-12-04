@extends('layouts.app')

@section('template_title')
    Empleados
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <i class="fas fa-user-tie"></i> {{ __('Empleados') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> {{ __('Nuevo Empleado') }}
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
                                    <th>Nombre Completo</th>
                                    <th>Cargo</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Tipo Contrato</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empleados as $empleado)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $empleado->nombre_completo }}</td>
                                        <td>{{ $empleado->cargo }}</td>
                                        <td>{{ $empleado->telefono }}</td>
                                        <td>{{ $empleado->email }}</td>
                                        <td>{{ $empleado->tipo_contrato }}</td>
                                        <td>
                                            @if($empleado->activo)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('empleados.show', $empleado->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-success" href="{{ route('empleados.edit', $empleado->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Está seguro de eliminar este empleado?')">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $empleados->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection