@extends(auth()->check() && auth()->user()->role
    ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')
    : 'layouts.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-start text-success px-4">Detalles del Usuario: {{ $user->name }}</h1>

        <!-- Mostramos los errores de validación (si existiesen) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Información del Usuario -->
        <div class="bg-light p-4 rounded shadow">
            <ul class="list-group">
                <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Rol:</strong> {{ $user->roles->pluck('name')->implode(', ') }}</li> <!-- Muestra los roles del usuario -->

                <!-- Mostrar permisos del usuario -->
                <li class="list-group-item">
                    <strong>Permisos:</strong>
                    @if($user->permissions->isEmpty())
                        <span>No tiene permisos asignados.</span>
                    @else
                        <ul>
                            @foreach($user->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-start border-top pt-3">
            <!-- Botón para regresar a la lista de usuarios -->
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi-arrow-return-left"></i> Volver a la lista de usuarios
            </a>

            <!-- Formulario para eliminar usuario, solo visible para admin -->
            @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'admin')
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-start pt-3">
                        <button type="submit" class="btn btn-danger mx-2">
                            <i class="bi bi-trash"></i> Eliminar Usuario
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
