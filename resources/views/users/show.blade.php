@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container mt-5">
    <h1 class="mb-4 text-start text-success">Detalles del usuario:</h1>

    <div class="p-4 rounded shadow">

      <!-- Información del Usuario -->
      <div class="border-bottom text-start mb-4">
        <h2 class="py-2">{{ $user->name }}</h2>
      </div>

      <!-- ID del Usuario -->
      <p><strong>ID:</strong> {{ $user->id }}</p>

      <!-- Correo electrónico -->
      <p><strong>Email:</strong> {{ $user->email }}</p>

      <!-- Roles del Usuario -->
      <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->implode(', ') }}</p>

      <!-- Permisos del Usuario -->
      <p><strong>Permisos:</strong></p>
      @if($user->permissions->isEmpty())
        <span>No tiene permisos asignados.</span>
      @else
        <ul>
          @foreach($user->permissions as $permission)
            <li>{{ $permission->name }}</li>
          @endforeach
        </ul>
      @endif

      <!-- Botones de acción -->
      <div class="d-flex justify-content-between border-top py-2">
        <div>
          <!-- Mostrar el botón de Editar solo para Admin o permisos de edición -->
          @can('edit_users')
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning me-2">
              <i class="bi-pencil-fill"></i>
            </a>
          @endcan
        </div>

        <!-- Botón para regresar a la lista de usuarios -->
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
          <i class="bi-arrow-return-left"></i>
        </a>
      </div>
    </div>
  </div>
@endsection
