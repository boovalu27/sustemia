@extends(auth()->check() && auth()->user()->hasRole('admin')
  ? 'layouts.admin'
  : 'layouts.main')

@section('content')
@section('title', 'Inicio')

<!-- Carrusel de imágenes -->
<div class="container-fluid px-0">
  <h1 class="d-none">Bienvenido a la plataforma de Sustemia: Optimización de la seguridad laboral</h1>

  <!-- Carrusel de Bootstrap -->
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- Imagen 1 -->
      <div class="carousel-item active">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh; position: relative;">
          <!-- Contenedor de imagen con opacidad -->
          <img src="{{ asset('css/imgs/resource/banner_home.png') }}" class="d-block w-100 h-100" alt="Banner de Bienvenida" style="object-fit: cover;">
          <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div> <!-- Capa de opacidad -->
          <div class="carousel-caption d-flex justify-content-center align-items-center text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; padding: 20px; border-radius: 10px; width: 90%;">
            <div>
              <h2 class="text-white display-5">Transforma tu gestión de seguridad laboral</h2>
              <p class="text-white lead">Optimiza la seguridad en tu lugar de trabajo con nuestra plataforma.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Imagen 2 -->
      <div class="carousel-item">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh; position: relative;">
          <!-- Contenedor de imagen con opacidad -->
          <img src="{{ asset('css/imgs/resource/seguridadlaboralcapacitacion.jpg') }}" class="d-block w-100 h-100" alt="Imagen 2" style="object-fit: cover;">
          <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div> <!-- Capa de opacidad -->
          <div class="carousel-caption d-flex justify-content-center align-items-center text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; padding: 20px; border-radius: 10px; width: 90%;">
            <div>
              <h2 class="text-white display-5">Capacitación continua</h2>
              <p class="text-white lead">Accede a capacitaciones para mejorar la seguridad laboral.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Imagen 3 -->
      <div class="carousel-item">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh; position: relative;">
          <!-- Contenedor de imagen con opacidad -->
          <img src="{{ asset('css/imgs/resource/support.jpg') }}" class="d-block w-100 h-100" alt="Imagen 3" style="object-fit: cover;">
          <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div> <!-- Capa de opacidad -->
          <div class="carousel-caption d-flex justify-content-center align-items-center text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; padding: 20px; border-radius: 10px; width: 90%;">
            <div>
              <h2 class="text-white display-5">Asistencia</h2>
              <p class="text-white lead">Obtén asistencia en cualquier momento para resolver tus dudas.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="z-index: 10;">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="z-index: 10;">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

<!-- Contenido de la página -->
<div class="container my-5">
  <h2 class="text-start mb-4">Tu socio estratégico en seguridad e higiene laboral</h2>
  <p class="text-start mb-5">
    Con <strong>SUSTEMIA</strong>, tú y tu equipo pueden contribuir a un ambiente laboral más seguro y eficiente. Nuestra plataforma digital optimiza la gestión de la seguridad laboral, facilita el cumplimiento normativo y permite el seguimiento de tareas, todo en un sistema intuitivo y fácil de usar.
  </p>

  <!-- Sección de planes de suscripción -->
  <section class="my-5">
    <h2 class="text-start mb-4">Elige el plan que mejor se adapte a tus necesidades</h2>
    <div class="row g-4">
      @foreach([
        ['name' => 'Básico', 'price' => 'US$ 500', 'features' => ['Registro de tareas', 'Reportes básicos', 'Soporte limitado: Acceso a soporte por correo electrónico o chat con tiempos de respuesta estándar']],
        ['name' => 'Intermedio', 'price' => 'US$ 1000', 'features' => ['Registro de tareas', 'Reportes personalizados', 'Capacitaciones limitadas', 'Soporte prioritario: Respuesta rápida y dedicada a consultas, con tiempos de espera reducidos.']],
        ['name' => 'Premium', 'price' => 'US$ 1500', 'features' => ['Registro de tareas', 'Capacitaciones exclusivas', 'Reportes personalizados', 'Soporte 24/7: A través de diferentes canales (chat, teléfono, correo)']],
        ['name' => 'Freemium', 'price' => 'US$ 0', 'features' => ['Acceso limitado para conocer la plataforma']]
      ] as $plan)
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 shadow border-light rounded-4 py-4">
            <div class="card-body d-flex flex-column">
              <!-- Título del plan -->
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-secondary mb-0">{{ $plan['name'] }}</h3>
                <div class="fs-5 fw-bold px-3 py-1 text-success rounded-3 shadow-sm bg-success bg-opacity-10">
                  {{ $plan['price'] }}
                </div>
              </div>
              <!-- Lista de características -->
              <ul class="list-unstyled mb-auto text-start">
                @foreach($plan['features'] as $feature)
                  <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>
</div>

<!-- Sección de contacto -->
<section class="my-5">
  <div class="container">
    <h2 class="text-start mb-4">Contáctanos</h2>
    <p class="text-start mb-4">¿Tienes preguntas o deseas más información sobre nuestros servicios? <a href="mailto:info@sustemia.com">Contáctanos ahora</a> para obtener más detalles y comenzar a trabajar juntos.</p>

    <div class="row">
      <div class="col-12 col-md-6 mb-4">
        <h5 class="text-start">¿Por qué contactarnos?</h5>
        <p class="text-start">Si necesitas más detalles sobre cómo podemos ayudarte a optimizar la seguridad laboral en tu empresa, estamos disponibles para brindarte más información y asesoramiento.</p>
      </div>
      <div class="col-12 col-md-6 mb-4">
        <h5 class="text-start">Nuestro horario de atención</h5>
        <p class="text-start">Estamos disponibles de lunes a viernes, de 9:00 AM a 6:00 PM. No dudes en enviarnos un correo, y te responderemos lo antes posible.</p>
      </div>
    </div>
  </div>
</section>

@endsection
