@extends('layouts.admin')

@section('content')
  <div class="container mt-5">
    <!-- Título de la página -->
    <h1 class="text-start text-success px-4">Editar Usuario</h1>

    <div class="bg-light p-4 rounded shadow">
      <!-- Mostrar errores de validación -->
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Formulario para actualizar el usuario -->
      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campo de Nombre -->
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
          @error('name')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo de Apellido -->
        <div class="mb-3">
          <label for="surname" class="form-label">Apellido</label>
          <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname', $user->surname) }}">
          @error('surname')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo de Correo Electrónico -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
          @error('email')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo de Contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
          @error('password')
            <div class="text-danger">{{ $message }}</div>
          @enderror
          <small class="text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
        </div>

        <!-- Campo de Confirmar Contraseña -->
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
          <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
          @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Selección de Rol -->
        <div class="mb-3">
          <label for="roles" class="form-label">Rol</label>
          <select name="roles" id="roles" class="form-select @error('roles') is-invalid @enderror" required>
            <option value="0" {{ old('roles') == '0' ? 'selected' : '' }}>Selecciona un rol</option>
            @foreach ($roles as $role)
              <option value="{{ $role->name }}" {{ old('roles', $user->roles->first()->name) == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
              </option>
            @endforeach
          </select>
          @error('roles')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Selección de Permisos -->
        <div class="mb-3">
          <label for="permissions" class="form-label">Permisos adicionales</label>
          <div>
            @foreach ($permissions as $permission)
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="permissions" name="permissions[]" value="{{ $permission->name }}"
                  {{ in_array($permission->name, old('permissions', $userPermissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="permissions">{{ $permission->name }}</label>
              </div>
            @endforeach
          </div>
          @error('permissions')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Botones de acción -->
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between border-top pt-3">
          <!-- Botón para actualizar el usuario -->
          <button type="submit" class="btn btn-warning btn-sm mb-2 mb-md-0">
            <i class="bi-pencil-fill"></i> Actualizar Usuario
          </button>
          <!-- Botón para volver al listado de usuarios -->
          <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm mb-2 mb-md-0">
            <i class="bi-arrow-return-left"></i> Volver
          </a>
        </div>
      </form>

    </div>
  </div>
@endsection
