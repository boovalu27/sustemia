@extends(auth()->check() && auth()->user()->role
    ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')
    : 'layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Editar tarea</h1>

    <!-- Mostramos los errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="area_id" class="form-label">Área</label>
            <select name="area_id" id="area_id" class="form-select" required>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ $area->id == $task->area_id ? 'selected' : '' }}>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-select" required {{ $task->status === 'Completada' ? 'disabled' : '' }}>
                <option value="Pendiente" {{ old('status', $task->status) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Completada" {{ old('status', $task->status) == 'Completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <!-- Botón para actualizar con ícono -->
            <button type="submit" class="btn btn-warning d-flex align-items-center">
                <i class="bi bi-save me-2"></i> Actualizar
            </button>
            <!-- Botón para cancelar con ícono -->
            <a href="{{ auth()->check() && auth()->user()->role->name === 'editor' ? route('dashboards.index') : route('tasks.index') }}" class="btn btn-secondary d-flex align-items-center">
                <i class="bi bi-x-circle me-2"></i> Cancelar
            </a>

            <!-- Botón Eliminar solo visible para admin -->
            @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'admin')
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-flex align-items-center">
                        <i class="bi bi-trash me-2"></i> Eliminar
                    </button>
                </form>
            @endif
        </div>
    </form>
</div>
@endsection
