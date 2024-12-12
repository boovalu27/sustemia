@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1>Detalles del Área</h1>

    <div class="card border-primary mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $area->name }}</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">ID:</dt>
                <dd class="col-sm-8">{{ $area->id }}</dd>

                <dt class="col-sm-4">Nombre:</dt>
                <dd class="col-sm-8">{{ $area->name }}</dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $area->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $area->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <h5 class="mt-4">Tareas Asociadas</h5>
            @if ($area->tasks->isEmpty())
                <p>No hay tareas asociadas a esta área.</p>
            @else
                <ul class="list-group">
                    @foreach ($area->tasks as $task)
                        <li class="list-group-item">
                            {{ $task->title }} <small>(ID: {{ $task->id }})</small>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-4">
                <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-warning">Editar Área</a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Eliminar Área</button>
                <a href="{{ route('areas.index') }}" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar el área <strong>{{ $area->name }}</strong>? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST" id="deleteForm" role="form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
