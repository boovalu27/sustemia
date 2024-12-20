<?php

// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Redirigir al usuario a la página de login si no está autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function redirectTo(Request $request)
    {
        // Si el usuario no está autenticado, redirigir a la página de login
        if (!Auth::check()) {
            return route('auth.login');  // Asegúrate de que sea la ruta 'auth.login'
        }
    }
}
