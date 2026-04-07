FROM php:8.2-cli

# Dependencias del sistema y extensiones PHP (SQLite + MySQL para flexibilidad)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear fichero SQLite vacío y permisos (en producción usaremos SQLite por ser gratis en Render)
RUN mkdir -p database && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

# En arranque: APP_KEY, cachear, migrar+seedear y servir
CMD php artisan key:generate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan migrate --force --seed \
    && php artisan serve --host 0.0.0.0 --port $PORT
