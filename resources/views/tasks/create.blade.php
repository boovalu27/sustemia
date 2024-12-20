@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container mt-2">
    <h1 class="mb-4 text-start text-success">Crear nueva tarea</h1>

    <!-- Formulario para crear una nueva tarea -->
    <form action="{{ route('tasks.store') }}" method="POST" class="bg-light p-4 rounded shadow">
      @csrf

      <!-- Campo de título de la tarea -->
      <div class="mb-3">
        <label for="title" class="form-label">Título</label>
        <input type="text" name="title" id="title" class="form-control"
          value="{{ old('title') }}" required>

        <!-- Mostrar mensaje de error si el campo 'title' no es válido -->
        @error('title')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Campo de descripción de la tarea -->
      <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>

        <!-- Mostrar mensaje de error si el campo 'description' no es válido -->
        @error('description')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Campo de área asociada a la tarea -->
      <div class="mb-3">
        <label for="area_id" class="form-label">Área</label>
        <select name="area_id" id="area_id" class="form-select" required>
          <option value="0" {{ old('area_id') == '0' ? 'selected' : '' }}>Selecciona un área</option>

          <!-- Mostrar las áreas disponibles -->
          @foreach ($areas as $area)
            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
              {{ $area->name }}
            </option>
          @endforeach
        </select>

        <!-- Mostrar mensaje de error si el campo 'area_id' no es válido -->
        @error('area_id')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Campo de fecha de vencimiento -->
      <div class="mb-3">
        <label for="due_date" class="form-label">Fecha de Vencimiento</label>
        <input type="date" name="due_date" id="due_date" class="form-control"
          value="{{ old('due_date') }}" required>

        <!-- Mostrar mensaje de error si el campo 'due_date' no es válido -->
        @error('due_date')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Botones de acción -->
      <div class="d-flex justify-content-between border-top py-2">
        <!-- Botón para enviar el formulario y crear la tarea -->
        <button type="submit" class="btn btn-success">Crear tarea</button>

        <!-- Botón para cancelar y regresar a la lista de tareas -->
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
          <i class="bi-arrow-return-left"></i>
        </a>
      </div>
    </form>
  </div>
@endsection
