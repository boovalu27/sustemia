@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="mb-4 text-start text-success">Crear nuevo usuario</h1>

    <form action="{{ route('users.store') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="name" class="form-label" data-bs-toggle="tooltip" title="Ingresa el nombre completo del usuario.">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Apellido -->
        <div class="mb-3">
            <label for="surname" class="form-label" data-bs-toggle="tooltip" title="Ingresa el apellido del usuario.">Apellido</label>
            <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}">
            @error('surname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label" data-bs-toggle="tooltip" title="Ingresa un correo electrónico válido.">Correo Electrónico</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label" data-bs-toggle="tooltip" title="Asegúrate de usar una contraseña segura.">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Roles -->
        <div class="mb-3">
            <label for="roles" class="form-label" data-bs-toggle="tooltip" title="Selecciona un rol para el usuario.">Rol</label>
            <select name="roles" id="roles" class="form-select @error('roles') is-invalid @enderror" required>
                <option value="0" {{ old('roles') == '0' ? 'selected' : '' }}>Selecciona un rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('roles') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Permisos -->
        <div class="mb-3">
            <label class="form-label" data-bs-toggle="tooltip" title="Si no seleccionas permisos, se aplicarán los del rol seleccionado.">Permisos Adicionales</label>
            <div class="d-flex flex-wrap">
                @foreach ($permissions as $permission)
                    <div class="form-check me-3">
                        <input type="checkbox" class="form-check-input" id="permission_{{ $permission->name }}" name="permissions[]" value="{{ $permission->name }}"
                               {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission_{{ $permission->name }}" data-bs-toggle="tooltip" title="Este permiso permite: {{ $permission->description }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('permissions')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between border-top py-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Crear usuario
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary"> <i class="bi-arrow-return-left"></i> </a>
        </div>

    </form>
</div>

@endsection
