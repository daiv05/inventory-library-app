FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copiar archivos y permisos
COPY . /var/www/html/backend
WORKDIR /var/www/html/backend

RUN chown -R www-data:www-data /var/www/html/backend \
    && chmod -R 755 /var/www/html/backend

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Instalar dependencias de Composer (dev)
RUN composer install --no-interaction

# Generar clave de aplicación
#RUN php artisan key:generate

# Generar jwt secret
# RUN php artisan jwt:secret --force

# Ejecutar migraciones y seeders
# RUN php artisan migrate --force
# RUN php artisan db:seed --force

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9090

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9090"]
