<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

/**
 * Proveedor de servicios principal de la aplicación
 *
 * Esta clase es el proveedor de servicios principal donde se registran
 * y configuran los servicios base de la aplicación. También se encarga
 * de la configuración inicial de componentes como el paginador.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra los servicios de la aplicación
     * 
     * Este método se ejecuta durante la fase de registro del bootstrapping.
     * Aquí se deben registrar los bindings del contenedor, resolvers de 
     * interfaces y otras configuraciones de servicios.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa los servicios de la aplicación
     * 
     * Este método se ejecuta después de que todos los servicios han sido registrados.
     * Aquí se configuran componentes como el paginador y otras funcionalidades
     * que requieren que todos los servicios estén disponibles.
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
