FROM php:8.2-cli

# Dependencias del sistema y extensiones PHP
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

# Instalar dependencias de producción (requisito UT5)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear .env desde .env.example, fichero SQLite y permisos
RUN cp .env.example .env \
    && mkdir -p database && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

# En arranque: generar APP_KEY, cachear config/routes/views, migrar+seedear y servir
CMD php artisan key:generate --force \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force --seed \
    && php artisan serve --host 0.0.0.0 --port $PORT