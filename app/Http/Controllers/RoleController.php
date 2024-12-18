<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Muestra una lista de todos los roles.
   *
   * Este método maneja la solicitud para obtener todos los roles
   * y mostrarlos en la vista de administración.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $roles = Role::all();
    return view('admin.roles.index', compact('roles'));
  }

  /**
   * Muestra el formulario para crear un nuevo rol.
   *
   * Este método maneja la solicitud para mostrar el formulario de creación
   * de un nuevo rol en el sistema.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('admin.roles.create');
  }

  /**
   * Almacena un nuevo rol en la base de datos.
   *
   * Este método maneja la solicitud para almacenar un nuevo rol en la base de datos.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $request->validate(['name' => 'required|string|max:30']);

    Role::create(['name' => $request->name]);

    return redirect()->route('admin.roles.index')->with('success', 'Rol creado exitosamente.');
  }

  /**
   * Muestra el formulario para editar un rol existente.
   *
   * Este método maneja la solicitud para mostrar el formulario de edición
   * de un rol existente.
   *
   * @param \App\Models\Role $role
   * @return \Illuminate\View\View
   */
  public function edit(Role $role)
  {
    return view('admin.roles.edit', compact('role'));
  }

  /**
   * Actualiza un rol en la base de datos.
   *
   * Este método maneja la solicitud para actualizar un rol existente
   * en la base de datos.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Role $role
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Role $role)
  {
    $request->validate(['name' => 'required|string|max:30']);

    $role->update(['name' => $request->name]);

    return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente.');
  }

  /**
   * Elimina un rol de la base de datos.
   *
   * Este método maneja la solicitud para eliminar un rol de la base de datos.
   *
   * @param \App\Models\Role $role
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Role $role)
  {
    $role->delete();
    return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente.');
  }
}
