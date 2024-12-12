@extends('layouts.main')

@section('title', 'Iniciar Sesión')

@section('content')

<section class="py-5">
  <div class="container d-flex justify-content-center align-items-center h-100">
    <div class="row justify-content-center w-100">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Tarjeta de login centrada -->
        <div class="card shadow-lg rounded-3 border-0">
          <div class="card-body p-4 p-lg-5 text-start">

            <!-- Sección Logo y texto -->
            <div class="row align-items-center mb-4">
              <!-- Columna del logo -->
              <div class="col-12 col-md-4 text-left text-md-start">
                <img src="{{ url('css/imgs/resource/icono.png') }}" alt="Logo de Sustemia" class="img-fluid" style="max-width: 150px;">
              </div>

              <!-- Columna del texto -->
              <div class="col-12 col-md-8 text-left text-md-start">
                <h1 class="fw-normal mb-3" style="color: var(--color-success);">¡Hola de nuevo!</h1>
                <p style="color: var(--color-success);">Te damos la bienvenida a nuestra plataforma.</p>
                <p style="color: var(--color-success);">Ingresá tus datos para continuar.</p>
                <i class="bi bi-helmet-safety" style="font-size: 3rem; color: var(--color-success);"></i>
              </div>
            </div>

            <!-- Formulario de inicio de sesión -->
            <form action="{{ route('auth.login.process') }}" method="post" aria-labelledby="login-form" class="mt-4">
              @csrf

              <!-- Campo de correo electrónico -->
              <div class="form-outline mb-4">
                <label class="form-label" for="email"><i class="bi bi-envelope-fill"></i> Correo Electrónico</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control form-control-lg"
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
                <label class="form-label" for="password"><i class="bi bi-lock-fill"></i> Contraseña</label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control form-control-lg"
                  placeholder="xxxx"
                  required
                  aria-required="true"
                >
                @error('password')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Botón de iniciar sesión -->
              <div class="pt-1 mb-4">
                <button class="btn btn-success btn-block" type="submit">
                  <i class="bi bi-arrow-right-circle"></i> Iniciar Sesión
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
