@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="text-start text-success mb-4">Lista de usuarios</h1>
    <p class="lead text-start mb-4">Administra y visualiza los usuarios registrados en la plataforma.</p>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-success" aria-label="Agregar Nuevo Usuario">
            <i class="bi bi-person-plus-fill"></i> Agregar usuario
        </a>
    </div>

    @if ($users->isEmpty())
        <div class="alert alert-warning" role="alert">No hay usuarios registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') ?: 'Sin rol' }}</td>
                            <td>
                                <div class="d-flex justify-content-start gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" aria-label="Editar Usuario">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" aria-label="Eliminar Usuario">
                                            <i class="bi bi-trash-fill"></i> Eliminar
                                        </button>
                                    </form>
                                    <!-- Botón Ver Detalles -->
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" aria-label="Ver Detalles de Usuario">
                                        <i class="bi bi-info-circle-fill"></i> Detalles
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
