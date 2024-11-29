@extends('layouts.app')

@section('template_title')
    {{ __('Crear') }} Membresía
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">
                            <i class="fas fa-plus-circle"></i> {{ __('Crear Nueva Membresía') }}
                        </span>
                        <a class="btn btn-primary btn-sm float-right" href="{{ route('membresias.index') }}">
                            <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('membresias.store') }}" role="form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tipo" class="form-label">
                                        <i class="fas fa-tag"></i> {{ __('Tipo de Membresía') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="tipo" 
                                           class="form-control @error('tipo') is-invalid @enderror" 
                                           id="tipo" 
                                           value="{{ old('tipo') }}" 
                                           placeholder="Ej: Premium Mensual"
                                           required>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="descripcion" class="form-label">
                                        <i class="fas fa-align-left"></i> {{ __('Descripción') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="descripcion" 
                                              class="form-control @error('descripcion') is-invalid @enderror" 
                                              id="descripcion" 
                                              rows="3"
                                              placeholder="Describe los beneficios de esta membresía"
                                              required>{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="costo" class="form-label">
                                        <i class="fas fa-dollar-sign"></i> {{ __('Costo') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           step="0.01" 
                                           name="costo" 
                                           class="form-control @error('costo') is-invalid @enderror" 
                                           id="costo" 
                                           value="{{ old('costo') }}"
                                           placeholder="0.00"
                                           required>
                                    @error('costo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="duracion" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> {{ __('Duración (días)') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           name="duracion" 
                                           class="form-control @error('duracion') is-invalid @enderror" 
                                           id="duracion" 
                                           value="{{ old('duracion') }}"
                                           placeholder="30"
                                           required>
                                    @error('duracion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Guardar') }}
                                </button>
                                <a href="{{ route('membresias.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> {{ __('Cancelar') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
