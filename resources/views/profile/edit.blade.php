@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container py-5">
    <!-- Tarjeta de edición de perfil -->
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm rounded-3 border-0">
          <div class="card-body">
            <!-- Título dentro de la tarjeta (Editar perfil de usuario) -->
            <div class="text-center mb-4">
              <h2 class="card-title mb-2">Editar Perfil de {{ Auth::user()->name }}</h2>
            </div>

            <!-- Mensajes de éxito o error -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de edición -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('POST')

                <!-- Campo de nombre -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                </div>

                <!-- Campo de apellido -->
                <div class="mb-3">
                    <label for="surname" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="{{ Auth::user()->surname }}">
                </div>

                <!-- Campo de correo electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>

                <!-- Cambiar contraseña -->
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Ingrese una nueva contraseña">
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirme su nueva contraseña">
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-4">Actualizar Perfil</button>
                    <a href="{{ route('profile.view') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
