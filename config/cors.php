<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the CORS settings for your application.
    | You can customize which origins, methods, and headers are allowed.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Rutas donde aplicar CORS

    'allowed_methods' => ['*'],  // Permitir todos los métodos HTTP (GET, POST, PUT, DELETE, OPTIONS)

    'allowed_origins' => ['*'],  // Permitir todos los orígenes (cuidado con la seguridad)

    'allowed_headers' => ['*'],  // Permitir todos los encabezados

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,  // Cambiar a `true` si usas cookies o autenticación con credenciales
];
