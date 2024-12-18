<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.myprofile'); // Muestra la vista del perfil
    }

    public function edit()
    {
        return view('profile.edit'); // Vista para editar el perfil
    }

    public function update(Request $request)
    {
        // Validación de los campos de nombre, correo y contraseña
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'new_password' => 'nullable|string|min:8|confirmed', // Nueva contraseña con confirmación
        ], [
            // Mensajes personalizados
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingresa una dirección de correo válida.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = Auth::user();

        // Actualizar nombre, apellido y correo
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;

        // Actualizar la contraseña si el campo 'new_password' está lleno
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Guardar los cambios
        $user->save();

        return redirect()->route('profile.view')->with('success', 'Perfil actualizado con éxito.');
    }
}
