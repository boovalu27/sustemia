<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
  public function index()
  {
    $areas = Area::all();
    return view('areas.index', compact('areas'));
  }

  public function show(Area $area)
  {
    return view('areas.show', compact('area'));
  }

  public function create()
  {
    return view('areas.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    Area::create($request->only('name'));

    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '"  creada con éxito.');
  }

  public function edit(Area $area)
  {
    return view('areas.edit', compact('area'));
  }

  public function update(Request $request, Area $area)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    $area->update($request->only('name'));

    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '" actualizada con éxito.');
  }

  public function destroy(Area $area)
  {
    $area->delete();
    return redirect()->route('areas.index')->with('success', 'Área "' . $area->name . '" eliminada con éxito.');
  }
}
