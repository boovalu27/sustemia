web: php artisan serve --host=0.0.0.0 --port=${PORT}
web: php artisan migrate --force && php artisan serve
