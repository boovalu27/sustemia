<?php

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Asegúrate de que este locale esté disponible en tu servidor
        setlocale(LC_TIME, 'es_ES.UTF-8');
        Carbon::setLocale('es');

        // Forzar el uso de HTTPS en entornos de producción
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
