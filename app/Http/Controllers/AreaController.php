<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        // Si el usuario no está autenticado, redirigirlo a la página de login
        $this->middleware('auth');
    }
  /**
   * Muestra una lista de todas las áreas.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    // Verificamos si el usuario tiene el permiso para ver áreas
    if (!auth()->user()->can('view_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para acceder a esta sección.');
    }

    $areas = Area::all();
    return view('areas.index', compact('areas'));
  }

  /**
   * Muestra los detalles de una área específica.
   *
   * @param \App\Models\Area $area
   * @return \Illuminate\View\View
   */
  public function show(Area $area)
  {
    // Verificamos si el usuario tiene el permiso para ver áreas
    if (!auth()->user()->can('view_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para acceder a esta sección.');
    }

    return view('areas.show', compact('area'));
  }

  /**
   * Muestra el formulario para crear una nueva área.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    // Verificamos si el usuario tiene el permiso para crear áreas
    if (!auth()->user()->can('create_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para crear áreas.');
    }

    return view('areas.create');
  }

  /**
   * Almacena una nueva área en la base de datos.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    // Verificamos si el usuario tiene el permiso para crear áreas
    if (!auth()->user()->can('create_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para crear áreas.');
    }

    // Validamos que el nombre del área sea único y requerido
    $request->validate([
      'name' => 'required|string|max:255|unique:areas,name',
    ], [
      'name.unique' => 'Ya existe un área con ese nombre. Por favor, elige otro.',
    ]);

    // Crear el nuevo registro de Area
    $area = Area::create($request->only('name'));

    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '"  creada con éxito.');
  }

  /**
   * Muestra el formulario para editar una área existente.
   *
   * @param \App\Models\Area $area
   * @return \Illuminate\View\View
   */
  public function edit(Area $area)
  {
    // Verificamos si el usuario tiene el permiso para editar áreas
    if (!auth()->user()->can('edit_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para editar áreas.');
    }

    return view('areas.edit', compact('area'));
  }

  /**
   * Actualiza los datos de una área en la base de datos.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Area $area
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Area $area)
  {
    // Verificamos si el usuario tiene el permiso para editar áreas
    if (!auth()->user()->can('edit_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para editar áreas.');
    }

    // Validar que el nombre no esté duplicado, pero excluir la área actual
    $request->validate([
      'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
    ], [
      'name.unique' => 'Ya existe un área con ese nombre. Por favor, elige otro.',
    ]);

    // Actualizar la área
    $area->update($request->only('name'));

    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '" actualizada con éxito.');
  }

  /**
   * Elimina una área de la base de datos.
   *
   * @param \App\Models\Area $area
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Area $area)
  {
    // Verificamos si el usuario tiene el permiso para eliminar áreas
    if (!auth()->user()->can('delete_areas')) {
      return redirect()->route('dashboards.index')->with('error', 'No tienes permisos para eliminar áreas.');
    }

    $area->delete();

    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '" eliminada con éxito.');
  }
}
