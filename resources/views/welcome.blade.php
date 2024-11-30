<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gym Manager Pro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand i {
            color: #FF2D20;
        }

        .feature-card {
            min-height: 200px;
            /* Aumenta la altura de las tarjetas */
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .footer-text {
            color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-dumbbell fa-2x me-2"></i>
                <span class="h4 mb-0">Gym Manager Pro</span>
            </a>
            @if (Route::has('login'))
            <div class="ms-auto">
                @auth
                <a href="{{ url('/home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión / Registrarse
                </a>
                @endauth
            </div>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary fw-bold mb-3">Bienvenido a Gym Manager Pro</h1>
            <p class="lead text-secondary">Tu solución completa para la gestión de gimnasios</p>
        </div>

        <!-- Feature Cards -->
        <div class="row g-4">
                        <!-- Características Principales -->
            <div class="col-md-6">
                <div class="card feature-card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="icon-shape bg-primary text-white rounded-circle">
                                    <i class="fas fa-dumbbell fa-2x p-3"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title">Gestión de Membresías</h5>
                            </div>
                        </div>
                        <p class="card-text text-muted mt-3">
                            Administra fácilmente las membresías de tus clientes, controla vencimientos y renovaciones, y mantén un seguimiento detallado de los planes disponibles.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Control de Acceso -->
            <div class="col-md-6">
                <div class="card feature-card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="icon-shape bg-primary text-white rounded-circle">
                                    <i class="fas fa-id-card fa-2x p-3"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title">Gestión de Clientes</h5>
                            </div>
                        </div>
                        <p class="card-text text-muted mt-3">
                            Mantén un registro completo de tus clientes, incluyendo datos personales, historial de pagos y control de asistencia al gimnasio.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Gestión de usuarios -->
            <div class="col-md-6">
                <div class="card feature-card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="icon-shape bg-primary text-white rounded-circle">
                                    <i class="fas fa-users-cog fa-2x p-3"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title">Control de Usuarios</h5>
                            </div>
                        </div>
                        <p class="card-text text-muted mt-3">
                            Administra tu personal, asigna roles y permisos, y mantén un control eficiente del equipo de trabajo del gimnasio.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Control Financiero -->
            <div class="col-md-6">
                <div class="card feature-card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="icon-shape bg-primary text-white rounded-circle">
                                    <i class="fas fa-money-bill-wave fa-2x p-3"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title">Control de Pagos</h5>
                            </div>
                        </div>
                        <p class="card-text text-muted mt-3">
                            Gestiona los pagos de membresías, genera facturas automáticas y mantén un registro detallado de los ingresos del gimnasio.
                        </p>
                    </div>
                </div>
            </div>
            
    </main>

    <!-- Footer -->
    <footer class="bg-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 footer-text">Gym Manager Pro &copy; 2024 - Todos los derechos reservados</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>