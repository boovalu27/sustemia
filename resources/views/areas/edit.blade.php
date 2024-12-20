@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-start text-success px-4">Editar área</h1>

    <div class="bg-light p-4 rounded shadow">
        <!-- Formulario de actualización de área -->
        <form action="{{ route('areas.update', $area->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campo Nombre del Área -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del área</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $area->name) }}" required aria-describedby="nameHelp">
                <div id="nameHelp" class="form-text">Actualiza el nombre del área.</div>

                <!-- Mostrar el mensaje de error para el campo 'name' -->
                @error('name')
                    <div class="alert alert-danger mt-2 py-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones de acción (Actualizar y Cancelar) -->
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between border-top pt-3">
                <!-- Botón para actualizar -->
                <button type="submit" class="btn btn-warning btn-sm mb-2 mb-md-0">
                    <i class="bi-pencil-fill"></i> Actualizar
                </button>

                <!-- Botón para cancelar -->
                <a href="{{ route('areas.index') }}" class="btn btn-secondary btn-sm mb-2 mb-md-0">
                    <i class="bi-arrow-return-left"></i>
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
