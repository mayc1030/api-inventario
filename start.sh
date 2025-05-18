#!/bin/bash

# Ejecutar migraciones de Laravel
php artisan migrate --force

# Reemplazar el puerto 8080 en nginx.conf por el puerto que da Railway en la variable $PORT
sed -i "s/listen 8080;/listen ${PORT};/" /etc/nginx/sites-enabled/default

# Iniciar nginx
service nginx start

# Iniciar php-fpm en primer plano (para que el contenedor no se cierre)
php-fpm -F
