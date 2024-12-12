@extends('layouts.main')

@section('content')
  <div class="container my-3">
    <h1 class="mb-4 text-left">Panel de Control de Seguridad e Higiene</h1>
    <p class="text-left mb-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-left p-2">Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

    <!-- Botón para abrir el modal de crear tarea -->
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#createTaskModal" aria-label="Crear Nueva Tarea">
      <i class="bi bi-plus-circle"></i> Crear tarea
    </button>

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

    <!-- Filtros para Tareas -->
    <div class="mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Filtrar Tareas</h5>
          <form method="GET" action="{{ route('dashboards.editor') }}" aria-label="Filtrar tareas">
            <div class="row g-3 mb-3">
              <div class="col-md-12">
                <label for="search" class="form-label">Buscar Tareas</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Buscar por título o descripción" oninput="this.form.submit()">
              </div>
              <div class="col-md-3">
                <label for="filterArea" class="form-label">Área</label>
                <select id="filterArea" name="area" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Área</option>
                  @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label for="month" class="form-label">Mes</label>
                <select id="month" name="month" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Mes</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-3">
                <label for="year" class="form-label">Año</label>
                <select id="year" name="year" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Año</option>
                  @for ($year = now()->year; $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-3">
                <label for="filterStatus" class="form-label">Estado</label>
                <select id="filterStatus" name="status" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Estado</option>
                  <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                  <option value="Completada" {{ request('status') == 'Completada' ? 'selected' : '' }}>Completada</option>
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mb-3">
        <div class="alert alert-info d-flex align-items-center">
            <div class="d-flex flex-wrap">
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-danger">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Vencida
                </div>
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-warning text-dark">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Pendiente
                </div>
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-success">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Completada
                </div>
            </div>
        </div>
    </div>


    <!-- Tabla de Tareas -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Fecha de Creación</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Área</th>
            <th>Fecha de Vencimiento</th>
            <th>Fecha de Cierre</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tasks as $task)
            <tr class="{{ $task->due_date < now() ? 'table-danger' : ($task->status == 'Completada' ? 'table-success' : 'table-warning') }}">
              <td>{{ $task->created_at ? $task->created_at->format('d/m/Y') : 'Sin fecha' }}</td>
              <td>{{ $task->title }}</td>
              <td>{{ Str::limit($task->description, 50) }}</td>
              <td>{{ $task->area->name ?? 'Sin área' }}</td>
              <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</td>
              <td>{{ $task->completed_at ? $task->completed_at->format('d/m/Y') : '' }}</td>
              <td>
                <span class="badge {{ $task->status == 'Completada' ? 'bg-success' : ($task->status == 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                  {{ $task->status }}
                </span>
              </td>
              <td class="align-top">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-lg w-100 mb-1" aria-label="Editar Tarea">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-lg w-100 mt-1" aria-label="Ver Detalles">
                    <i class="bi bi-eye"></i> Detalles
                  </a>

              </td>

            </tr>
          @endforeach
        </tbody>
      </table>
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
