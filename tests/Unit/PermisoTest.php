<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PermisoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_usuario_puede_verificar_si_tiene_un_permiso()
    {
        // Crear rol y permiso
        $rol = Rol::create(['nombre' => 'Admin']);
        $permiso = Permiso::create(['nombre' => 'ver-clientes']);
        
        $rol->permisos()->attach($permiso->id);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id
        ]);

        $this->assertTrue($user->hasPermiso('ver-clientes'));
    }
}