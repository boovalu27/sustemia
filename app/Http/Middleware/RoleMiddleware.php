<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/')->with('warning', 'No has iniciado sesión.');
        }

        // Verificar si el usuario tiene uno de los roles permitidos
        if (!Auth::user()->hasRole($roles)) {
            return redirect('/')->with('warning', 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
