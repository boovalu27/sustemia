@extends('layouts.admin')

@section('content')
<div class="container my-3">
    <h1 class="text-start text-success py-2">Bienvenido a la plataforma de seguridad e higiene laboral</h1>
    <p class="text-start">Gestioná y monitoree las tareas del plan anual de cumplimiento de seguridad e higiene laboral.</p>

    <div class="row g-4">
        <!-- Sección para Gestión de Usuarios -->
        <div class="col-12 col-md-4">
            <div class="card shadow rounded h-100 border-0">
                <div class="card-header text-start text-secondary  d-flex align-items-center justify-content-center">
                    <h4 class="mb-0 text-truncate">Gestión de usuarios</h4> <!-- Título con recorte de texto -->
                </div>
                <div class="card-body d-flex flex-column">
                    <p>Administre los usuarios de la plataforma.</p>
                    <!-- Botón para ir a la gestión de usuarios -->
                    <a href="{{ route('users.index') }}" class="btn btn-success mt-auto" aria-label="Ver Usuarios">
                        <i class="bi bi-person-fill"></i> Ver usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Tareas -->
        <div class="col-12 col-md-4">
            <div class="card shadow rounded h-100 border-0">
                <div class="card-header text-start text-secondary d-flex align-items-center justify-content-center">
                    <h4 class="mb-0 text-truncate">Gestión de tareas</h4> <!-- Título con recorte de texto -->
                </div>
                <div class="card-body d-flex flex-column">
                    <p>Administre las tareas creadas.</p>
                    <!-- Botón para ir a la gestión de tareas -->
                    <a href="{{ route('tasks.index') }}" class="btn btn-success mt-auto" aria-label="Ver Tareas">
                        <i class="bi bi-check-circle-fill"></i> Ver tareas
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Áreas -->
        <div class="col-12 col-md-4">
            <div class="card shadow rounded h-100 border-0">
                <div class="card-header text-start text-secondary d-flex align-items-center justify-content-center">
                    <h4 class="mb-0 text-truncate">Gestión de áreas</h4> <!-- Título con recorte de texto -->
                </div>
                <div class="card-body d-flex flex-column">
                    <p>Administre las áreas relacionadas con las tareas.</p>
                    <!-- Botón para ir a la gestión de áreas -->
                    <a href="{{ route('areas.index') }}" class="btn btn-success" aria-label="Ver Áreas">
                        <i class="bi bi-grid-fill"></i> Ver áreas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
