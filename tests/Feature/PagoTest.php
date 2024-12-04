<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\BitacoraCambio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PagoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function se_puede_crear_un_pago()
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create();
        $membresia = Membresia::create([
            'tipo' => 'Mensual',
            'descripcion' => 'Membresía mensual',
            'costo' => 500.00,
            'duracion' => 30
        ]);

        $response = $this->actingAs($user)
            ->post('/pagos', [
                'cliente_id' => $cliente->id,
                'membresia_id' => $membresia->id,
                'cantidad' => 1,
                'subtotal' => 500.00,
                'impuesto' => 0.00,
                'descuento' => 0.00,
                'metodo_pago' => 'efectivo'
            ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('pagos', [
            'cliente_id' => $cliente->id,
            'total' => 500.00,
            'estado' => 'pagado'
        ]);
    }

    #[Test]
    public function se_registra_en_bitacora_al_crear_pago()
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create();
        $membresia = Membresia::create([
            'tipo' => 'Mensual',
            'descripcion' => 'Membresía mensual',
            'costo' => 500.00,
            'duracion' => 30
        ]);

        $response = $this->actingAs($user)
            ->post('/pagos', [
                'cliente_id' => $cliente->id,
                'membresia_id' => $membresia->id,
                'cantidad' => 1,
                'subtotal' => 500.00,
                'impuesto' => 0.00,
                'descuento' => 0.00,
                'metodo_pago' => 'efectivo'
            ]);

        $pago = Pago::latest()->first();

        $this->assertDatabaseHas('bitacora_cambios', [
            'usuario_id' => $user->id,
            'tabla' => 'pagos',
            'accion' => 'CREATE',
            'registro_id' => $pago->id
        ]);
    }
}