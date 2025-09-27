# Usamos una imagen base de PHP-FPM optimizada
FROM php:8.2-fpm

# Instalamos dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    wget \
    curl \
    --no-install-recommends && rm -rf /var/lib/apt/lists/*

# Instalamos extensiones de PHP comunes para Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install pdo pdo_mysql zip opcache gd

# Instalamos Composer (administrador de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuramos el usuario para evitar problemas de permisos
RUN useradd -ms /bin/bash appuser
USER appuser

# Definimos el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Exponemos el puerto de PHP-FPM (usado internamente por Nginx)
EXPOSE 9000

# Comando por defecto para iniciar PHP-FPM
CMD ["php-fpm"]
