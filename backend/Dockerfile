FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copiar archivos y permisos
COPY . /var/www
WORKDIR /var/www

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9090

