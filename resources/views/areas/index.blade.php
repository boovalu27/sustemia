@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-success">Lista de áreas</h1>
    <p class="text-start mb-4">Administra y visualiza las áreas en la plataforma.</p>

    <a href="{{ route('areas.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"> </i> Agregar
    </a>

    <div class="table-responsive border rounded-2 p-3">
        <table class="table table-striped table-hover">
            <thead class="py-2">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($areas as $area)
                    <tr>
                        <td>{{ $area->id }}</td>
                        <td>{{ $area->name }}</td>
                        <td>
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('areas.show', $area->id) }}" class="btn btn-info btn-sm rounded-3" aria-label="Ver detalles del área {{ $area->name }}">
                                    <i class="bi bi-info-circle-fill"></i>
                                </a>
                                <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-warning btn-sm" aria-label="Editar área {{ $area->name }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $area->id }}" aria-label="Eliminar área {{ $area->name }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal de Confirmación de Eliminación -->
                    <div class="modal fade" id="confirmDeleteModal{{ $area->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $area->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel{{ $area->id }}">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar el área <strong>{{ $area->name }}</strong>? Esta acción no se puede deshacer.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('areas.destroy', $area->id) }}" method="POST" id="deleteForm{{ $area->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay áreas disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
