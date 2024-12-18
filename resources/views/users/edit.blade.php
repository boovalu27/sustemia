@extends('layouts.admin')

@section('content')
  <div class="container mt-5">
    <h1 class="text-start text-success px-4">Editar Usuario</h1>

    <div class="bg-light p-4 rounded shadow">
      <!-- Mostramos los errores de validación -->
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Formulario de actualización de usuario -->
      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Correo -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Roles -->
        <div class="mb-3">
          <label for="roles" class="form-label">Roles</label>
          <select name="roles[]" id="roles" class="form-select" required>
            @foreach ($roles as $role)
              <option value="{{ $role->name }}"
                {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'selected' : '' }}>
                {{ $role->name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Permisos (checkboxes) -->
        <div class="mb-3">
          <label for="permissions" class="form-label">Permisos</label><br>
          @foreach ($permissions as $permission)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                {{ in_array($permission->name, old('permissions', $userPermissions)) ? 'checked' : '' }}>
              <label class="form-check-label" for="permissions">{{ $permission->name }}</label>
            </div>
          @endforeach
        </div>

        <!-- Botones -->
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between border-top pt-3">
          <button type="submit" class="btn btn-warning btn-sm mb-2 mb-md-0">
            <i class="bi-pencil-fill"></i> Actualizar Usuario
          </button>
          <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm mb-2 mb-md-0">
            <i class="bi-arrow-return-left"></i> Volver
          </a>
        </div>
      </form>

    </div>
  </div>
@endsection
