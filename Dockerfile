FROM php:8.2-fpm

# Instalar paquetes necesarios
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiar el proyecto (incluye vendor si no está en .dockerignore)
COPY . .

# Permisos
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]