<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Método para mostrar las tareas
    public function index()
    {
        $tasks = Task::with('area')->get();
        $areas = Area::all();  // Carga todas las áreas
        return view('tasks.index', compact('tasks', 'areas'));
    }

// Método para mostrar los detalles de una tarea
public function show(Task $task)
{
    // Verificar si el usuario tiene permiso para ver tareas
    if (!auth()->user()->can('view_tasks')) {
        return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para ver los detalles de la tarea.');
    }

    $areas = Area::all(); // Carga todas las áreas
    return view('tasks.show', compact('task', 'areas'));
}


    // Método para mostrar el formulario de creación
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        // Cargar todas las áreas
        $areas = Area::all();
        return view('tasks.create', compact('areas'));
    }

    // Método para almacenar una nueva tarea
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
            return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para crear tareas.');
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

        // Redireccionar a la página anterior después de crear la tarea
        $previousUrl = url()->previous();  // Obtener la URL anterior
        return redirect($previousUrl)->with('success', 'Tarea "' . $task->title . '" creada con éxito.');
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

    // Método para mostrar el formulario de edición de tarea
    public function edit(Task $task)
    {
        $user = auth()->user();

        // Comprobar que el usuario tiene el permiso y el rol adecuado
        if (!$user->can('edit_tasks')) {
            return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para editar tareas.');
        }

        // Verificar si la tarea está completada
        return $this->checkTaskCompletion($task) ?: view('tasks.edit', [
            'task' => $task,
            'areas' => Area::all(),
        ]);
    }


    // Método para actualizar una tarea
    public function update(Request $request, Task $task)
    {
        // Verificar si el usuario tiene permiso para actualizar
        if (!auth()->user()->can('edit_tasks')) {
            return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para actualizar esta tarea.');
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

        if ($request->status === 'Completada') {
            $task->completed_at = Carbon::now();
            $task->status = Carbon::parse($task->due_date)->isPast() ? 'Completada con retraso' : 'Completada';
        } else {
            $task->completed_at = null;
            $task->status = 'Pendiente';
        }

        // Actualizar tarea
        $task->update($request->only('title', 'description', 'area_id', 'due_date', 'status'));

        // Redireccionar con mensaje de éxito
        $message = Carbon::parse($task->due_date)->isPast() ?
            "La tarea <strong>{$task->title}</strong> fue actualizada, pero la <i>fecha de vencimiento</i> ya expiró." :
            "Tarea <strong>{$task->title}</strong> actualizada con éxito.";

        // Redirigir a la página correspondiente
        return redirect(url()->previous())->with('success', $message);
    }


    // Método para eliminar tarea
    public function destroy(Task $task)
    {
        // Verificar permisos de eliminación
        if (!auth()->user()->can('delete_tasks')) {
            return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para eliminar tareas.');
        }

        // Eliminar tarea
        $task->delete();

        // Redireccionar a la página previa con mensaje de éxito
        return redirect(url()->previous())->with('success', 'Tarea "' . $task->title . '" eliminada con éxito.');
    }

}
