# Paso 1: Usar una imagen base de PHP con FPM (FastCGI Process Manager) y extensiones necesarias para Laravel
FROM php:8.1-fpm

# Paso 2: Instalar dependencias necesarias para Laravel (extensiones de PHP, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Paso 3: Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Paso 4: Definir el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Paso 5: Copiar los archivos del proyecto Laravel al contenedor
COPY . .

# Paso 6: Instalar las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Paso 7: Ejecutar las migraciones (si es necesario)
RUN php artisan migrate --force

# Paso 8: Exponer el puerto donde Laravel estará escuchando (por defecto, 9000)
EXPOSE 9000

# Paso 9: Definir el comando de inicio del servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
