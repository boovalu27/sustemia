@extends('layouts.admin')

@section('content')

<div class="container my-4">
    <h1 class="text-start text-success mb-4">Lista de tareas</h1>
    <p class="text-start mb-4">Administra y visualiza las tareas registradas en la plataforma.</p>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3" aria-label="Agregar nueva tarea">
            <i class="bi bi-person-plus-fill"></i> Agregar
        </a>
    </div>

    @if ($tasks->isEmpty())
        <div class="alert alert-warning" role="alert">No hay tareas registradas.</div>
    @else
        <div class="table-responsive border rounded-2 p-3">
            <table class="table table-striped table-hover">
                <thead class="py-2">
                    <tr>
                        <th>Creador</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Área</th>
                        <th>Estado</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Fecha de Cierre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->user->name ?? 'Sin usuario' }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ Str::limit($task->description, 100) }}</td>
                            <td>{{ $task->area->name ?? 'Sin área' }}</td>
                            <td>
                                <span class="badge
                                @if ($task->status == 'Pendiente' && $task->due_date < now())
                                    bg-success
                                @elseif ($task->status == 'Pendiente')
                                    bg-warning text-dark
                                @elseif ($task->status == 'Completada')
                                    bg-success
                                @elseif ($task->status == 'Completada con retraso')
                                    bg-success text-white border
                                @endif
                            ">

                                @if ($task->status == 'Completada con retraso')
                                    <i class="bi bi-exclamation-triangle-fill text-warning" title="Tarea completada con retraso"></i>
                                @endif
                                {{ $task->status }}
                                </span>
                            </td>
                            <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</td>
                            <td>{{ $task->completed_at ? $task->completed_at->format('d/m/Y') : '' }}</td>
                            <td>
                                <div class="d-flex justify-content-start gap-2">
                                    <!-- Botón Editar -->
                                    @can('edit_tasks')
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm rounded-3" aria-label="Editar Tarea">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    @endcan
                                    <!-- Botón Eliminar (abre el modal de confirmación) -->
                                    @can('delete_tasks')
                                    <button class="btn btn-danger btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#deleteModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" aria-label="Eliminar Tarea">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    @endcan
                                    <!-- Botón Ver Detalles -->
                                    @can('view_tasks')
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm rounded-3" aria-label="Ver detalles de tarea">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar la tarea <strong id="taskName"></strong>? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteTaskForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Cambiar el formulario de eliminación en el modal según la tarea seleccionada
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botón que abrió el modal
        var taskId = button.getAttribute('data-task-id'); // Obtener el ID de la tarea
        var taskTitle = button.getAttribute('data-task-title'); // Obtener el título de la tarea

        // Establecer la acción del formulario con la URL de la tarea seleccionada
        var form = document.getElementById('deleteTaskForm');
        form.action = '{{ url('tasks') }}/' + taskId; // Establece la URL de eliminación con el ID correcto

        // Establecer el nombre de la tarea en el modal
        var taskName = document.getElementById('taskName');
        taskName.textContent = taskTitle; // Mostrar el nombre de la tarea en el modal
    });
</script>

@endsection
