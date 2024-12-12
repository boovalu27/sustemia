<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('area')->get();
        $areas = Area::all();  // Carga todas las áreas
        return view('tasks.index', compact('tasks', 'areas'));
    }



    public function show(Task $task)
    {
        $areas = Area::all(); // Carga todas las áreas
        return view('tasks.show', compact('task', 'areas'));
    }



    public function create()
    {
        $areas = Area::all();  // Carga todas las áreas
        return view('tasks.create', compact('areas'));
    }


    public function store(Request $request)
    {
        // Validación de los campos requeridos
        $request->validate([
            'title' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'due_date' => 'required|date|after_or_equal:today',
        ], [
            'title.required' => 'El título es obligatorio y no puede estar vacío.',
            'title.max' => 'El título no puede exceder los 255 caracteres.',
            'area_id.required' => 'Debes seleccionar un área para la tarea.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'due_date.required' => 'La fecha de vencimiento es obligatoria.',
            'due_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'due_date.after_or_equal' => 'La fecha de vencimiento no puede ser menor a la fecha actual.',
        ]);

    // Verificar si el usuario tiene permiso para crear tareas
    if (!auth()->user()->can('create_tasks')) {
        abort(403, 'No tienes permisos para crear una tarea.');
    }

        // Si la validación pasa, crear la tarea
        $task = Task::create([
            'user_id' => auth()->id(),
            'area_id' => $request->area_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'Pendiente',
        ]);

        // Redireccionar según el rol del usuario
        $user = auth()->user();
        if ($user->role->name === 'editor') {
            return redirect()->route('editor.index')->with('success', 'Tarea "' . $task->title . '" creada con éxito.');
        } elseif ($user->role->name === 'admin') {
            return redirect()->route('tasks.index')->with('success', 'Tarea "' . $task->title . '" creada con éxito.');
        }

        // Redirección por defecto si no se encuentra el rol
        return redirect()->route('tasks.index')->with('success', 'Tarea "' . $task->title . '" creada con éxito.');
    }


// Método común para verificar si la tarea está completada y redirigir
private function checkTaskCompletion(Task $task)
{
    if ($task->status === 'Completada') {
        $user = auth()->user();
        $route = $user->role->name === 'editor' ? 'dashboards.index' : 'tasks.index';
        $message = 'No se puede editar una tarea completada.';
        return redirect()->route($route)->with('error', $message);
    }
}

public function edit(Task $task)
{
    $user = auth()->user();

    // Comprobar que el usuario tiene el permiso y el rol adecuado
    if (!$user->can('edit_tasks') || !in_array($user->role?->name, ['admin', 'editor'])) {
        abort(403, 'No tienes permisos para editar esta tarea.');
    }

    // Verificar si la tarea está completada
    return $this->checkTaskCompletion($task) ?: view('tasks.edit', [
        'task' => $task,
        'areas' => Area::all(),
    ]);
}



public function update(Request $request, Task $task)
{
    // Verificar si el usuario tiene permiso para actualizar
    if (!auth()->user()->can('edit_tasks') || (auth()->user()->role?->name !== 'admin' && auth()->user()->role?->name !== 'editor')) {
        abort(403, 'No tienes permisos para actualizar esta tarea.');
    }

    // Verificar si la tarea está completada
    if ($response = $this->checkTaskCompletion($task)) {
        return $response;
    }

    // Validar los datos
    $request->validate([
        'title' => 'required|string|max:255',
        'area_id' => 'required|exists:areas,id',
        'due_date' => 'required|date',
        'status' => 'required|in:Pendiente,Completada',
        'description' => 'required|string',
    ]);

    // Si el estado es "Completada" y no tiene fecha de cierre, asignamos la fecha actual
    if ($request->status === 'Completada') {
        if (!$task->completed_at) {
            $task->completed_at = Carbon::now();
        }

        // Verificar si la tarea está vencida (si la fecha de vencimiento ya pasó)
        $isOverdue = Carbon::parse($task->due_date)->isPast();

        // Si está vencida, asignar el estado "Completada con retraso"
        if ($isOverdue) {
            $task->status = 'Completada con retraso';
        } else {
            // Si no está vencida, asignar el estado "Completada"
            $task->status = 'Completada';
        }
    } else {
        // Si el estado es "Pendiente", eliminamos la fecha de cierre
        $task->completed_at = null;
        $task->status = 'Pendiente';
    }

    // Actualizar la tarea con los nuevos valores
    $task->update($request->only('title', 'description', 'area_id', 'due_date', 'status'));

    // Comprobar si la tarea está vencida para el mensaje
    $isOverdue = Carbon::parse($task->due_date)->isPast();

    // Mensaje de éxito dependiendo de si la tarea está vencida o no
    if ($isOverdue) {
        $message = 'La tarea <strong>' . $task->title . '</strong> fue actualizada, pero la <i>fecha de vencimiento</i> ya expiró.';
    } else {
        $message = 'Tarea <strong>' . $task->title . '</strong> actualizada con éxito.';
    }

    // Redireccionar según el rol del usuario
    return redirect()->route(auth()->user()->role->name === 'editor' ? 'dashboards.index' : 'tasks.index')
        ->with('success', $message);
}

    public function destroy(Task $task)
    {
    // Verificar si el usuario tiene permiso para eliminar
    if (!auth()->user()->can('delete_tasks') || auth()->user()->role?->name !== 'admin') {
        abort(403, 'No tienes permisos para eliminar esta tarea.');
    }

        $task->delete();

        // Redireccionar según el rol del usuario
        $user = auth()->user();
        if ($user->role->name === 'editor') {
            return redirect()->route('dashboards.index')->with('success', 'Tarea eliminada con éxito.');
        } elseif ($user->role->name === 'admin') {
            return redirect()->route('dashboards.index')->with('success', 'Tarea eliminada con éxito.');
        }

        // Redirección por defecto si no se encuentra el rol
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
    }

}
