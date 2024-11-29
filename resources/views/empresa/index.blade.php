@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Información de la Empresa') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('empresa.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Logo actual') }}</label>
                            <div class="col-md-6">
                                @if($empresa && $empresa->logo)
                                <img src="{{ asset($empresa->logo) }}"
                                    class="img-thumbnail"
                                    style="max-height: 100px"
                                    alt="Logo de la empresa">
                                @else
                                <p class="text-muted">No hay logo cargado</p>
                                @endif
                            </div>
                        </div>

                        <!-- Logo nuevo -->
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Logo nuevo') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" class="form-control" name="logo">
                                </div>
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $empresa->nombre ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" name="direccion" value="{{ old('direccion', $empresa->direccion ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" name="telefono" value="{{ old('telefono', $empresa->telefono ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $empresa->email ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('RTN') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" class="form-control" name="rtn" value="{{ old('rtn', $empresa->rtn ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Descripción') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion', $empresa->descripcion ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Horario') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <input type="text" class="form-control" name="horario" value="{{ old('horario', $empresa->horario ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Redes Sociales') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-share-alt"></i></span>
                                    <input type="text" class="form-control" name="redes_sociales" value="{{ old('redes_sociales', $empresa->redes_sociales ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Guardar Cambios') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection