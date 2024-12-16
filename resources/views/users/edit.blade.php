@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-start text-success">Editar Usuario</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Roles -->
        <div class="mb-3">
            <label for="roles" class="form-label">Roles</label>
            <select name="roles[]" id="roles" class="form-select" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Permisos -->
        <div class="mb-3">
            <label for="permissions" class="form-label">Permisos</label>
            <select name="permissions[]" id="permissions" class="form-select" multiple>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->name }}"
                        {{ in_array($permission->name, old('permissions', $userPermissions)) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
