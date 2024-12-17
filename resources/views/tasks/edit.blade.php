@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-start text-success px-4">Editar tarea</h1>

    <div class="bg-light p-4 rounded shadow">
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

        <!-- Formulario de actualización de tarea -->
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Determinamos si la tarea está completada o tiene retraso --}}
            @php
                $isCompleted = in_array($task->status, ['Completada', 'Completada con retraso']);
            @endphp

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required {{ $isCompleted ? 'disabled' : '' }}>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" {{ $isCompleted ? 'disabled' : '' }}>{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="area_id" class="form-label">Área</label>
                <select name="area_id" id="area_id" class="form-select" required {{ $isCompleted ? 'disabled' : '' }}>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ $area->id == $task->area_id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}" required {{ $isCompleted ? 'disabled' : '' }}>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select name="status" id="status" class="form-select" required {{ $isCompleted ? 'disabled' : '' }}>
                    <option value="Pendiente" {{ old('status', $task->status) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Completada" {{ old('status', $task->status) == 'Completada' ? 'selected' : '' }}>Completada</option>
                </select>
            </div>

            <!-- Botones de acción (Actualizar y Cancelar) -->
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between border-top pt-3">
                <!-- Botón para actualizar -->
                <button type="submit" class="btn btn-warning btn-sm mb-2 mb-md-0" {{ $isCompleted ? 'disabled' : '' }}>
                    <i class="bi-pencil-fill"></i> Actualizar tarea
                </button>

                <!-- Botón para cancelar -->
                <a href="{{ route('dashboards.index') }}" class="btn btn-secondary btn-sm mb-2 mb-md-0">
                    <i class="bi-arrow-return-left"></i>
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
