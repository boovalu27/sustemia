<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
   public function login()
   {
       if (Auth::check()) {
           return redirect()->route('dashboards.index'); // O la ruta adecuada
       }

       return view('auth.login');
   }

   public function processLogin(Request $request)
   {
       // Validación de los datos del formulario
       $request->validate([
           'email' => 'required|email', // Validar que el correo sea válido
           'password' => 'required|string', // Validar que la contraseña no esté vacía
       ], [
           'email.required' => 'El correo electrónico es obligatorio.',
           'email.email' => 'El correo electrónico debe tener un formato válido.',
           'password.required' => 'La contraseña es obligatoria.',
           'password.string' => 'La contraseña debe ser una cadena de texto.',
       ]);

       $credentials = $request->only('email', 'password');

       // Intentar autenticar al usuario con las credenciales proporcionadas
       if (!Auth::attempt($credentials)) {
           return redirect()->route('auth.login')
               ->with('warning', 'Las credenciales son incorrectas. Por favor, revisa tu correo y contraseña.')
               ->withInput(); // Permite que los campos ya llenados se mantengan al regresar al formulario
       }

       // Obtener el usuario autenticado
       $user = Auth::user();

       // Verificar si el usuario tiene un rol asignado
       if (!$user->role) {
           return redirect()->route('auth.login')
               ->with('error', 'El usuario no tiene un rol asignado.')
               ->withInput();
       }

       // Redirigir según el rol del usuario
       if ($user->hasRole('admin')) {
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

        // Mostrar el formulario de cambio de contraseña
        public function showChangePasswordForm()
        {
            return view('auth.password.change');
        }

        // Cambiar la contraseña
        public function changePassword(Request $request)
        {
            // Validar los datos del formulario
            $request->validate([
                'email' => 'required|email|exists:users,email',  // Asegurarse de que el correo esté registrado
                'password' => 'required|string|min:8|confirmed', // Validar la nueva contraseña
            ], [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe tener un formato válido.',
                'email.exists' => 'Este correo electrónico no está registrado en nuestros registros.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);

            // Buscar al usuario por su correo electrónico
            $user = User::where('email', $request->email)->first();

            // Si no se encuentra el usuario, retornar un error
            if (!$user) {
                return back()->withErrors(['email' => 'El correo electrónico no está registrado.']);
            }

            // Cambiar la contraseña del usuario
            $user->password = Hash::make($request->password);
            $user->save();  // Guardar el cambio de contraseña

            // Redirigir al usuario con un mensaje de éxito
            session()->flash('success', 'Contraseña cambiada exitosamente. Por favor, ingrese nuevamente.');
            return redirect()->route('auth.login');

        }

}
