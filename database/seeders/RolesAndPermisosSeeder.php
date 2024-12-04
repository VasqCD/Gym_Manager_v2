<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Rolporpermiso;

class RolesAndPermisosSeeder extends Seeder {
    public function run(): void {
        // Crear roles básicos
        $roles = [
            [
                'nombre' => 'SuperAdmin',
                'descripcion' => 'Control total del sistema y funciones especiales'
            ],
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Gestión administrativa del sistema'
            ],
            [
                'nombre' => 'Gerente',
                'descripcion' => 'Gestión general del gimnasio'
            ],
            [
                'nombre' => 'Recepcionista',
                'descripcion' => 'Gestión de pagos y clientes'
            ],
            [
                'nombre' => 'Entrenador',
                'descripcion' => 'Seguimiento de clientes'
            ]
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(['nombre' => $rol['nombre']], $rol);
        }

        // Crear permisos
        $permisos = [
            // Sistema y Usuarios
            ['nombre' => 'gestionar-roles', 'descripcion' => 'Gestionar roles del sistema'],
            ['nombre' => 'gestionar-usuarios', 'descripcion' => 'Gestionar usuarios del sistema'],
            ['nombre' => 'editar-usuario', 'descripcion' => 'Editar usuarios'],
            ['nombre' => 'eliminar-usuario', 'descripcion' => 'Eliminar usuarios'],
            
            // Permisos especiales SuperAdmin
            ['nombre' => 'ver-logs', 'descripcion' => 'Ver logs del sistema'],
            ['nombre' => 'configuracion-sistema', 'descripcion' => 'Configuración general del sistema'],
            ['nombre' => 'respaldo-bd', 'descripcion' => 'Gestionar respaldos de base de datos'],
            ['nombre' => 'ver-empresa', 'descripcion' => 'Ver y editar información de la empresa'],
            ['nombre' => 'gestion-permisos', 'descripcion' => 'Gestión completa de permisos'],
            
            // Clientes
            ['nombre' => 'crear-clientes', 'descripcion' => 'Crear nuevos clientes'],
            ['nombre' => 'editar-clientes', 'descripcion' => 'Editar información de clientes'],
            ['nombre' => 'ver-clientes', 'descripcion' => 'Ver listado de clientes'],
            ['nombre' => 'eliminar-clientes', 'descripcion' => 'Eliminar clientes'],

            // Membresías
            ['nombre' => 'crear-membresias', 'descripcion' => 'Crear nuevas membresías'],
            ['nombre' => 'editar-membresias', 'descripcion' => 'Editar membresías'],
            ['nombre' => 'ver-membresias', 'descripcion' => 'Ver listado de membresías'],
            ['nombre' => 'eliminar-membresias', 'descripcion' => 'Eliminar membresías'],

            // Pagos
            ['nombre' => 'crear-pagos', 'descripcion' => 'Crear nuevos pagos'],
            ['nombre' => 'editar-pagos', 'descripcion' => 'Editar pagos'],
            ['nombre' => 'ver-pagos', 'descripcion' => 'Ver listado de pagos'],
            ['nombre' => 'eliminar-pagos', 'descripcion' => 'Eliminar pagos'],
            ['nombre' => 'generar-reportes', 'descripcion' => 'Generar reportes de pagos'],

            // Empleados
            ['nombre' => 'crear-empleados', 'descripcion' => 'Crear nuevos empleados'],
            ['nombre' => 'editar-empleados', 'descripcion' => 'Editar información de empleados'],
            ['nombre' => 'ver-empleados', 'descripcion' => 'Ver listado de empleados'],
            ['nombre' => 'eliminar-empleados', 'descripcion' => 'Eliminar empleados'],

            // Bitácora
            ['nombre' => 'ver-bitacora', 'descripcion' => 'Ver registros de bitácora'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(['nombre' => $permiso['nombre']], $permiso);
        }

        // Asignar TODOS los permisos al SuperAdmin
        $rolSuperAdmin = Rol::where('nombre', 'SuperAdmin')->first();
        foreach (Permiso::all() as $permiso) {
            Rolporpermiso::firstOrCreate([
                'rol_id' => $rolSuperAdmin->id,
                'permiso_id' => $permiso->id
            ]);
        }

        // Permisos para Administrador (sin permisos especiales)
        $rolAdmin = Rol::where('nombre', 'Administrador')->first();
        $permisosAdmin = [
            'gestionar-usuarios', 'editar-usuario', 'eliminar-usuario',
            'crear-clientes', 'editar-clientes', 'ver-clientes', 'eliminar-clientes',
            'crear-membresias', 'editar-membresias', 'ver-membresias', 'eliminar-membresias',
            'crear-pagos', 'editar-pagos', 'ver-pagos', 'eliminar-pagos',
            'crear-empleados', 'editar-empleados', 'ver-empleados', 'eliminar-empleados',
            'generar-reportes'
        ];

        foreach ($permisosAdmin as $nombrePermiso) {
            $permiso = Permiso::where('nombre', $nombrePermiso)->first();
            if ($permiso) {
                Rolporpermiso::firstOrCreate([
                    'rol_id' => $rolAdmin->id,
                    'permiso_id' => $permiso->id
                ]);
            }
        }

        // Permisos Gerente
        $rolGerente = Rol::where('nombre', 'Gerente')->first();
        $permisosGerente = [
            'ver-clientes', 'editar-clientes',
            'ver-membresias',
            'ver-pagos', 'generar-reportes',
            'ver-empleados', 'editar-empleados'
        ];

        foreach ($permisosGerente as $nombrePermiso) {
            $permiso = Permiso::where('nombre', $nombrePermiso)->first();
            if ($permiso) {
                Rolporpermiso::firstOrCreate([
                    'rol_id' => $rolGerente->id,
                    'permiso_id' => $permiso->id
                ]);
            }
        }

        // Permisos Recepcionista
        $rolRecepcionista = Rol::where('nombre', 'Recepcionista')->first();
        $permisosRecepcionista = [
            'crear-clientes', 'ver-clientes',
            'ver-membresias',
            'crear-pagos', 'ver-pagos'
        ];

        foreach ($permisosRecepcionista as $nombrePermiso) {
            $permiso = Permiso::where('nombre', $nombrePermiso)->first();
            if ($permiso) {
                Rolporpermiso::firstOrCreate([
                    'rol_id' => $rolRecepcionista->id,
                    'permiso_id' => $permiso->id
                ]);
            }
        }

        // Permisos Entrenador
        $rolEntrenador = Rol::where('nombre', 'Entrenador')->first();
        $permisosEntrenador = ['ver-clientes'];

        foreach ($permisosEntrenador as $nombrePermiso) {
            $permiso = Permiso::where('nombre', $nombrePermiso)->first();
            if ($permiso) {
                Rolporpermiso::firstOrCreate([
                    'rol_id' => $rolEntrenador->id,
                    'permiso_id' => $permiso->id
                ]);
            }
        }
    }
}