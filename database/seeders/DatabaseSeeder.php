<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar primero el seeder de roles y permisos
        $this->call([
            RolesAndPermisosSeeder::class,
        ]);

        // Obtener IDs de roles
        $superAdminRol = Rol::where('nombre', 'SuperAdmin')->first()->id;
        $adminRol = Rol::where('nombre', 'Administrador')->first()->id;
        $gerenteRol = Rol::where('nombre', 'Gerente')->first()->id;
        $recepcionistaRol = Rol::where('nombre', 'Recepcionista')->first()->id;
        $entrenadorRol = Rol::where('nombre', 'Entrenador')->first()->id;

        /** Crear SuperAdmin
        User::firstOrCreate(
            ['email' => 'superadmin@gymflow.com'],
            [
                'name' => 'Super Administrador',
                'password' => bcrypt('SuperAdmin2024*'),
                'rol_id' => $superAdminRol,
            ]
        );

        // Crear Administrador
        User::firstOrCreate(
            ['email' => 'admin@gymflow.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Admin2024*'),
                'rol_id' => $adminRol,
            ]
        );

        // Crear Gerente
        User::firstOrCreate(
            ['email' => 'gerente@gymflow.com'],
            [
                'name' => 'Gerente',
                'password' => bcrypt('Gerente2024*'),
                'rol_id' => $gerenteRol,
            ]
        );

        // Crear Recepcionista
        User::firstOrCreate(
            ['email' => 'recepcion@gymflow.com'],
            [
                'name' => 'Recepcionista',
                'password' => bcrypt('Recepcion2024*'),
                'rol_id' => $recepcionistaRol,
            ]
        );

        // Crear Entrenador
        User::firstOrCreate(
            ['email' => 'entrenador@gymflow.com'],
            [
                'name' => 'Entrenador',
                'password' => bcrypt('Entrenador2024*'),
                'rol_id' => $entrenadorRol,
            ]
        );
        */

        // Ejecutar otros seeders 
        $this->call([
            ClienteSeeder::class,
            // Otros seeders...
        ]);
    }
}
