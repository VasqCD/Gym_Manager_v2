
@extends('layouts.app')

@section('template_title')
    Administración de Roles y Permisos
@endsection

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Panel de Roles -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>
                            <i class="fas fa-users-cog"></i> Roles
                        </span>

                        @if (auth()->user()->hasPermiso('crear-rol'))
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#createRolModal">
                            <i class="fas fa-plus"></i> Nuevo Rol
                        </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td>{{ $rol->nombre }}</td>
                                    <td>{{ $rol->descripcion }}</td>
                                    <td>
                                        @foreach($rol->permisos as $permiso)
                                            <span class="badge bg-secondary">{{ $permiso->nombre }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showRolModal{{ $rol->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if (auth()->user()->hasPermiso('editar-rol'))
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editRolModal{{ $rol->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Confirma eliminar este rol?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Permisos -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>
                            <i class="fas fa-key"></i> Permisos
                        </span>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#createPermisoModal">
                            <i class="fas fa-plus"></i> Nuevo Permiso
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <td>{{ $permiso->nombre }}</td>
                                    <td>{{ $permiso->descripcion }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showPermisoModal{{ $permiso->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if (auth()->user()->hasPermiso('gestion-permisos'))
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPermisoModal{{ $permiso->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('permisos.destroy', $permiso->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Confirma eliminar este permiso?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.roles-permisos.modals.create-rol')
@include('admin.roles-permisos.modals.edit-rol')
@include('admin.roles-permisos.modals.show-rol')
@include('admin.roles-permisos.modals.create-permiso')
@include('admin.roles-permisos.modals.edit-permiso')
@include('admin.roles-permisos.modals.show-permiso')

@endsection