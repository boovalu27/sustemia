@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container my-3">
    <h1 class="mb-4 text-start text-success">Panel de control de seguridad e higiene</h1>
    <p class="text-start my-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-start py-2">Aquí podrás gestionar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

      <!-- Modal para Crear Nueva Tarea -->
      <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title text-start" id="createTaskModalLabel">Crear tarea</h2>
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
                    <option value="">Seleccionar área</option>
                    @foreach ($areas as $area)
                      <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                  </select>
                  @error('area_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="form-text text-muted mt-1">Si no encuentras el área, puedes <a href="javascript:void(0);" id="requestNewAreaLink" class="link-primary" onclick="toggleNewAreaField()">solicitar una nueva</a>.</small>
                </div>

                <!-- Campo adicional para solicitar nueva área -->
                <div id="newAreaField" class="mb-3" style="display: none;">
                  <label for="new_area" class="form-label">Escribe el nombre de la nueva área</label>
                  <input type="text" class="form-control @error('new_area') is-invalid @enderror" id="new_area" name="new_area" value="{{ old('new_area') }}">
                  @error('new_area')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="mt-2">
                    <a href="mailto:admin@sustemia.com?subject=Solicitud de Nueva Área&body=Solicitud para crear el área: {{ old('new_area') }}" class="btn btn-primary btn-sm">Enviar solicitud al administrador</a>
                  </div>
                </div>

                <!-- Botón de Crear Tarea -->
                <div class="d-flex justify-content-start mt-4">
                  <button type="submit" class="btn btn-success btn-sm">Crear tarea</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


    <!-- Modal de Confirmación de Eliminación de Tarea -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteTaskModalLabel">Confirmación de Eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p class="text-start">¿Estás seguro de que deseas eliminar esta tarea?</p>
            <p class="text-start">Esta acción no se puede deshacer.</p>
          </div>
          <div class="modal-footer">
            <form id="deleteTaskForm" method="POST" action="" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Filtros para Tareas -->
    <div class="mb-4 p-4 border rounded shadow-lg">
        <h2 class="mb-3 text-start">
            <i class="bi bi-filter-circle-fill"></i>
            Filtrar tareas</h2>
        <form method="GET" action="{{ route('dashboards.index') }}" aria-label="Filtrar tareas">
            <div class="row g-3">
                <!-- Filtro de Búsqueda -->
                <div class="col-12">
                    <label for="search" class="form-label">Buscar tareas</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Buscar por título o descripción" oninput="this.form.submit()">
                </div>

                <!-- Filtro de Estado -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="filterStatus" class="form-label">Estado</label>
                    <select id="filterStatus" name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Seleccionar estado</option>
                        <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Completada" {{ request('status') == 'Completada' ? 'selected' : '' }}>Completada</option>
                    </select>
                </div>

                <!-- Filtro de Área -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="filterArea" class="form-label">Área</label>
                    <select id="filterArea" name="area" class="form-select" onchange="this.form.submit()">
                        <option value="">Seleccionar área</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro de Mes -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="month" class="form-label">Mes</label>
                    <select id="month" name="month" class="form-select" onchange="this.form.submit()">
                        <option value="">Seleccionar mes</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Filtro de Año -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="year" class="form-label">Año</label>
                    <select id="year" name="year" class="form-select" onchange="this.form.submit()">
                        <option value="">Seleccionar año</option>
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="mb-3">
        <div class="alert alert-white shadow-lg rounded p-3 mb-5 bg-body d-flex align-items-center">
            <div class="flex-wrap w-100 justify-content-between">
                <!-- Tarea Vencida -->
                <div class="d-flex align-items-center me-2 me-md-3">
                    <i class="bi bi-calendar-x-fill text-danger fs-5 mx-2" title="Tarea vencida"></i>
                    <span>Tarea Vencida</span>
                <!-- Tarea Pendiente -->
                    <i class="bi bi-hourglass-split text-warning fs-5 mx-2" title="Tarea pendiente"></i>
                    <span>Tarea Pendiente</span>
                <!-- Tarea Completada -->
                    <i class="bi bi-check-circle-fill text-success fs-5 mx-2" title="Tarea completada"></i>
                    <span>Tarea Completada</span>
                <!-- Botón para abrir el modal de crear tarea -->
                @can('create_tasks')
                <div class="d-flex align-items-start ms-auto px-2">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTaskModal" aria-label="Crear Nueva Tarea">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <!-- Tareas -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 g-4">
        @foreach ($tasks as $task)
        <div class="col">
            <div class="card h-100
                {{ $task->due_date < now() ? 'shadow-lg text-black' :
                ($task->status == 'Completada' ? 'shadow-success' : ($task->status == 'Pendiente' ? 'shadow-warning text-dark' : 'shadow-danger text-white')) }}">

                <!-- Header con alineación -->
                <div class="card-body d-flex flex-column rounded">
                    <!-- Título y Dropdown alineados correctamente -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Estado de la tarea -->
                        <div class="pe-2 d-flex align-items-center gap-2">
                            @if ($task->completed_at && $task->completed_at < $task->due_date) <!-- Comprobación de fecha de cierre mayor que la de vencimiento -->
                                <i class="bi bi-check-circle-fill text-success" title="Tarea Completada"></i>
                            @elseif ($task->due_date < now() && $task->status == 'Completada con retraso') <!-- Tarea completada con retraso -->
                                <i class="bi bi-calendar-x-fill text-danger" title="Tarea Vencida"></i>
                                <i class="bi bi-check-circle-fill text-success" title="Tarea Completada"></i>
                            @elseif ($task->due_date < now()) <!-- Tarea vencida sin completar -->
                                <i class="bi bi-calendar-x-fill text-danger" title="Tarea Vencida"></i>
                            @elseif ($task->status == 'Pendiente') <!-- Tarea pendiente -->
                                <i class="bi bi-hourglass-split text-warning" title="Tarea Pendiente"></i>
                            @elseif ($task->status == 'Completada') <!-- Tarea completada dentro del plazo -->
                                <i class="bi bi-check-circle-fill text-success" title="Tarea Completada"></i>
                            @endif
                        </div>

                        <!-- Título con `flex-grow-1` -->
                        <h3 class="card-title mb-0 flex-grow-1 fs-5 text-truncate text-start">
                            {{ $task->title }}
                        </h3>

                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-link p-0 dropdown-toggle" type="button" id="taskOptionsDropdown{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="taskOptionsDropdown{{ $task->id }}">
                                @can('edit_tasks')
                                <li>
                                    <a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                </li>
                                @endcan
                                @can('view_tasks')
                                <li>
                                    <a class="dropdown-item" href="{{ route('tasks.show', $task->id) }}">
                                        <i class="bi bi-eye"></i> Ver Tarea
                                    </a>
                                </li>
                                @endcan
                                @can('delete_tasks')
                                <li>
                                    <!-- Botón para eliminar tarea -->
                                    <a class="dropdown-item" href="#" onclick="setDeleteTaskUrl('{{ route('tasks.destroy', $task->id) }}')" data-bs-toggle="modal" data-bs-target="#deleteTaskModal">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    <!-- Descripción y detalles -->
                    <p class="card-text text-start">{{ Str::limit($task->description, 100) }}</p>
                    <!-- Mostrar el nombre del creador si es admin -->
                    @if(auth()->user()->hasRole('admin'))
                        <p class="card-text text-start"><strong>Creador:</strong> {{ $task->user->name }}</p>
                    @endif
                    <p class="card-text text-start"><strong>Área:</strong> {{ $task->area->name ?? 'Sin área' }}</p>
                    <p class="card-text text-start"><strong>Fecha de vencimiento:</strong> {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</p>
                    <p class="card-text text-start"><strong>Fecha de cierre:</strong> {{ $task->completed_at ? $task->completed_at->format('d/m/Y') : '' }}</p>

                    <!-- Estado Badge -->
                    <p class="card-text text-start">
                        <strong>Estado:</strong>
                        <span class="badge
                            @if ($task->status == 'Pendiente' && $task->due_date < now()) bg-danger
                            @elseif ($task->status == 'Pendiente') bg-warning text-dark
                            @elseif ($task->status == 'Completada') bg-success
                            @elseif ($task->status == 'Completada con retraso') bg-success text-white
                            @endif">
                            @if ($task->status == 'Completada con retraso')
                                <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                            @endif
                            {{ $task->status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

<script>
  // Mantener el modal abierto si hay errores de validación
  @if ($errors->any())
    // Espera a que el modal de Bootstrap esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
      var myModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
      myModal.show();  // Muestra el modal si hay errores
    });
  @endif

  // Establecer la URL del formulario de eliminación
  function setDeleteTaskUrl(url) {
    document.getElementById('deleteTaskForm').action = url;
  }

          // Función para mostrar/ocultar el campo de "Solicitar Nueva Área"
          function toggleNewAreaField() {
            const newAreaField = document.getElementById('newAreaField');
            if (newAreaField.style.display === "none") {
                newAreaField.style.display = "block";  // Muestra el campo para solicitar nueva área
            } else {
                newAreaField.style.display = "none";  // Oculta el campo si ya está visible
            }
        }

</script>

@endsection
