FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
    && chmod +x start.sh \
    && mkdir -p storage/framework/{cache/data,sessions,views} \
    && mkdir -p bootstrap/cache storage/logs \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "cp -n .env.example .env 2>/dev/null; php artisan key:generate --force 2>&1; php artisan config:clear 2>&1; php artisan config:cache 2>&1; php artisan route:cache 2>&1; php artisan view:cache 2>&1; php artisan migrate --force 2>&1; php artisan storage:link 2>&1; exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
