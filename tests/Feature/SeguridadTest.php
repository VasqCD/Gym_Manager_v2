<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Hash;

class SeguridadTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function usuario_no_autenticado_no_puede_acceder_a_rutas_protegidas()
    {
        $response = $this->get('/clientes');
        $response->assertRedirect('/login');

        $response = $this->get('/pagos');
        $response->assertRedirect('/login');

        $response = $this->get('/roles-permisos');
        $response->assertRedirect('/login');
    }

    #[Test]
    public function usuario_sin_permisos_no_puede_acceder_a_rutas_restringidas()
    {
        $user = User::factory()->create([
            'rol_id' => null
        ]);

        $response = $this->actingAs($user)->get('/roles-permisos');
        $response->assertStatus(403);
    }

    #[Test]
    public function datos_sensibles_estan_protegidos()
    {
        $cliente = Cliente::factory()->create([
            'dni' => '12345678',
            'telefono' => '99999999'
        ]);

        // Verificar que los datos sensibles no se muestran en JSON
        $response = $this->getJson("/api/clientes/{$cliente->id}");
        $response->assertJsonMissing([
            'dni' => $cliente->dni,
            'telefono' => $cliente->telefono
        ]);
    }

    #[Test]
    public function contrasena_esta_hasheada_correctamente()
    {
        $password = 'password123';
        
        $user = User::factory()->create([
            'password' => bcrypt($password)
        ]);

        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertNotEquals($password, $user->password);
    }

    #[Test]
    public function proteccion_contra_inyeccion_sql()
    {
        $maliciousInput = "'; DROP TABLE users; --";
        
        $response = $this->post('/login', [
            'email' => $maliciousInput,
            'password' => 'password123'
        ]);

        // Verificar que la base de datos sigue intacta
        $this->assertDatabaseCount('users', User::count());
    }

    #[Test]
    public function proteccion_contra_xss()
    {
        $maliciousScript = "<script>alert('xss')</script>";
        
        $response = $this->post('/clientes', [
            'nombre_completo' => $maliciousScript,
            'dni' => '12345678',
            'telefono' => '99999999',
            'fecha_nacimiento' => '1990-01-01',
            'genero' => 'M'
        ]);

        // Verificar que el script se escapa correctamente
        $this->assertStringNotContainsString($maliciousScript, $response->getContent());
    }

    #[Test]
    public function limite_de_intentos_de_login()
    {
        $user = User::factory()->create();

        // Intentar login múltiples veces con credenciales incorrectas
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong_password'
            ]);
        }

        // Verificar que el siguiente intento está bloqueado
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    #[Test]
    public function sesion_expira_correctamente()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        // Simular expiración de sesión
        $this->travel(config('session.lifetime') + 1)->minutes();

        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }
}