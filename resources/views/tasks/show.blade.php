@extends(auth()->check() && auth()->user()->role
    ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')
    : 'layouts.main')

@section('content')
  <div class="container mt-4">
    <h1 class="text-center mb-4">Detalles de la Tarea</h1>

    <div class="card card-custom">
      <div class="card-header text-center">
        <h5 class="card-title text-white">{{ $task->title }}</h5>
      </div>

      <div class="card-body">
        <!-- Descripción de la tarea -->
        <div class="mb-3">
          <strong>Descripción:</strong>
          <p>{{ $task->description }}</p>
        </div>

        <!-- Área de la tarea -->
        <div class="mb-3">
          <strong>Área:</strong>
          <p class="text-muted">{{ $task->area->name ?? 'N/A' }}</p>
        </div>

        <!-- Fecha de vencimiento -->
        <div class="mb-3">
          <strong>Fecha de Vencimiento:</strong>
          <p class="text-muted">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</p>
        </div>

        <!-- Estado de la tarea -->
        <div class="mb-3">
          <strong>Estado:</strong>
          <p>
            <span class="badge
              {{ $task->status === 'Completada' ? 'bg-success' :
                ($task->status === 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger') }}">
              {{ $task->status }}
            </span>
          </p>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between">
        <div>
          <!-- Mostrar el botón de Editar solo para Admin y Editor -->
          @if (Auth::user()->role?->name === 'admin' || Auth::user()->role?->name === 'editor' || Auth::user()->can('edit_tasks'))
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning me-2">Editar Tarea</a>
          @endif

          <!-- Mostrar el botón de Eliminar solo para Admin -->
          @if (Auth::user()->role?->name === 'admin')
            @can('delete_tasks')
              <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar Tarea</button>
              </form>
            @endcan
          @endif
        </div>

        <!-- Botón para volver a la lista de tareas o al dashboard -->
        <a href="{{ auth()->user()->role?->name === 'admin' ? route('tasks.index') : route('dashboards.index') }}"
           class="btn btn-secondary">Volver</a>
      </div>
    </div>
  </div>
@endsection
