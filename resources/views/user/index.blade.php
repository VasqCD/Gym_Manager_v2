@extends('layouts.app')

@section('template_title')
    Usuarios
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Usuarios') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-plus"></i> Nuevo Usuario
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
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->rol->nombre ?? 'Sin rol' }}</td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('users.show', $user->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-success" href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                                    <i class="fa fa-trash"></i>
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
            {!! $users->links() !!}
        </div>
    </div>
</div>
@endsection