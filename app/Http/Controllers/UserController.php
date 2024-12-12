<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('users.index', compact('users')); // Vista para listar usuarios
    }

    public function show(User $user)
    {
        return view('users.show', compact('user')); // Vista para mostrar detalles del usuario
    }

    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        $permissions = Permission::all(); // Obtener todos los permisos
        return view('users.create', compact('roles', 'permissions')); // Vista para crear usuario
    }

    public function store(Request $request)
    {
        // Mostrar los datos para depurar
  //      dd($request->all()); // Muestra todos los datos recibidos

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8', // Asegurarse de que ambas contraseñas coincidan
            'roles' => 'required|array|exists:roles,name',
        ]);

      //  dd($request->roles); // Verifica los roles que se están enviando


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asigna los roles (los permisos se asignarán automáticamente según el rol)
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }



    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener todos los roles
        $permissions = Permission::all(); // Obtener todos los permisos
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array', // Requiere un array de roles
            'permissions' => 'required|array', // Requiere un array de permisos
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Actualizar la contraseña si se proporciona
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sincronizar roles y permisos
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

}
