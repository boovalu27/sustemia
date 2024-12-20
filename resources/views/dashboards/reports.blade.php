@extends(auth()->check() && auth()->user()->hasRole('admin')
  ? 'layouts.admin'
  : 'layouts.main')

@section('content')
@section('title', 'Reportes')

<div class="container my-4">
  <h1 class="text-start text-success mb-2">Panel de reportes</h1>
  <p>
    Aquí podrás ver una visión general del estado de las tareas. Así como visualizar gráficos interactivos sobre el estado de las tareas y su distribución por área.
    Además, se muestran las tareas vencidas y las próximas a vencer, proporcionando información importante para el seguimiento y gestión eficiente de las actividades.
  </p>

  <!-- Panel de administración solo visible para usuarios con rol de admin -->
  @if(auth()->user()->hasRole('admin'))
    <div class="row text-start my-4">

      <!-- Total de áreas -->
      <div class="col-md-6 col-xl-3">
        <a href="{{ route('areas.index') }}" class="text-decoration-none">
          <div class="card bg-primary text-white m-2">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-8">
                  <h2 class="m-0">{{ $totalAreasCount }} +</h2>
                  <p class="mb-0 ">Total de áreas</p>
                </div>
                <div class="col-4 text-end">
                  <i class="bi bi-collection-fill" title="Total de tareas"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Total de Usuarios -->
      <div class="col-md-6 col-xl-3">
        <a href="{{ route('users.index') }}" class="text-decoration-none">
          <div class="card bg-warning text-black m-2">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-8">
                  <h2 class="m-0">{{ $totalUsersCount }} +</h2>
                  <p class="mb-0">Total de usuarios</p>
                </div>
                <div class="col-4 text-end">
                  <i class="bi bi-people-fill" title="Total de Usuarios"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Total de Tareas -->
      <div class="col-md-6 col-xl-3">
        <a href="{{ route('tasks.index') }}" class="text-decoration-none">
          <div class="card bg-black text-white m-2">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-8">
                  <h2 class="m-0">{{ $totalTasksCount }} +</h2>
                  <p class="mb-0">Tareas creadas</p>
                </div>
                <div class="col-4 text-end">
                  <i class="bi bi-clipboard-check-fill" title="Total tareas"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Total de Tareas Completadas -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-success m-2">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-8">
                <h2 class="text-white m-0">{{ $completedTasksCount }} +</h2>
                <p class="mb-0 text-white">Tareas completadas</p>
              </div>
              <div class="col-4 text-end">
                <i class="bi bi-clipboard-check-fill text-white" title="Total tareas"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  @endif

  <!-- Estadísticas de Tareas por Área -->
  <div class="col-md-12 mb-4">
    <h2 class="mb-4 text-start">Tareas por área</h2>
    <div class="row">
      @foreach ($tasksByArea as $area)
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="shadow rounded-3">
            <div class="card-body d-flex flex-column justify-content-between p-4">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title text-secondary mb-0">{{ $area->area_name }}</h3>
                <span class="badge bg-black text-white rounded-pill">{{ $area->total }} tareas</span>
              </div>
              <div class="my-3">
                <p class="card-text">
                  <i class="bi bi-hourglass-split text-warning" title="Tarea pendiente"></i> Pendientes: {{ $area->pending }} / {{ $area->total }}
                </p>
                <p class="card-text">
                  <i class="bi bi-check-circle-fill text-success" title="Tarea completada"></i> Completadas: {{ $area->completed }} / {{ $area->total }}
                </p>
                <p class="card-text">
                  <i class="bi bi-check-circle-fill text-success" title="Tarea completada con retraso"></i>
                  <i class="bi bi-calendar-x-fill text-danger" title="Tarea Vencida"></i> Completadas con retraso: {{ $area->completed_with_delay }} / {{ $area->total }}
                </p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Gráficos de Estado de Tareas y Distribución por Área -->
  <div class="row my-2 text-center">

    <!-- Gráfico de Estado de Tareas -->
    <div class="col-md-6 col-sm-12">
      <div class="shadow rounded-4 p-4">
        <h2 class="py-2">% Porcentaje de tareas por estado</h2>
        <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
          <canvas id="tasksStatusChart" aria-label="Gráfico de Estado de Tareas" role="img"></canvas>
        </div>
      </div>
    </div>

    <!-- Gráfico de Tareas por Área -->
    <div class="col-md-6 col-sm-12">
      <div class="shadow rounded-4 p-4">
        <h2 class="py-2">Distribución de tareas por área</h2>
        <div class="chart-container d-flex justify-content-center align-items-center" style="position: relative; height: 400px; width: 100%;">
          <canvas id="tasksByAreaChart" aria-label="Gráfico de Tareas por Área" role="img"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Datos para los gráficos
    const completedPercentage = @json($completedPercentage);
    const pendingPercentage = @json($pendingPercentage);
    const overduePercentage = @json($overduePercentage);

    const tasksByAreaData = @json($tasksByArea).map(area => area.total);
    const tasksByAreaLabels = @json($tasksByArea).map(area => area.area_name);

    // Gráfico de Estado de Tareas
    const tasksStatusChart = new Chart(document.getElementById('tasksStatusChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: ['Estado de las tareas'],
        datasets: [
          {
            label: 'Completadas',
            data: [completedPercentage],
            backgroundColor: '#28a745',
            borderColor: '#1e7e34'
          },
          {
            label: 'Pendientes',
            data: [pendingPercentage],
            backgroundColor: '#ffc107',
            borderColor: '#d39e00'
          },
          {
            label: 'Vencidas',
            data: [overduePercentage],
            backgroundColor: '#dc3545',
            borderColor: '#c82333'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: {
              stepSize: 10
            }
          }
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              pointStyle: 'circle',
              radius: 7,
              padding: 10,
              font: {
                size: 12
              }
            }
          }
        }
      }
    });

    // Gráfico de Tareas por Área
    const tasksByAreaChart = new Chart(document.getElementById('tasksByAreaChart').getContext('2d'), {
      type: 'pie',
      data: {
        labels: tasksByAreaLabels,
        datasets: [{
          label: 'Tareas por Área',
          data: tasksByAreaData,
          backgroundColor: ['#3c4239', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1'],
          borderColor: '#fff'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              pointStyle: 'circle',
              radius: 7,
              padding: 10,
              font: {
                size: 12
              }
            }
          }
        }
      }
    });
  </script>

  <!-- Tareas Vencidas -->
  <div class="col-lg-12 col-md-12 mb-4">
    <h2 class="text-danger my-4">Tareas vencidas</h2>
    @if($overdueTasks->isEmpty())
      <p class="text-center p-3 shadow-sm mb-3">No hay tareas vencidas.</p>
    @else
      <div class="row">
        @foreach ($overdueTasks as $task)
          <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="list-group-item d-flex flex-column justify-content-between p-3 rounded shadow h-100">
              <div class="task-info mb-3 flex-grow-1">
                <h3 class="mb-1"><strong>{{ $task->title }}</strong></h3>
                <p class="mb-1">Vence el {{ $task->due_date->format('d/m/Y') }}</p>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-auto w-100">
                <span class="badge bg-danger text-white rounded-pill">Vencida</span>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-danger btn-sm" aria-label="Ver detalles de la tarea {{ $task->title }}">
                  <i class="bi bi-eye"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  <!-- Tareas Próximas a Vencer -->
  <div class="col-lg-12 col-md-12 mb-4">
    <h2 class="text-warning my-4">Tareas próximas a vencer este mes</h2>
    @if($upcomingTasks->isEmpty())
      <p class="text-center p-3 shadow-sm mb-3">No hay tareas próximas a vencer este mes</p>
    @else
      <div class="row">
        @foreach ($upcomingTasks as $task)
          <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="list-group-item d-flex flex-column justify-content-between p-3 rounded shadow h-100">
              <div class="task-info mb-3 flex-grow-1">
                <h3 class="mb-1"><strong>{{ $task->title }}</strong></h3>
                <p class="mb-1">Vence el {{ $task->due_date->format('d/m/Y') }}</p>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-auto w-100">
                <span class="badge bg-warning text-black rounded-pill">Vence pronto</span>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                  <i class="bi bi-eye"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

</div>
@endsection
