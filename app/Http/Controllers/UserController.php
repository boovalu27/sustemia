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
        // Asegúrate de que los permisos están siendo cargados correctamente
        $user->load('permissions');  // Carga la relación de permisos

        return view('users.show', compact('user'));
    }


    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        $permissions = Permission::all(); // Obtener todos los permisos
        return view('users.create', compact('roles', 'permissions')); // Vista para crear usuario
    }

    public function store(Request $request)
    {
        // Validación de datos con mensajes personalizados
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|exists:roles,name', // Validación para un solo rol
            'permissions' => 'nullable|array|exists:permissions,name', // Permisos opcionales
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'surname.string' => 'El apellido debe ser una cadena de texto.',
            'surname.max' => 'El apellido no puede tener más de 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'Ya existe un usuario registrado con ese correo electrónico.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'roles.required' => 'El rol es obligatorio.',
            'roles.exists' => 'El rol seleccionado no es válido.',

            'permissions.array' => 'Los permisos deben ser un arreglo de valores.',
            'permissions.exists' => 'Uno o más de los permisos seleccionados no son válidos.',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar el rol al usuario
        $user->assignRole($request->roles); // Asignar solo un rol

        // Obtener el rol seleccionado
        $role = Role::with('permissions')->where('name', $request->roles)->first();

        // Verificar si el rol existe y tiene permisos asociados
        if ($role) {
            // Verificar si el rol tiene permisos
            if ($role->permissions->isEmpty()) {
                return redirect()->route('users.index')->with('error', 'El rol no tiene permisos asignados.');
            }

            // Permisos asociados al rol
            $rolePermissions = $role->permissions->pluck('name')->toArray();

            // Si se seleccionaron permisos adicionales, fusionarlos
            if (!empty($request->permissions)) {
                $allPermissions = array_merge($rolePermissions, $request->permissions);
                $user->syncPermissions($allPermissions); // Sincroniza permisos combinados
            } else {
                // Si no se seleccionaron permisos adicionales, asignar solo los permisos del rol
                $user->syncPermissions($rolePermissions); // Sincroniza solo los permisos del rol
            }
        } else {
            return redirect()->route('users.index')->with('error', 'Rol no encontrado.');
        }

        // Redirigir después de la creación
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }




    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener todos los roles
        $permissions = Permission::all(); // Obtener todos los permisos
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray(); // Obtener permisos actuales del usuario

        return view('users.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|exists:roles,name',
            'permissions' => 'nullable|array|exists:permissions,name', // Permisos pueden ser un array
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'surname.string' => 'El apellido debe ser una cadena de texto.',
            'surname.max' => 'El apellido no puede tener más de 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'Ya existe un usuario registrado con ese correo electrónico.',

            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'roles.required' => 'El rol es obligatorio.',
            'roles.exists' => 'El rol seleccionado no es válido.',

            'permissions.array' => 'Los permisos deben ser un arreglo de valores.',
            'permissions.exists' => 'Uno o más de los permisos seleccionados no son válidos.',
        ]);

        // Actualizamos los datos básicos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        // Si se proporciona una nueva contraseña, la actualizamos
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Actualizamos el apellido si se proporciona
        $user->surname = $request->surname;

        // Guardamos los datos del usuario
        $user->save();

        // Sincronizamos el rol con el nuevo rol
        $user->syncRoles([$request->roles]);

        // Sincronizamos los permisos seleccionados
        if ($request->has('permissions')) {
            // Sincroniza solo los permisos seleccionados
            $user->syncPermissions($request->permissions);
        } else {
            // Si no se seleccionan permisos, eliminamos todos los permisos del usuario
            $user->syncPermissions([]);
        }

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function destroy(User $user)
    {
        // No permitir eliminar el propio usuario
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete(); // Eliminar el usuario
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
