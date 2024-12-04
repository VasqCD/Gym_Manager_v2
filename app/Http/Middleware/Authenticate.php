<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Middleware de autenticación personalizado
 *
 * Esta clase extiende el middleware de autenticación base de Laravel
 * para manejar las redirecciones cuando un usuario no está autenticado
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Obtiene la ruta a la que se debe redirigir al usuario cuando no está autenticado
     *
     * Este método determina si la petición espera una respuesta JSON y redirige
     * apropiadamente al usuario no autenticado
     *
     * @param Request $request Objeto de la petición HTTP actual
     * @return string|null Ruta de redirección o null si la petición espera JSON
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        
        return null;
    }
}