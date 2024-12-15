@extends('layouts.admin')
@section('content')

<div class="container my-4">
    <h1 class="text-start text-success mb-4">Panel de control de seguridad e higiene</h1>
    <p class="text-start mb-4">Bienvenido a tu espacio de gestión.</p>
    <p class="text-start mb-4">Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

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
                            <td> {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</td>
                            <td> {{ $task->completed_at ? $task->completed_at->format('d/m/Y') : '' }}</td>
                            <td>
                                <div class="d-flex justify-content-start gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm rounded-3" aria-label="Editar Usuario">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-3" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');" aria-label="Eliminar Tarea">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    <!-- Botón Ver Detalles -->
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm rounded-3" aria-label="Ver detalles de tarea">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
