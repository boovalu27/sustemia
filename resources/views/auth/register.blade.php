@extends('layouts.main')

@section('title', 'Registrarse')

@section('content')

<section style="background-color: #fdfdfd;">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-6 col-lg-5 mb-4 mb-md-0">
        <img src="{{ asset('css/imgs/resource/register_ecosistema.jpg') }}" alt="Formulario de registro"
          class="img-fluid rounded-3 shadow-sm">
      </div>
      <div class="col-md-6 col-lg-7">
        <div class="card shadow-lg rounded-3">
          <div class="card-body p-4 p-lg-5 text-dark">

            <h1 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color: #107033;">Bienvenido :)</h1>
            <h2 class="my-3" style="letter-spacing: 1px; color: #107033;">Completa el formulario para registrarte.</h2>

            @if($errors->any())
              <div class="alert alert-danger">
                <p>Hay errores de validación en los datos del formulario. Por favor, revisa y corrige los errores indicados.</p>
              </div>
            @endif

            <form action="{{ route('auth.store') }}" method="post" enctype="multipart/form-data" aria-label="Formulario de Registro">
              @csrf

              <div class="form-outline mb-4">
                <label class="form-label" for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required aria-required="true">
                @error('name')
                  <p class="invalid-feedback">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required aria-required="true">
                @error('email')
                  <p class="invalid-feedback">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="password">Contraseña <span class="text-danger">(mínimo 8 caracteres)</span></label>
                <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required aria-required="true">
                @error('password')
                  <p class="invalid-feedback">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required aria-required="true">
              </div>

              <button type="submit" class="btn btn-success btn-lg w-100">Registrarse</button>

            </form>

            <p class="mt-4 pt-2" style="color: #107033;">¿Ya tienes una cuenta? <a href="{{ route('auth.login') }}" style="color: #107033;">Inicia sesión aquí</a></p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
