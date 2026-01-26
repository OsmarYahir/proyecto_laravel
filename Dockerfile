FROM php:8.2-fpm

# Variables de entorno
ENV DEBIAN_FRONTEND=noninteractive

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    postgresql-client \
    libpq-dev

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario
RUN useradd -G www-data,root -u 1000 -d /home/appuser appuser
RUN mkdir -p /home/appuser/.composer && \
    chown -R appuser:appuser /home/appuser

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY --chown=appuser:appuser . /var/www

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear directorios necesarios y dar permisos
RUN mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R appuser:www-data storage bootstrap/cache

# Configurar Nginx
COPY <<'EOF' /etc/nginx/sites-available/default
server {
    listen 8080;
    root /var/www/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

# Configurar Supervisor
COPY <<'EOF' /etc/supervisor/conf.d/supervisord.conf
[supervisord]
nodaemon=true

[program:php-fpm]
command=php-fpm
autostart=true
autorestart=true

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
EOF

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]