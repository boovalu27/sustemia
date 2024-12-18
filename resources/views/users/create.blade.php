@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="mb-4 text-start text-success">Crear nuevo usuario</h1>

    <form action="{{ route('users.store') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Apellido -->
        <div class="mb-3">
            <label for="surname" class="form-label">Apellido</label>
            <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}">
            @error('surname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Roles -->
        <div class="mb-3">
            <label for="roles" class="form-label">Rol</label>
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
            <label for="permissions" class="form-label">Permisos Adicionales</label>
            <select name="permissions[]" id="permissions" class="form-select @error('permissions') is-invalid @enderror" multiple>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ in_array($permission->name, old('permissions', [])) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
            @error('permissions')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>




                  <!-- Botones de acción -->
        <div class="d-flex justify-content-between border-top py-2">
            <!-- Botón para guardar -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Crear usuario
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary"> <i class="bi-arrow-return-left"></i> </a>
            </div>

    </form>
</div>

@endsection
