<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') Administración</title>
  <link rel="icon" type="image/png" href="{{ asset('css/imgs/favicon-32x32.png') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> <!-- Estilos específicos para el admin -->

  <!-- Cargar Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Cargar Tooltips.js -->
  <script src="{{ asset('js/tooltips.js') }}"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Conexión a Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <div id="app">
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ asset('/') }}" aria-label="Ir a la página principal">
          <img id="sidebarLogo" class="rounded mx-auto" src="{{ asset('css/imgs/resource/sustemia_oficial.png') }}" alt="Logo de Sustemia" height="50">
        </a>

        <!-- Botón para móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <!-- Panel -->
            @auth
              <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboards.index') }}">
                  <i class="bi bi-ui-checks-grid text-primary"></i> Panel
                </a>
              </li>

              <!-- Configuración -->
              @if(auth()->user()->hasAnyRole(['admin']))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.index') }}">
                    <i class="bi bi-gear-fill text-secondary"></i> Configuración
                  </a>
                </li>
              @endif

              <!-- Reportes -->
              <li class="nav-item">
                <a class="nav-link" href="{{ route('reports.index') }}" aria-label="Ir a reportes">
                  <i class="bi bi-bar-chart-fill text-success"></i> Reportes
                </a>
              </li>

              <!-- Perfil -->
              <li class="nav-item dropdown">
                <!-- Ícono de perfil -->
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle" style="font-size: 30px;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <!-- Bienvenida y rol del usuario -->
                  <li class="text-center p-1">
                    <p class="mb-0 fw-bold ">{{ auth()->user()->name }}</p>
                  </li>
                  <li><hr class="dropdown-divider"></li>

                  <!-- Opciones del menú -->
                  <li><a class="dropdown-item" href="{{ route('profile.view') }}"><i class="bi bi-person-fill"></i> Perfil</a></li>
                  <li><hr class="dropdown-divider"></li>

                  <!-- Cerrar sesión -->
                  <li>
                    <form action="{{ route('auth.logout') }}" method="post">
                      @csrf
                      <button type="submit" class="dropdown-item"><i class="bi-arrow-left-circle-fill"></i> Cerrar sesión</button>
                    </form>
                  </li>
                </ul>
              </li>
            @endauth

            <!-- Iniciar sesión -->
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.login') }}"> Ingresar <i class="bi bi-arrow-right-circle-fill" aria-label="iniciar sesion"></i></a>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <!-- Contenedor de Alertas -->
    @if(Session::has('success') || Session::has('warning') || Session::has('error'))
      <div class="container">
        <div class="d-flex justify-content-center my-4">
          <div class="col-12">
            @if(Session::has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi-check-circle"></i> {!! Session::get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
              </div>
            @elseif(Session::has('warning'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi-exclamation-circle"></i> {!! Session::get('warning') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
              </div>
            @elseif(Session::has('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi-exclamation-circle"></i> {!! Session::get('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif

    <!-- Contenido principal -->
    <main class="content my-2">
      <div class="content" role="main">
        <section class="col-md-12">
          @yield('content')
        </section>
      </div>
    </main>
  </div>

  <!-- Footer -->
  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-4 my-4 border-top border-warning">
      <div class="col-md-4 d-flex align-items-center">
        <span class="text-success">© SUSTEMIA</span>
      </div>

      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-muted" href="https://www.linkedin.com/company/sustemia-llc"><i class="bi bi-linkedin text-primary"></i></a></li>
        <li class="ms-3"><a class="text-muted" href="mailto:info@sustemia.com"><i class="bi-envelope-fill text-secondary"></i></a></li>
      </ul>
    </footer>
  </div>

  <!-- Bootstrap Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
