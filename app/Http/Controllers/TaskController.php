<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
  /**
   * Muestra una lista de todas las tareas.
   *
   * Este método maneja la solicitud para obtener todas las tareas
   * junto con las áreas relacionadas y mostrarlas en la vista de tareas.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $tasks = Task::with('area')->get();
    $areas = Area::all();  // Carga todas las áreas
    return view('tasks.index', compact('tasks', 'areas'));
  }

  /**
   * Muestra los detalles de una tarea específica.
   *
   * Este método maneja la solicitud para mostrar los detalles de una tarea.
   * Verifica si el usuario tiene permisos para ver la tarea.
   *
   * @param \App\Models\Task $task
   * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
   */
  public function show(Task $task)
  {
    // Verificar si el usuario tiene permiso para ver tareas
    if (!auth()->user()->can('view_tasks')) {
      return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para ver los detalles de la tarea.');
    }

    $areas = Area::all(); // Carga todas las áreas
    return view('tasks.show', compact('task', 'areas'));
  }

  /**
   * Muestra el formulario para crear una nueva tarea.
   *
   * Este método maneja la solicitud para mostrar el formulario de creación
   * de una nueva tarea. Si el usuario no está autenticado, lo redirige
   * a la página de inicio de sesión.
   *
   * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
   */
  public function create()
  {
    if (!auth()->check()) {
      return redirect()->route('auth.login');
    }

    // Cargar todas las áreas
    $areas = Area::all();
    return view('tasks.create', compact('areas'));
  }

  /**
   * Almacena una nueva tarea en la base de datos.
   *
   * Este método maneja la solicitud para almacenar una nueva tarea.
   * Verifica que los datos enviados sean válidos y que el usuario tenga permisos
   * para crear tareas antes de proceder.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
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

  /**
   * Verifica si la tarea está completada y redirige en consecuencia.
   *
   * Este método se usa internamente para comprobar si la tarea está completada
   * y si el usuario tiene permisos para editarla. Si no tiene permisos, lo redirige.
   *
   * @param \App\Models\Task $task
   * @return \Illuminate\Http\RedirectResponse|null
   */
  private function checkTaskCompletion(Task $task)
  {
    if ($task->status === 'Completada') {
      $user = auth()->user();

      // Verificar si el usuario tiene el permiso 'edit_tasks'
      if (!$user->can('edit_tasks')) {
        // Redirigir a la página anterior con un mensaje de error
        $previousUrl = url()->previous();
        $message = 'No tienes permisos suficientes para editar una tarea completada.';
        return redirect($previousUrl)->with('error', $message);
      }
    }

    // Si la tarea no está completada o el usuario tiene permisos, no hacemos nada
    return null;
  }

  /**
   * Muestra el formulario para editar una tarea.
   *
   * Este método maneja la solicitud para mostrar el formulario de edición
   * de una tarea. Verifica si el usuario tiene permisos para editarla
   * y si la tarea está completada.
   *
   * @param \App\Models\Task $task
   * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
   */
  public function edit(Task $task)
  {
    // Guardamos la URL anterior en la sesión
    session()->put('previous_url', url()->previous());

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

  /**
   * Actualiza una tarea en la base de datos.
   *
   * Este método maneja la solicitud para actualizar los datos de una tarea.
   * Verifica que el usuario tenga permisos para editarla y que los datos
   * sean válidos antes de proceder con la actualización.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Task $task
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Task $task)
  {
    // Verificar si el usuario tiene permiso para actualizar
    if (!auth()->user()->can('edit_tasks')) {
      return redirect()->route('tasks.index')->with('error', 'Lo siento, no tienes permisos suficientes para actualizar esta tarea.');
    }

    // Validar los datos
    $request->validate([
      'title' => 'required|string|max:255',
      'area_id' => 'required|exists:areas,id',
      'due_date' => 'required|date',
      'status' => 'required|in:Pendiente,Completada,Completada con retraso', // Aseguramos que los estados posibles sean estos
    ]);

    // Si el estado se está cambiando a "Completada", verificamos si la fecha de vencimiento ya pasó
    if ($request->status === 'Completada') {
      // Convertir la fecha de vencimiento a un objeto Carbon
      $dueDate = Carbon::parse($task->due_date);

      // Si la fecha de vencimiento ya pasó, cambiamos el estado a "Completada con retraso"
      if ($dueDate->isPast()) {
        $task->status = 'Completada con retraso';
        \Log::info('Tarea marcada como Completada con retraso debido a la fecha vencida');
      } else {
        // Si la tarea está dentro del plazo, se marca como "Completada"
        $task->status = 'Completada';
        \Log::info('Tarea marcada como Completada');
      }

      // Marcar la fecha de completado
      $task->completed_at = Carbon::now();
    } else {
      // Si el estado es "Pendiente", no hay necesidad de ajustar el estado
      $task->status = 'Pendiente';
      $task->completed_at = null; // No hay fecha de completado
    }

    // Actualizar la tarea con los datos
    $task->update([
      'title' => $request->title,
      'description' => $request->description,
      'area_id' => $request->area_id,
      'due_date' => $request->due_date,
      'status' => $task->status, // Este estado ya fue actualizado
      'completed_at' => $task->completed_at, // Actualizamos completed_at
    ]);

    // Mensaje de éxito dependiendo si la tarea fue completada a tiempo o no
    $message = Carbon::parse($task->due_date)->isPast() ?
      "La tarea <strong>{$task->title}</strong> fue actualizada, pero la <i>fecha de vencimiento</i> ya expiró." :
      "Tarea <strong>{$task->title}</strong> actualizada con éxito.";

    // Redirigir a la URL guardada previamente en la sesión o al índice
    $previousUrl = session()->get('previous_url', route('dashboards.index'));
    return redirect($previousUrl)->with('success', $message);
  }

  /**
   * Elimina una tarea de la base de datos.
   *
   * Este método maneja la solicitud para eliminar una tarea de la base de datos.
   * Verifica si el usuario tiene permisos para eliminarla antes de proceder.
   *
   * @param \App\Models\Task $task
   * @return \Illuminate\Http\RedirectResponse
   */
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
