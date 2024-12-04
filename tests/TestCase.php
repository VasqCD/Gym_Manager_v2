<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Deshabilitar Vite en pruebas
        $this->withoutVite();
        
        // Configurar estado inicial para pruebas
        $this->withoutExceptionHandling();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}