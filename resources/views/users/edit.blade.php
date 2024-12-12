@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuario</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Introduce el nombre completo del usuario.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Introduce un email válido para el usuario.</div>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Rol</label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="" disabled>Selecciona un rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">Selecciona el rol del usuario.</div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
