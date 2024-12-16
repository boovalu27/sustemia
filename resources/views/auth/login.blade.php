@extends('layouts.main')

@section('title', 'Iniciar sesión')

@section('content')

<section class="py-5">
  <div class="container d-flex justify-content-center align-items-center h-100">
    <div class="row justify-content-center w-100">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Tarjeta de login centrada -->
        <div class="card shadow-lg rounded-5">
          <div class="card-body p-4 p-lg-5">
            <!-- Sección Logo y texto -->
              <div class="card-header text-center">
                <img src="{{ asset('css/imgs/resource/icono.png') }}" alt="Logo de Sustemia" class="img-fluid" style="max-width: 65px;">
                <h5 class="fs-5 py-2">Ingresá tus datos para continuar</h5>
              </div>

            <!-- Formulario de inicio de sesión -->
            <form action="{{ route('auth.login.process') }}" method="post" aria-labelledby="login-form" class="mt-4">
              @csrf

              <!-- Campo de correo electrónico -->
              <div class="form-outline mb-4">
                <label class="form-label text-muted" for="email"> correo electrónico</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  placeholder="ejemplo@email.com"
                  value="{{ old('email') }}"
                  required
                  aria-required="true"
                >
                @error('email')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Campo de contraseña -->
              <div class="form-outline mb-4">
                <label class="form-label text-muted" for="password"> contraseña</label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control"
                  placeholder="xxxxxxxxxx"
                  required
                  aria-required="true"
                >
                @error('password')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <!-- Enlace para recuperar contraseña -->
              <div class="text-start my-3">
                <a href="{{ route('auth.password.change.form') }}" class="text-muted">¿Olvidaste tu contraseña?</a>
            </div>
              <!-- Botón de iniciar sesión -->
              <div class="pt-1">
                <button class="btn btn-secondary rounded-4" type="submit">
                  <i class="bi bi-arrow-right-circle"></i> Ingresar
                </button>
              </div>



            </form>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection
