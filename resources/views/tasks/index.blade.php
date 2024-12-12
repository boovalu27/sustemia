@extends(auth()->check() && auth()->user()->role ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main') : 'layouts.main')

@section('content')
  <div class="container-fluid mt-4">
    <h1 class="mb-4 text-center">Panel de Control de Seguridad e Higiene</h1>
    <p class="text-center m-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-center">Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

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

    <div class="mb-3">
        <div class="alert alert-info d-flex align-items-center">
          <div class="me-3">
            <strong>Nota:</strong>
          </div>
          <div class="d-flex flex-wrap">
            <div class="me-3">
              <span class="badge bg-danger">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Vencida
            </div>
            <div class="me-3">
              <span class="badge bg-warning text-dark">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Pendiente
            </div>
            <div class="me-3">
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
              <td class="d-flex">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-1" aria-label="Editar Tarea">
                  <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm" aria-label="Ver Detalles">
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
