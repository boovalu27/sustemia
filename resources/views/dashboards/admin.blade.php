@extends('layouts.admin')

@section('content')
<div class="container my-">
    <h1 class="mb-4 text-center text-primary">Panel de Administración</h1>

    <!-- Tabla de Usuarios -->
    <h2 class="mb-4 text-success">Usuarios</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Rol</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->first() ?: 'Sin rol' }}</td>

                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" aria-label="Editar usuario {{ $user->name }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Áreas -->
    <h2 class="mb-4 text-success">Áreas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nombre del área</th>
                    <th scope="col">Número de tareas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->tasks->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
