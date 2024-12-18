@extends(auth()->check() && auth()->user()->hasRole('admin')
    ? 'layouts.admin'
    : 'layouts.main')

@section('content')
  <div class="container py-5">
    <!-- Tarjeta de edición de perfil -->
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm rounded-3 border-0 text-start">
          <div class="card-body">
            <!-- Título dentro de la tarjeta (Editar perfil de usuario) -->
            <div class="mb-4">
              <h1 class="mb-4 text-start text-success">Editar perfil de {{ Auth::user()->name }}</h1>
            </div>

            <!-- Formulario de edición -->
            <form action="{{ route('profile.update') }}" method="POST" class="border-bottom text-start mb-4">
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
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>

                <!-- Cambiar contraseña -->
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Ingrese una nueva contraseña">
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirme su nueva contraseña">
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between border-top py-2">
                    <button type="submit" class="btn btn-warning"><i class="bi-pencil-fill"></i> Actualizar</button>
                    <a href="{{ route('profile.view') }}" class="btn btn-secondary"><i class="bi-arrow-return-left"></i></a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
