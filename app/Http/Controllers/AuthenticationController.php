<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
  /**
   * Crea una nueva instancia del controlador y aplica el middleware de autenticación.
   *
   * El middleware 'auth' se aplica a todas las rutas, excepto para login, logout,
   * y las rutas relacionadas con el cambio de contraseña.
   */
  public function __construct()
  {
    $this->middleware('auth')->except(['login', 'processLogin', 'logout', 'showChangePasswordForm', 'resetPassword']);
  }

  /**
   * Muestra el formulario de inicio de sesión.
   *
   * Si el usuario ya está autenticado, redirige a la página principal del panel.
   *
   * @return \Illuminate\View\View
   */
  public function login()
  {
    if (Auth::check()) {
      return redirect()->route('dashboards.index');
    }

    return view('auth.login');
  }

  /**
   * Procesa los datos de inicio de sesión enviados por el formulario.
   *
   * Valida las credenciales del usuario y, si son correctas, inicia sesión y lo redirige al panel.
   * Si las credenciales son incorrectas, se vuelve a mostrar el formulario con un mensaje de error.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
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

    // Aquí puedes manejar otros roles si es necesario
    return redirect()->route('reports.index')->with('success', '¡Hola ' . $user->name . '! Has iniciado sesión con éxito.');
  }

  /**
   * Cierra la sesión del usuario autenticado.
   *
   * Después de cerrar la sesión, el usuario es redirigido a la página principal.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function logout()
  {
    Auth::logout();
    return redirect('/')->with('success', 'Sesión cerrada con éxito.');
  }

  /**
   * Muestra el formulario para restablecer la contraseña.
   *
   * Este formulario permite a los usuarios cambiar su contraseña si es necesario.
   *
   * @return \Illuminate\View\View
   */
  public function showChangePasswordForm()
  {
    return view('auth.password.reset');
  }

  /**
   * Procesa el restablecimiento de la contraseña.
   *
   * Valida los datos de la solicitud, verifica que el correo esté registrado, y actualiza la contraseña del usuario.
   * Si el correo no está registrado, se muestra un mensaje de error.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function resetPassword(Request $request)
  {
    // Validación de los datos del formulario
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
    $user->save(); // Guardar el cambio de contraseña

    // Redirigir al usuario con un mensaje de éxito
    session()->flash('success', 'Contraseña restablecida exitosamente. Por favor, ingresa nuevamente.');
    return redirect()->route('auth.login');
  }
}
