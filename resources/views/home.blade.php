@extends('layouts.main')

@section('content')
<!-- Banner Imagen -->
<div class="container-fluid px-0">
    <div class="position-relative" style="width: 100%; height: 0; padding-top: 30%; overflow: hidden;">
        <img src="{{ url('css/imgs/resource/banner_home.png') }}" alt="Banner de Bienvenida"
             class="img-fluid position-absolute"
             style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
    </div>
</div>

<!-- Contenido de la página -->
<div class="container my-5">
    <!-- Título principal -->
    <h1 class="text-start mb-4">Transforma tu gestión de seguridad laboral con SUSTEMIA</h1>

    <!-- Descripción introductoria -->
    <p class="text-start mb-5">Con SUSTEMIA, tú y tu equipo pueden contribuir a un ambiente laboral más seguro y eficiente. Nuestra plataforma digital optimiza la gestión de la seguridad laboral, facilita el cumplimiento normativo y permite el seguimiento de tareas, todo en un sistema intuitivo y fácil de usar.</p>

    <!-- Sección de características del sistema -->
    <section class="my-5">
        <h2 class="text-start mb-4">¿Por qué elegir SUSTEMIA?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Gestión eficiente de tareas</h5>
                        <p class="card-text">Organiza, asigna y da seguimiento a tareas relacionadas con la seguridad laboral de manera fácil y rápida.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Cumplimiento normativo</h5>
                        <p class="card-text">Asegúrate de que tu equipo cumpla con todas las normativas de seguridad, con informes automáticos y recordatorios.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Informes detallados</h5>
                        <p class="card-text">Genera informes personalizados que te ayudarán a analizar el cumplimiento de las tareas y mejorar la seguridad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de contacto -->
    <section class="my-5">
        <h2 class="text-center mb-4">Contáctanos</h2>
        <p class="text-center">¿Tienes preguntas o deseas más información sobre nuestros servicios? <a href="mailto:info@sustemia.com">Contáctanos aquí</a> para obtener más detalles y comenzar a trabajar juntos.</p>
    </section>
</div>



@endsection
