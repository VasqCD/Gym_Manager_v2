# Gym Manager v2

Sistema de gestión integral para gimnasios desarrollado con Laravel. Permite administrar membresías, clientes, , pagos y más.

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Características Principales

- Gestión de usuarios y roles (super admin, administradores, recepcionista, entrenadores, empleados )
- Control de membresías y pagos
- Gestion de clientes
- Registro empleados
- Reportes y estadísticas
- Registro de bitacora
- Logs de accesos, etc

## Instalación Rápida

1. Clonar el repositorio:
```bash
git clone https://github.com/yourusername/Gym_Manager_v2.git
cd Gym_Manager_v2
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar entorno:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurar base de datos en `.env`

5. Migrar y sembrar la base de datos:
```bash
php artisan migrate --seed
```

6. Iniciar servidor:
```bash
php artisan serve
```

## Módulos Principales

### Gestión de Clientes
- Registro de clientes
- Control de membresías
- Historial de pagos

### Control de Acceso
- Sistema de roles y permisos
- Registro de asistencia

### Control de Pagos
- Generación de facturas
- Múltiples métodos de pago (efectivo, tarjeta, transferencia)
- Cálculo automático de impuestos y descuentos
- Historial de transacciones
- Seguimiento de vigencia de membresías

### Gestión Administrativa
- Panel administrativo configurable
- Perfil de empresa personalizable (logo, información fiscal, horarios)
- Control de roles: SuperAdmin, Administrador, Gerente, Recepcionista y Entrenador
- Gestión de empleados y sus datos laborales

### Reportes y Estadísticas
- Dashboard con métricas clave
- Ingresos mensuales
- Membresías activas por tipo
- Número de clientes activos

### Seguridad y Auditoría
- Bitácora detallada de cambios en el sistema
- Registro de acciones por usuario
- Control de IP de acceso
- Respaldo de información

### Permisos Específicos
- Gestión granular de accesos por módulo
- Permisos para ver, crear, editar y eliminar
- Asignación de permisos por rol
- Validación automática de permisos

## Usuarios por Defecto
```bash
SuperAdmin:  superadmin@gymflow.com / SuperAdmin2024*
Admin:       admin@gymflow.com / Admin2024*
Gerente:     gerente@gymflow.com / Gerente2024*
Recepción:   recepcion@gymflow.com / Recepcion2024*
Entrenador:  entrenador@gymflow.com / Entrenador2024*
```

## Licencia

Este proyecto está licenciado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).
