@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="text-start text-success mb-4">Crear Nuevo Usuario</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <!-- Nombre y Apellido -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="surname" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}">
        </div>

        <!-- Email y Contraseña -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Roles -->
        <div class="mb-3">
            <label for="roles" class="form-label">Rol</label>
            <select name="roles[]" id="roles" class="form-select" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Permisos -->
        <div class="mb-3">
            <label for="permissions" class="form-label">Permisos Adicionales</label>
            <select name="permissions[]" id="permissions" class="form-select" multiple>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ in_array($permission->name, old('permissions', [])) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botón para guardar -->
        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Crear Usuario
            </button>
        </div>
    </form>
</div>
@endsection
