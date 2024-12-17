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

      <div class="card">
        <div class="card-header">
            <h5>Change Password</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Old Password</label>
                         <input type="password" class="form-control">
                        </div><div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>New password must contain:</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="ti ti-circle-check text-success f-16 me-2"></i> At least 8 characters</li>
                                <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 lower letter (a-z)</li>
                                <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 uppercase letter(A-Z)</li>
                                <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 number (0-9)</li>
                                <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1 special characters</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end btn-page">
                    <div class="btn btn-outline-secondary">Cancel</div>
                    <div class="btn btn-primary">Update Profile</div>
                </div>
            </div>
    </div>
  </div>
@endsection
