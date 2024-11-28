@extends('layouts.app')

@section('template_title')
    Clientes
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <i class="fas fa-users"></i> {{ __('Clientes') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> {{ __('Nuevo Cliente') }}
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
                                    <th>DNI</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Género</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $cliente->nombre_completo }}</td>
                                        <td>{{ $cliente->dni }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->genero === 'M' ? 'Masculino' : 'Femenino' }}</td>
                                        <td>
                                            @if($cliente->estado)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('clientes.show', $cliente->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                                <!-- solo si tiene el permiso de editar clientes -->
                                                @if(auth()->user()->hasPermiso('editar-clientes'))
                                                <a class="btn btn-sm btn-success" href="{{ route('clientes.edit', $cliente->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </a>
                                                @endif
                                                @csrf
                                                @method('DELETE')
                                                <!-- solo si tiene el permiso de eliminar clientes -->
                                                @if(auth()->user()->hasPermiso('eliminar-clientes'))
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                                    <i class="fa fa-fw fa-trash"></i>
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
            </div>
            {!! $clientes->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection