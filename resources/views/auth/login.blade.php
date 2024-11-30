@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="container d-flex justify-content-center align-items-center auth-container">
    <div class="row w-100 max-w-4xl">
        <!-- Formulario de Login -->
        <div class="col-md-6" id="loginForm">
            <div class="card h-100">
                <div class="card-header">
                    <img src="{{ asset('images/logo01.png') }}" alt="Logo" class="auth-logo mx-auto d-block">
                    <h3 class="text-center">Iniciar Sesión</h3>
                    <p class="text-center text-muted">Ingresa tus credenciales para acceder</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Contraseña" required>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                       

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Bienvenida -->
        <div class="col-md-6" id="loginMessage">
            <div class="card h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="fas fa-dumbbell fa-3x mb-4 text-primary"></i>
                    <h3>¡Bienvenido de nuevo!</h3>
                    <p class="text-muted">Nos alegra verte otra vez</p>
                    <p>Bienvenido al panel administrativo. Controla, organiza y mejora.</p>
                    <div class="mt-4">
                        <p>¿No tienes una cuenta?</p>
                        <button class="btn btn-outline-primary" onclick="toggleForms()">
                            <i class="fas fa-user-plus me-2"></i>Registrarse
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje de Registro -->
        <div class="col-md-6" id="registerMessage" style="display: none;">
            <div class="card h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="fas fa-running fa-3x mb-4 text-primary"></i>
                    <h3>¡Únete a nosotros!</h3>
                    <p class="text-muted">Crea tu cuenta en unos simples pasos</p>
                    <p>Crea tu cuenta para acceder al panel de administración del gimnasio.</p>
                    <p>Recuerda que debes tener un correo electrónico válido para registrarte.</p>
                    <p>Una vez registrado, ponte en contacto con el <span class="fw-bold">administrador</span> para que te asigne un <span class="fw-bold">rol</span> y los <span class="fw-bold">permisos</span> correspondientes.</p>
                    <div class="mt-4">
                        <p>¿Ya tienes una cuenta?</p>
                        <button class="btn btn-outline-primary" onclick="toggleForms()">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Formulario de Registro -->
        <div class="col-md-6" id="registerForm" style="display: none;">
            <div class="card h-100">
                <div class="card-header">
                    <img src="{{ asset('images/logo01.png') }}" alt="Logo" class="auth-logo mx-auto d-block">
                    <h3 class="text-center">Crear Cuenta</h3>
                    <p class="text-center text-muted">Completa tus datos para registrarte</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nombre completo" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Contraseña" required>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control"
                                    name="password_confirmation" placeholder="Confirmar contraseña" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush