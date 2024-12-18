@extends('layouts.admin')

@section('content')
  <div class="container mt-5">
    <h1 class="mb-4 text-start text-success">Detalles del Área</h1>

    <div class="p-4 rounded shadow">
      <div class="border-bottom text-start">
        <h2 class="py-2">{{ $area->name }}</h2>
      </div>

      <!-- Tareas asociadas al Área -->
      <p> <strong>Tareas asociadas:</strong></p>
      @if ($area->tasks->isEmpty())
        <p>No hay tareas asociadas a esta área.</p>
      @else
        <ul>
          @foreach ($area->tasks as $task)
            <li>{{ $task->title }} <small>(ID: {{ $task->id }})</small></li>
          @endforeach
        </ul>
      @endif

      <div class="d-flex justify-content-between border-top py-2">
        <div>
          <!-- Mostrar el botón de Editar solo para Admin, Editor o permisos de edición -->
          @can('edit_areas')
            <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-warning me-2">
                <i class="bi-pencil-fill"></i>
            </a>
          @endcan
        </div>

        <!-- Botón para volver a la lista de áreas -->
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">
            <i class="bi-arrow-return-left"></i>
        </a>
      </div>
    </div>
  </div>
@endsection
