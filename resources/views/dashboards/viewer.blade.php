@extends('layouts.main')

@section('content')
  <div class="container my-3">
    <h1 class="mb-4 text-left">Panel de Control de Seguridad e Higiene</h1>
    <p class="text-left mb-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-left p-2">Aquí podrás supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

    <!-- Filtros para Tareas -->
    <div class="mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Filtrar Tareas</h5>
          <form method="GET" action="{{ route('dashboards.viewer') }}" aria-label="Filtrar tareas">
            <div class="row g-3 mb-3">
              <div class="col-md-12">
                <label for="search" class="form-label">Buscar Tareas</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Buscar por título o descripción" oninput="this.form.submit()">
              </div>
              <div class="col-md-3">
                <label for="filterArea" class="form-label">Área</label>
                <select id="filterArea" name="area" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Área</option>
                  @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label for="month" class="form-label">Mes</label>
                <select id="month" name="month" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Mes</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-3">
                <label for="year" class="form-label">Año</label>
                <select id="year" name="year" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Año</option>
                  @for ($year = now()->year; $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-3">
                <label for="filterStatus" class="form-label">Estado</label>
                <select id="filterStatus" name="status" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Estado</option>
                  <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                  <option value="Completada" {{ request('status') == 'Completada' ? 'selected' : '' }}>Completada</option>
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mb-3">
        <div class="alert alert-info d-flex align-items-center">
            <div class="d-flex flex-wrap">
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-danger">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Vencida
                </div>
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-warning text-dark">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Pendiente
                </div>
                <div class="me-2 me-md-3 mb-2">
                    <span class="badge bg-success">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Completada
                </div>
            </div>
        </div>
    </div>


    <!-- Tabla de Tareas -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Fecha de Creación</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Área</th>
            <th>Fecha de Vencimiento</th>
            <th>Fecha de Cierre</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tasks as $task)
            <tr class="{{ $task->due_date < now() ? 'table-danger' : ($task->status == 'Completada' ? 'table-success' : 'table-warning') }}">
              <td>{{ $task->created_at ? $task->created_at->format('d/m/Y') : 'Sin fecha' }}</td>
              <td>{{ $task->title }}</td>
              <td>{{ Str::limit($task->description, 50) }}</td>
              <td>{{ $task->area->name ?? 'Sin área' }}</td>
              <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</td>
              <td>{{ $task->completed_at ? $task->completed_at->format('d/m/Y') : '' }}</td>
              <td>
                <span class="badge {{ $task->status == 'Completada' ? 'bg-success' : ($task->status == 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                  {{ $task->status }}
                </span>
              </td>
              <td class="align-top">
                  <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-lg w-100 mt-1" aria-label="Ver Detalles">
                    <i class="bi bi-eye"></i> Detalles
                  </a>

              </td>

            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
