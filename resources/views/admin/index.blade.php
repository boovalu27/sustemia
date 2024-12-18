@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <!-- Título Principal -->
    <h1 class="text-start text-success py-3">Bienvenido a la plataforma de seguridad e higiene laboral</h1>
    <p class="text-start mb-5">Gestiona y monitorea el plan anual de seguridad e higiene laboral desde aquí.</p>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Sección para Gestión de Usuarios -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header text-center bg-light">
                    <h2 class="mb-0">Gestión de usuarios</h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="text-muted">Administra los usuarios que tienen acceso a la plataforma y gestiona sus permisos.</p>
                    <!-- Botón para ir a la gestión de usuarios -->
                    <a href="{{ route('users.index') }}" class="btn btn-success mt-auto" aria-label="Ver Usuarios">
                        <i class="bi bi-person-fill"></i> Ver usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Tareas -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header text-center bg-light">
                    <h2 class="mb-0">Gestión de tareas</h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="text-muted">Gestiona y monitorea todas las tareas relacionadas con el plan de seguridad e higiene.</p>
                    <!-- Botón para ir a la gestión de tareas -->
                    <a href="{{ route('tasks.index') }}" class="btn btn-success mt-auto" aria-label="Ver Tareas">
                        <i class="bi bi-check-circle-fill"></i> Ver tareas
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Áreas -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header text-center bg-light">
                    <h2 class="mb-0">Gestión de áreas</h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="text-muted">Organiza y gestiona las áreas involucradas en el plan de seguridad e higiene.</p>
                    <!-- Botón para ir a la gestión de áreas -->
                    <a href="{{ route('areas.index') }}" class="btn btn-success mt-auto" aria-label="Ver Áreas">
                        <i class="bi bi-grid-fill"></i> Ver áreas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
