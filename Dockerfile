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
    && mkdir -p storage/framework/{cache/data,sessions,views} \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN chmod +x start.sh

EXPOSE 8000

CMD ["./start.sh"]
