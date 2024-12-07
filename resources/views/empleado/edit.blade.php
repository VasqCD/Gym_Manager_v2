@extends('layouts.app')

@section('template_title')
{{ __('Editar') }} Empleado
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <span class="card-title"><i class="fas fa-user-edit"></i> {{ __('Editar Empleado') }}</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('empleados.index') }}">
                            <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                        </a>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('empleados.update', $empleado->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Información Personal -->
                                <h4 class="mb-3">Información Personal</h4>
                                <div class="form-group mb-3">
                                    <label for="nombre_completo">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                                        value="{{ old('nombre_completo', $empleado->nombre_completo) }}" required>
                                    @error('nombre_completo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="dni">DNI <span class="text-danger">*</span></label>
                                    <input type="text" name="dni" class="form-control @error('dni') is-invalid @enderror"
                                        value="{{ old('dni', $empleado->dni) }}" required>
                                    @error('dni')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                        value="{{ old('telefono', $empleado->telefono) }}" required>
                                    @error('telefono')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $empleado->email) }}">
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="direccion">Dirección</label>
                                    <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $empleado->direccion) }}</textarea>
                                    @error('direccion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Información Laboral -->
                                <h4 class="mb-3">Información Laboral</h4>
                                <div class="form-group mb-3">
                                    <label for="cargo">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror"
                                        value="{{ old('cargo', $empleado->cargo) }}" required>
                                    @error('cargo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="salario">Salario <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="salario" class="form-control @error('salario') is-invalid @enderror"
                                        value="{{ old('salario', $empleado->salario) }}" required>
                                    @error('salario')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="fecha_contratacion">Fecha de Contratación <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_contratacion" class="form-control @error('fecha_contratacion') is-invalid @enderror"
                                        value="{{ old('fecha_contratacion', $empleado->fecha_contratacion->format('Y-m-d')) }}" required>
                                    @error('fecha_contratacion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tipo_contrato">Tipo de Contrato <span class="text-danger">*</span></label>
                                    <select name="tipo_contrato" class="form-control @error('tipo_contrato') is-invalid @enderror" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Tiempo Completo" {{ old('tipo_contrato', $empleado->tipo_contrato) == 'Tiempo Completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                        <option value="Medio Tiempo" {{ old('tipo_contrato', $empleado->tipo_contrato) == 'Medio Tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                                        <option value="Por Horas" {{ old('tipo_contrato', $empleado->tipo_contrato) == 'Por Horas' ? 'selected' : '' }}>Por Horas</option>
                                    </select>
                                    @error('tipo_contrato')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="horario_trabajo">Horario de Trabajo</label>
                                    <input type="text" name="horario_trabajo" class="form-control @error('horario_trabajo') is-invalid @enderror"
                                        value="{{ old('horario_trabajo', $empleado->horario_trabajo) }}">
                                    @error('horario_trabajo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="numero_seguro_social">Número de Seguro Social</label>
                                    <input type="text" name="numero_seguro_social" class="form-control @error('numero_seguro_social') is-invalid @enderror"
                                        value="{{ old('numero_seguro_social', $empleado->numero_seguro_social) }}">
                                    @error('numero_seguro_social')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="activo">Estado del Empleado <span class="text-danger">*</span></label>
                                <select name="activo" class="form-control @error('activo') is-invalid @enderror" required>
                                    <option value="1" {{ old('activo', $empleado->activo) == 1 ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('activo', $empleado->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('activo')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Información de Emergencia -->
                            <div class="col-12">
                                <h4 class="mt-3 mb-3">Información de Emergencia</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="contacto_emergencia">Contacto de Emergencia</label>
                                            <input type="text" name="contacto_emergencia" class="form-control @error('contacto_emergencia') is-invalid @enderror"
                                                value="{{ old('contacto_emergencia', $empleado->contacto_emergencia) }}">
                                            @error('contacto_emergencia')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="telefono_emergencia">Teléfono de Emergencia</label>
                                            <input type="text" name="telefono_emergencia" class="form-control @error('telefono_emergencia') is-invalid @enderror"
                                                value="{{ old('telefono_emergencia', $empleado->telefono_emergencia) }}">
                                            @error('telefono_emergencia')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> {{ __('Actualizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection