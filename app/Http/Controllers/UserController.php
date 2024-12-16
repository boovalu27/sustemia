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
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array|exists:roles,name', // Roles obligatorios
            'permissions' => 'nullable|array|exists:permissions,name', // Permisos opcionales
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar los roles al usuario
        $user->syncRoles($request->roles); // Asignar los roles seleccionados

        // Obtener todos los permisos asociados a los roles seleccionados
        $rolePermissions = collect();
        foreach ($request->roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                // Obtener los permisos asociados a este rol
                $rolePermissions = $rolePermissions->merge($role->permissions);
            }
        }

        // Convertir los permisos del rol a un array de nombres
        $rolePermissionsNames = $rolePermissions->pluck('name')->toArray();

        // Combinar los permisos del rol con los permisos adicionales seleccionados
        $allPermissions = array_merge($rolePermissionsNames, $request->permissions ?? []);

        // Sincronizar los permisos (del rol + permisos adicionales seleccionados)
        $user->syncPermissions($allPermissions);

        // Redirigir después de la creación
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener todos los roles
        $permissions = Permission::all(); // Obtener todos los permisos
        $userPermissions = $user->permissions->pluck('name')->toArray(); // Obtener permisos actuales del usuario
        return view('users.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Validación única, pero excluyendo el ID actual
            'password' => 'nullable|string|min:8|confirmed', // Contraseña opcional
            'roles' => 'required|array|exists:roles,name', // Roles
            'permissions' => 'nullable|array|exists:permissions,name', // Permisos
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sincronizar los roles y permisos
        $user->syncRoles($request->roles);
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        }

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
