
@extends('layouts.app')

@section('template_title')
    Membresías
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">
                            <i class="fas fa-id-card"></i> {{ __('Membresías') }}
                        </span>
                        <div>
                            <a href="{{ route('membresias.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> {{ __('Nueva Membresía') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4">
                        <i class="fas fa-check-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th><i class="fas fa-tag"></i> {{ __('Tipo') }}</th>
                                    <th><i class="fas fa-align-left"></i> {{ __('Descripción') }}</th>
                                    <th><i class="fas fa-dollar-sign"></i> {{ __('Costo') }}</th>
                                    <th><i class="fas fa-calendar-alt"></i> {{ __('Duración') }}</th>
                                    <th><i class="fas fa-cogs"></i> {{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($membresias as $membresia)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $membresia->tipo }}</td>
                                        <td>{{ Str::limit($membresia->descripcion, 50) }}</td>
                                        <td>{{ number_format($membresia->costo, 2) }}</td>
                                        <td>{{ $membresia->duracion }} días</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-primary btn-sm" href="{{ route('membresias.show', $membresia->id) }}"
                                                   title="{{ __('Ver') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-success btn-sm" href="{{ route('membresias.edit', $membresia->id) }}"
                                                   title="{{ __('Editar') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('membresias.destroy', $membresia->id) }}" method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('¿Está seguro de eliminar esta membresía?')"
                                                            title="{{ __('Eliminar') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                {!! $membresias->withQueryString()->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection