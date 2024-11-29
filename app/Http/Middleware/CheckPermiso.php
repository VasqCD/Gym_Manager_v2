<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CheckPermiso
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permiso
     * @return mixed
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
