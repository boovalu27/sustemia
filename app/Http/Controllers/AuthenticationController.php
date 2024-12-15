<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
 /*   public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Asignar rol 'viewer' por defecto
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Usuario creado con éxito.');
    }

   */

   public function login()
   {
       if (Auth::check()) {
           return redirect()->route('dashboards.index'); // O la ruta adecuada
       }

       return view('auth.login');
   }


    public function processLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->route('auth.login')
            ->with('warning', 'Credenciales inválidas. Por favor, verifica tu correo electrónico y contraseña.')
            ->withInput();

        }

        // Obtener el usuario autenticado
        $user = Auth::user();

    // Verificar si el usuario tiene un rol
    if (!$user->role) {
        return redirect()->route('auth.login')
            ->with('error', 'El usuario no tiene un rol asignado.')
            ->withInput();
    }

    // Redirigir según el rol del usuario
    if ($user->role->name === 'admin') {
        return redirect()->route('dashboards.index')->with('success', '¡Hola ' . $user->name . '! Has iniciado sesión con éxito.');
    }

        // Aquí puedes manejar otros roles si es necesario
        return redirect()->route('reports.index')->with('success', '¡Hola ' . $user->name . '! Has iniciado sesión con éxito.');
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesión cerrada con éxito.');
    }

}
