<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Debes iniciar sesión para acceder al panel.');
        }

        // Verificar si el usuario es administrador
        if (!$user->hasRole('admin')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // Si es administrador, continuar a la vista del panel
        return view('admin.index');
    }


}
