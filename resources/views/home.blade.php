@extends(auth()->check() && auth()->user()->role
    ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')
    : 'layouts.main')

@section('content')
@section('title', 'Inicio')

<!-- Carrusel de imágenes -->
<div class="container-fluid px-0">
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
              <h3 class="text-white display-5">Transforma tu gestión de seguridad laboral</h3>
              <p class="text-white lead">Optimiza la seguridad en el lugar de trabajo con nuestra plataforma.</p>
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
              <h5 class="text-white display-5">Capacitación continua</h5>
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
              <h5 class="text-white display-5">Asistencia</h5>
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
    <h1 class="text-start mb-4">Tu socio estratégico en seguridad e higiene laboral</h1>
    <p class="text-start mb-5">Con SUSTEMIA, tú y tu equipo pueden contribuir a un ambiente laboral más seguro y eficiente. Nuestra plataforma digital optimiza la gestión de la seguridad laboral, facilita el cumplimiento normativo y permite el seguimiento de tareas, todo en un sistema intuitivo y fácil de usar.</p>

    <!-- Sección de planes de suscripción -->
    <section class="my-5">
        <h2 class="text-start mb-4">Elige el plan que mejor se adapte a tus necesidades</h2>

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3 g-5">
        <div class="col">
            <ul class="card h-100 shadow-lg border-light rounded-4">
            <!-- Header con alineación -->
                <div class="card-body d-flex flex-column">
                    <!-- Título y Dropdown alineados correctamente -->

                        <h3 class="card-title text-primary py-2"> Básico</h3>
                        <p class="card-title fs-4 fw-bold">
                            US$ 500
                        </p>
                        <!-- Título con `flex-grow-1` -->
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Registro de tareas
                        </p>
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Reportes básicos
                        </p>
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> <strong> Soporte limitado:</strong> Acceso a soporte por correo electrónico o chat con tiempos de respuesta estándar
                        </p>
                </div>
            </ul>
        </div>
        <div class="col">
            <ul class="card h-100 shadow-lg border-light rounded-4">
            <!-- Header con alineación -->
                <div class="card-body d-flex flex-column">
                    <!-- Título y Dropdown alineados correctamente -->

                        <h3 class="card-title text-primary py-2"> Intermedio</h3>
                        <p class="card-title fs-4 fw-bold">
                            US$ 1000
                        </p>
                        <!-- Título con `flex-grow-1` -->
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Registro de tareas
                        </p>
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black" title="Tarea Completada"></i> Reportes personalizados a pedido
                        </p>
                        <p class="card-text mb-0 text-start">
                            <i class="bi bi-check-circle-fill text-black" title="Tarea Completada"></i> Capacitaciones en línea (Acceso limitado)
                        </p>
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black" title="Tarea Completada"></i><strong>  Soporte prioritario:</strong>  Respuesta rápida y dedicada a consultas, con tiempos de espera reducidos
                        </p>

                </div>
            </ul>
        </div>
        <div class="col">
            <ul class="card h-100 shadow-lg border-light rounded-4">
            <!-- Header con alineación -->
                <div class="card-body d-flex flex-column">
                    <!-- Título y Dropdown alineados correctamente -->

                        <h2 class="card-title text-primary py-2"> Premium </h2>
                        <p class="card-title fs-4 fw-bold">
                            US$  1500
                        </p>
                        <!-- Título con `flex-grow-1` -->
                        <p class="card-text mb-0 text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Registro de tareas
                        </p>
                        <p class="card-text mb-0 text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Reportes personalizados a pedido
                        </p>
                        <p class="card-text mb-0  text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Acceso exclusivo a capacitaciones
                        </p>
                        <p class="card-text mb-0 text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> Consultor dedicado de SUSTEMIA
                        </p>
                        <p class="card-text mb-0 text-start">
                            <i class="bi bi-check-circle-fill text-black"></i> <strong> Soporte 24/7: </strong> A través de diferentes canales (chat, teléfono, correo)
                        </p>
                </div>
            </ul>
        </div>

    </div>
                <!-- Plan Freemium (sin destacar visualmente) -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-light rounded-4 my-3 py-2">
                        <div class="card-body">
                            <h2 class="card-title text-start">FREEMIUM</h2>
                            <span class="card-title fs-5 fw-bold">Gratis</span>
                            <p class="card-text mb-0 text-start">
                                <i class="bi bi-check-circle-fill text-black"></i> Demo para atraer a nuevos clientes que luego puedan actualizar a un plan de pago.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

</section>
    <!-- Sección de contacto -->
    <section class="my-5">
        <h3 class="text-start mb-4">Contáctanos</h3>
        <p class="text-start">¿Tienes preguntas o deseas más información sobre nuestros servicios? <a href="mailto:info@sustemia.com">Contáctanos aquí</a> para obtener más detalles y comenzar a trabajar juntos.</p>
    </section>
</div>

@endsection
