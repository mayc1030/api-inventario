FROM php:8.2-fpm

# Instalar dependencias y nginx
RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP con Composer
RUN composer install --no-dev --optimize-autoloader

# Dar permisos para storage y cache
RUN chmod -R 777 storage bootstrap/cache

# Copiar configuración nginx
COPY nginx.conf /etc/nginx/sites-enabled/default

# Copiar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto 8080 (se reemplaza dinámicamente)
EXPOSE 8080

# Ejecutar el script de inicio que arranca migraciones, nginx y php-fpm
CMD ["/start.sh"]
