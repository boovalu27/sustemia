@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container mt-5">
    <h1 class="mb-4 text-start text-success">Detalles de la tarea</h1>

    <div class="p-4 rounded shadow">
      <div class="border-bottom text-start">
        <h3 class="py-2">{{ $task->title }}</h3>
      </div>


        <!-- Descripción de la tarea -->
         <p class="py-2"> <strong>Descripción:</strong> {{ $task->description }}</p>

        <!-- Área de la tarea -->
         <p> <strong>Área:</strong> {{ $task->area->name ?? 'N/A' }}</p>

        <!-- Fecha de vencimiento -->
        <p> <strong>Fecha de vencimiento:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</p>

        <!-- Fecha de cierre -->
        <p> <strong>Fecha de cierre:</strong> {{ \Carbon\Carbon::parse($task->completed_at)->format('d/m/Y') }}</p>

        <!-- Estado de la tarea -->
        <p>
            <strong>Estado:</strong>

            <span class="badge
                        @if ($task->status == 'Pendiente' && $task->due_date < now()) bg-success
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

      <div class="d-flex justify-content-between border-top py-2">
        <div>
          <!-- Mostrar el botón de Editar solo para Admin, Editor o permisos de edición -->
          @can('edit_tasks')
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning me-2">
                <i class="bi-pencil-fill"></i>
            </a>
          @endcan

        </div>

        <!-- Botón para volver a la lista de tareas o al dashboard -->
        <a href="{{ route('dashboards.index') }}" class="btn btn-secondary">
            <i class="bi-arrow-return-left"></i>
        </a>
      </div>
    </div>
  </div>
@endsection
