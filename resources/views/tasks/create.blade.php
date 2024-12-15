@extends(auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')

@section('content')
  <div class="container mt-5">
    <h1 class="mb-4 text-start text-success">Crear nueva tarea</h1>
    <form action="{{ route('tasks.store') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="area_id" class="form-label">Área</label>
            <select name="area_id" id="area_id" class="form-select" required>
                <option value="">Selecciona un área</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            @error('area_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
            @error('due_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Crear tarea</button>
    </form>
  </div>@endsection
