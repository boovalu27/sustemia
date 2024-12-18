@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4 text-start text-success">Crear Nueva Área</h1>
    <form action="{{ route('areas.store') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Área</label>
            <input type="text" name="name" id="name" class="form-control" required aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Introduce el nombre de la nueva área.</div>
        </div>
      <!-- Botones de acción -->
        <div class="d-flex justify-content-between border-top py-2">
        <button type="submit" class="btn btn-success">Crear área</button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary"> <i class="bi-arrow-return-left"></i> </a>
        </div>
    </form>
</div>
@endsection
