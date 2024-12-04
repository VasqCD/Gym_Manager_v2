<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Middleware para verificación de permisos
 *
 * Esta clase implementa la verificación de permisos específicos
 * para las rutas protegidas del sistema
 *
 * @package App\Http\Middleware
 */
class CheckPermiso
{

    /**
     * Maneja la petición entrante verificando los permisos
     *
     * Verifica si el usuario autenticado tiene el permiso requerido
     * para acceder al recurso solicitado
     *
     * @param Request $request Petición HTTP entrante
     * @param Closure $next Siguiente middleware en la cadena
     * @param string $permiso Nombre del permiso requerido
     * @return mixed Respuesta HTTP
     * @throws \Illuminate\Auth\AuthenticationException Si el usuario no está autenticado
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Si el permiso no existe
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException Si el usuario no tiene el permiso
     */
    public function handle(Request $request, Closure $next, string $permiso)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'No autenticado');
        }

        // Verificar que el permiso exista
        $existePermiso = \App\Models\Permiso::where('nombre', $permiso)->exists();
        if (!$existePermiso) {
            abort(404, 'Permiso no encontrado');
        }

        // Verificar si el usuario tiene el permiso
        if (!$user->hasPermiso($permiso)) {
            abort(403, 'No tienes permiso para acceder a esta sección');
        }

        return $next($request);
    }
}
