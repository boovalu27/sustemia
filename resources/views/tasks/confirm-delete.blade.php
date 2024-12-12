@extends(auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Confirmar Eliminación</h1>

    <p>¿Estás seguro de que deseas eliminar la tarea "<strong>{{ $task->title }}</strong>"?</p>
    <p><em>Esta acción no se puede deshacer.</em></p>

    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="mt-4 d-flex" style="gap: 10px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Eliminar Tarea
        </button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Cancelar
        </a>
    </form>
</div>
@endsection
