@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h1 class="text-center text-success mb-4">Bienvenido a la plataforma de seguridad e higiene laboral</h1>
    <p class="lead text-center">Gestioná y monitoree las tareas del plan anual de cumplimiento de seguridad e higiene laboral.</p>

    <div class="row g-4">
        <!-- Sección para Gestión de Usuarios -->
        <div class="col-md-4">
            <div class="card card-custom h-100">
                <div class="card-header text-center" style="background-color: var(--color-success);">
                    <h4 class="mb-0 text-white">Gestión de usuarios</h4>
                </div>
                <div class="card-body">
                    <p>Administre los usuarios de la plataforma.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-success" aria-label="Ver Usuarios">
                        <i class="bi bi-person-fill"></i> Ver usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Tareas -->
        <div class="col-md-4">
            <div class="card card-custom h-100">
                <div class="card-header text-center" style="background-color: var(--color-success);">
                    <h4 class="mb-0 text-white">Gestión de tareas</h4>
                </div>
                <div class="card-body">
                    <p>Administre las tareas creadas.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-success" aria-label="Ver Tareas">
                        <i class="bi bi-check-circle-fill"></i> Ver tareas
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección para Gestión de Áreas -->
        <div class="col-md-4">
            <div class="card card-custom h-100">
                <div class="card-header text-center" style="background-color: var(--color-success);">
                    <h4 class="mb-0 text-white">Gestión de áreas</h4>
                </div>
                <div class="card-body">
                    <p>Administre las áreas relacionadas con las tareas.</p>
                    <a href="{{ route('areas.index') }}" class="btn btn-outline-success" aria-label="Ver Áreas">
                        <i class="bi bi-grid-fill"></i> Ver áreas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
