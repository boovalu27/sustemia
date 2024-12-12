@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <!-- Tarjeta de Información del Usuario -->
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm rounded-3 border-0">
          <div class="card-body">
            <!-- Título dentro de la tarjeta (Perfil de usuario) -->
            <div class="text-center mb-4">
              <h2 class="card-title mb-2">Perfil de {{ Auth::user()->name }}</h2>
            </div>

            <!-- Avatar e Información de Usuario -->
            <div class="d-flex flex-column align-items-center mb-4">
              <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 100px; height: 100px;">
                <i class="bi bi-person-fill" style="font-size: 2.5rem;"></i>
              </div>

              <div class="text-center mt-3">
                <p class="card-title mb-1">{{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
              </div>
            </div>

            <!-- Botón Editar Perfil -->
            <div class="d-flex justify-content-center mt-4">
              <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-lg px-4" aria-label="Editar Perfil">
                <i class="bi bi-pencil"></i> Editar
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
