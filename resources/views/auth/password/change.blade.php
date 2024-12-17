@extends('layouts.main')

@section('title', 'Cambiar contraseña')

@section('content')

<section class="py-5">
  <div class="container d-flex justify-content-center align-items-center h-100">
    <div class="row justify-content-center w-100">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Tarjeta para cambiar la contraseña -->
        <div class="card shadow-lg rounded-5">
          <div class="card-body p-4 p-lg-5">
            <div class="text-center">
              <h5 class="fs-5 py-2">Cambiar tu contraseña</h5>
            </div>

            <!-- Formulario para ingresar el correo y la nueva contraseña -->
            <form action="{{ route('auth.password.change') }}" method="POST">
                @csrf

                <div class="form-outline mb-4">
                    <label for="email" class="form-label text-muted">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nueva contraseña -->
                <div class="form-outline mb-4">
                    <label for="password" class="form-label text-muted">Nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggle-password" style="cursor: pointer;">
                            <i class="bi bi-eye-slash" id="toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar nueva contraseña -->
                <div class="form-outline mb-4">
                    <label for="password_confirmation" class="form-label text-muted">Confirmar nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggle-confirmation-password" style="cursor: pointer;">
                            <i class="bi bi-eye-slash" id="toggle-confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary rounded-4">Cambiar contraseña</button>
            </form>

            @if(session('status'))
              <div class="alert alert-success mt-3">
                {{ session('status') }}
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
