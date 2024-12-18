@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="text-start text-success mb-4">Lista de usuarios</h1>
    <p class="text-start mb-4">Administra y visualiza los usuarios registrados en la plataforma.</p>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-success mb-3" aria-label="Agregar Nuevo Usuario">
            <i class="bi bi-person-plus-fill"></i> Agregar
        </a>
    </div>

    @if ($users->isEmpty())
        <div class="alert alert-warning" role="alert">No hay usuarios registrados.</div>
    @else
        <div class="table-responsive border rounded-2 p-3">
            <table class="table table-striped table-hover">
                <thead class="py-2">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') ?: 'Sin rol' }}</td>

                            <!-- Mostrar permisos del usuario -->
                            <td>
                                @if($user->getAllPermissions()->isNotEmpty())
                                    <ul>
                                        @foreach($user->getAllPermissions() as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Sin permisos asignados</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-start gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm rounded-3" aria-label="Editar Usuario">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <button type="button" class="btn btn-danger btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" aria-label="Eliminar Usuario">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>

                                    <!-- Modal de Confirmación de Eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar al usuario <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <!-- Formulario de Eliminación -->
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón Ver Detalles -->
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm rounded-3" aria-label="Ver Detalles de Usuario">
                                        <i class="bi bi-info-circle-fill"></i>
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
