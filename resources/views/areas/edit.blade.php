@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-success">Editar área</h1>
    <form action="{{ route('areas.update', $area->id) }}" method="POST" class="mb-4 text-start text-success">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del área</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $area->name) }}" required aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Actualiza el nombre del área.</div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar área</button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
