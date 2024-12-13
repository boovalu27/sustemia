@extends('layouts.main')

@section('content')
  <div class="container my-3">
    <h1 class="mb-4 text-start text-success">Panel de control de seguridad e higiene</h1>
    <p class="text-start my-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-start py-2">Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>



    <!-- Modal para Crear Nueva Tarea -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-start" id="createTaskModalLabel">Crear tarea</h5>
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
                <small class="form-text text-muted mt-1">Si no encuentras el área, solicita al administrador que la cree.</small>
              </div>

              <!-- Botón de Crear Tarea -->
              <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Crear tarea</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Filtros para Tareas -->
    <div class="mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-start">Filtrar tareas</h5>
            <form method="GET" action="{{ route('dashboards.index') }}" aria-label="Filtrar tareas">
              <div class="row g-3 mb-3">
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
        </div>
      </div>

    <div class="mb-3">
        <div class="alert alert-white shadow-lg p-3 mb-5 rounded p-3 mb-5 bg-body d-flex align-items-center">
            <div class="d-flex flex-wrap w-100 justify-content-between">
                <!-- Tarea Vencida -->
                <div class="d-flex align-items-center me-2 me-md-3 mb-2">
                    <i class="bi bi-calendar-x text-danger fs-5 me-2" title="Tarea vencida"></i>
                    <span>Tarea Vencida</span>
                </div>

                <!-- Tarea Pendiente -->
                <div class="d-flex align-items-center me-2 me-md-3 mb-2">
                    <i class="bi bi-hourglass-split text-warning fs-5 me-2" title="Tarea pendiente"></i>
                    <span>Tarea Pendiente</span>
                </div>

                <!-- Tarea Completada -->
                <div class="d-flex align-items-center me-2 me-md-3 mb-2">
                    <i class="bi bi-check-circle text-success fs-5 me-2" title="Tarea completada"></i>
                    <span>Tarea Completada</span>
                </div>

<!-- Botón para abrir el modal de crear tarea -->
@can('create_tasks')
<div class="d-flex align-items-center mb-2 ms-auto">
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
            $task->due_date < now() ? 'shadow-lg text-black' :
            ($task->status == 'Completada' ? 'shadow-success' : 'shadow-warning text-dark')
        }}">

        <div class="card-body d-flex flex-column border border-dark rounded">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Menú de Puntitos (Dropdown) -->
                <div class="dropdown px-2">
                    <button class="btn btn-link p-0 dropdown-toggle" type="button" id="taskOptionsDropdown{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="taskOptionsDropdown{{ $task->id }}">
                        @can('edit_task')
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks.show', $task->id) }}">
                                <i class="bi bi-eye"></i> Ver Tarea
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Título de la tarea -->
                <h5 class="card-title mb-0 border-bottom border-black pb-2 text-start">{{ $task->title }}</h5>

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
