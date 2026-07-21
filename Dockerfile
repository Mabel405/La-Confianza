# Imagen base con PHP 8.2
FROM php:8.2-fpm

# Instalar librerías necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Extensiones PHP necesarias para Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto
COPY . .

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Permisos Laravel
RUN chmod -R 775 storage bootstrap/cache

# Puerto del contenedor
EXPOSE 8000

# Iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000