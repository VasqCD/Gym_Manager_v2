
@extends('layouts.app')

@section('template_title')
    {{ __('Ver') }} Membresía - {{ $membresia->tipo }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">
                            <i class="fas fa-eye"></i> {{ __('Detalles de Membresía') }}
                        </span>
                        <div>
                            <a class="btn btn-success btn-sm" href="{{ route('membresias.edit', $membresia->id) }}">
                                <i class="fas fa-edit"></i> {{ __('Editar') }}
                            </a>
                            <a class="btn btn-primary btn-sm" href="{{ route('membresias.index') }}">
                                <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i> {{ __('Tipo de Membresía') }}
                                </label>
                                <p class="form-control-static">{{ $membresia->tipo }}</p>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i> {{ __('Descripción') }}
                                </label>
                                <p class="form-control-static">{{ $membresia->descripcion }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign"></i> {{ __('Costo') }}
                                </label>
                                <p class="form-control-static">{{ number_format($membresia->costo, 2) }}</p>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i> {{ __('Duración') }}
                                </label>
                                <p class="form-control-static">{{ $membresia->duracion }} días</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Creado: {{ $membresia->created_at->format('d/m/Y H:i') }}
                            @if($membresia->updated_at != $membresia->created_at)
                                <br>
                                <i class="fas fa-edit"></i> Última actualización: {{ $membresia->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection