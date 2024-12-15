@extends(auth()->check() && auth()->user()->role ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main') : 'layouts.main')

@section('content')
<div class="container my-3">
    <h1 class="text-start text-success mb-4">Panel de control de seguridad e higiene</h1>
    <p class="text-start mb-4">Bienvenido a tu espacio de gestión.</p>
    <p class="text-start mb-4">Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

    <!-- Modal para Crear Nueva Tarea -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Crear tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de Creación de Tarea -->
                    <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}" novalidate>
                        @csrf

                        <!-- Título -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="titleHelp" class="form-text">Introduce un título descriptivo para la tarea.</div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Área -->
                        <div class="mb-3">
                            <label for="area" class="form-label">Área</label>
                            <select id="area" name="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                                <option value="">Seleccionar Área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted mt-1">Si no encuentras el área, solicita al administrador que la cree.</small>
                        </div>

                        <!-- Botón de Crear Tarea -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Crear Tarea</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="alert alert-white shadow-lg rounded p-3 my-4 bg-body d-flex align-items-center">
            <div class="d-flex flex-wrap w-100 justify-content-between">
                <!-- Tarea Vencida -->
                <div class="d-flex align-items-center me-2">
                    <i class="bi bi-calendar-x text-danger fs-5 me-2" title="Tarea vencida"></i>
                    <span>Tarea Vencida</span>
                </div>

                <!-- Tarea Pendiente -->
                <div class="d-flex align-items-center me-2">
                    <i class="bi bi-hourglass-split text-warning fs-5 me-2" title="Tarea pendiente"></i>
                    <span>Tarea Pendiente</span>
                </div>

                <!-- Tarea Completada -->
                <div class="d-flex align-items-center me-2 ">
                    <i class="bi bi-check-circle text-success fs-5 me-2" title="Tarea completada"></i>
                    <span>Tarea Completada</span>
                </div>

                <!-- Botón para abrir el modal de crear tarea -->
                @can('create_tasks')
                <div class="d-flex align-items-center me-2 ms-auto">
                    <button type="button" class="btn btn-success rounded-circle" data-bs-toggle="modal" data-bs-target="#createTaskModal" aria-label="Crear Nueva Tarea">
                        <i class="bi bi-window-plus fs-4"></i>
                    </button>
                </div>
                @endcan

            </div>
        </div>
    </div>


    <!-- Tareas -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
        @foreach ($tasks as $task)
<!-- Tarea Card -->
<div class="col">
    <div class="card h-100 border-0
        {{
            $task->due_date < now() ? 'text-black' :
            ($task->status == 'Completada' ? 'shadow-success' : 'shadow-warning text-dark')
        }}">

        <div class="card-body d-flex flex-column shadow-lg rounded">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Menú de Puntitos (Dropdown) -->
                <div class="dropdown">
                    <button class="btn btn-link p-0 dropdown-toggle" type="button" id="taskOptionsDropdown{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="taskOptionsDropdown{{ $task->id }}">
                        <li>
                            @can('edit_tasks')
                            <a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            @endcan
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks.show', $task->id) }}">
                                <i class="bi bi-eye"></i> Ver Tarea
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Título de la tarea -->
                <p class="card-title mb-0 py-2 text-truncate border-bottom border-black text-start">{{ $task->title }}</p>

                <!-- Estado de la tarea -->
                <div class="task-status text-start">
                    @if ($task->due_date < now() && $task->status == 'Completada con retraso')
                        <i class="bi bi-calendar-x text-danger" title="Tarea Vencida"></i>
                        <i class="bi bi-check-circle text-success" title="Tarea Completada"></i>
                    @elseif ($task->due_date < now())
                        <i class="bi bi-calendar-x text-danger" title="Tarea Vencida"></i>
                    @elseif ($task->status == 'Pendiente')
                        <i class="bi bi-hourglass-split text-warning" title="Tarea Pendiente"></i>
                    @elseif ($task->status == 'Completada')
                        <i class="bi bi-check-circle text-success" title="Tarea Completada"></i>
                    @endif
                </div>
            </div>

            <p class="card-text text-start">{{ Str::limit($task->description, 100) }}</p>
            <p class="card-text text-start"><strong>Área:</strong> {{ $task->area->name ?? 'Sin área' }}</p>
            <p class="card-text text-start"><strong>Fecha de vencimiento:</strong> {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</p>
            <p class="card-text text-start">
              <strong>Estado:</strong>
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
                  <i class="bi bi-exclamation-triangle-fill text-warning me-2" title="Tarea completada con retraso"></i>
                @endif
                {{ $task->status }}
              </span>
            </p>
        </div>
    </div>
</div>

        @endforeach
    </div>
  </div>

<script>
    // Mantener el modal abierto si hay errores
    @if ($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
        myModal.show();
    @endif
</script>
@endsection
