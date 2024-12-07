@extends('layouts.app')

@section('template_title')
{{ __('Ver') }} Cliente
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <span class="card-title"><i class="fas fa-user"></i> {{ __('Ver Cliente') }}</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('clientes.index') }}">
                            <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="row">
                        <!-- Información Personal -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Información Personal</h4>
                            <div class="form-group mb-3">
                                <strong>Nombre Completo:</strong>
                                {{ $cliente->nombre_completo }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>DNI:</strong>
                                {{ $cliente->dni }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Teléfono:</strong>
                                {{ $cliente->telefono }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Email:</strong>
                                {{ $cliente->email ?? 'No especificado' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Fecha de Nacimiento:</strong>
                                {{ $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Género:</strong>
                                {{ $cliente->genero === 'M' ? 'Masculino' : 'Femenino' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Estado:</strong>
                                @if($cliente->estado)
                                <span class="badge bg-success">Activo</span>
                                @else
                                <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Información Adicional</h4>
                            <div class="form-group mb-3">
                                <strong>Dirección:</strong>
                                {{ $cliente->direccion ?? 'No especificada' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Condiciones Médicas:</strong>
                                {{ $cliente->condiciones_medicas ?? 'Ninguna registrada' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Fecha de Registro:</strong>
                                {{ $cliente->fecha_registro ? $cliente->fecha_registro->format('d/m/Y') : 'No especificada' }}
                            </div>

                            <h4 class="mt-4 mb-3">Contacto de Emergencia</h4>
                            <div class="form-group mb-3">
                                <strong>Nombre:</strong>
                                {{ $cliente->contacto_emergencia ?? 'No especificado' }}
                            </div>
                            <div class="form-group mb-3">
                                <strong>Teléfono:</strong>
                                {{ $cliente->telefono_emergencia ?? 'No especificado' }}
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-4">
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i> {{ __('Editar') }}
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                <i class="fas fa-trash"></i> {{ __('Eliminar') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection