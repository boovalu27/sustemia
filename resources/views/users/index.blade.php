@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3" aria-label="Agregar Nuevo Usuario">Agregar Nuevo Usuario</a>

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
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" aria-label="Editar Usuario">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" aria-label="Eliminar Usuario">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" aria-label="Ver Detalles de Usuario">
                                    <i class="bi bi-info-circle-fill"></i> Detalles
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
