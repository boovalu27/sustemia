@extends('layouts.main')

@section('title', 'Restablecer contraseña')

@section('content')

<section class="py-5">
  <div class="container d-flex justify-content-center align-items-center h-100">
    <div class="row justify-content-center w-100">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Tarjeta de restablecimiento de contraseña -->
        <div class="card shadow-lg rounded-5">
          <div class="card-body p-4 p-lg-5">
            <!-- Sección Logo y texto -->
            <div class="card-header text-center">
              <img src="{{ asset('css/imgs/resource/icono.png') }}" alt="Logo de Sustemia" class="img-fluid" style="max-width: 65px;">
              <h5 class="fs-5 py-2">Restablece tu contraseña</h5>
            </div>

            <!-- Formulario de restablecimiento de contraseña -->
            <form action="{{ route('auth.reset.change') }}" method="post" aria-labelledby="reset-password-form" class="mt-4">
              @csrf

              <!-- Campo de correo electrónico -->
              <div class="form-outline mb-4">
                <label class="form-label text-muted" for="email">Correo electrónico</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  placeholder="Escribe el correo electrónico"
                  value="{{ old('email') }}"
                  required
                  aria-required="true"
                >
                @error('email')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

<!-- Campo de nueva contraseña -->
<div class="form-outline mb-4">
    <label class="form-label text-muted" for="password-reset">Nueva contraseña</label>
    <div class="input-group">
      <input
        type="password"
        id="password-reset"
        name="password"
        class="form-control"
        placeholder="Escribe la nueva contraseña"
        required
        aria-required="true"
      >
      <button type="button" class="btn btn-outline-secondary" id="toggle-password-reset" style="cursor: pointer;">
        <i class="bi bi-eye-slash" id="toggle-icon-reset"></i>
      </button>
    </div>
    @error('password')
      <div class="text-danger">{{ $message }}</div>
    @enderror
  </div>

  <!-- Confirmación de nueva contraseña -->
  <div class="form-outline mb-4">
    <label class="form-label text-muted" for="password_confirmation">Confirmar nueva contraseña</label>
    <div class="input-group">
      <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        class="form-control"
        placeholder="Repite la contraseña"
        required
        aria-required="true"
      >
      <button type="button" class="btn btn-outline-secondary" id="toggle-confirm-password-reset" style="cursor: pointer;">
        <i class="bi bi-eye-slash" id="toggle-confirm-icon-reset"></i>
      </button>
    </div>
    @error('password_confirmation')
      <div class="text-danger">{{ $message }}</div>
    @enderror
  </div>


              <!-- Botón de restablecer contraseña -->
              <div class="pt-1">
                <button class="btn btn-secondary rounded-4" type="submit">
                  <i class="bi bi-arrow-right-circle"></i> Restablecer contraseña
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
