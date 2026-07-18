#!/bin/sh
cd /var/www/html

cp -n .env.example .env 2>/dev/null || true
php artisan key:generate --force 2>&1 || true
php artisan config:clear 2>&1
php artisan config:cache 2>&1
php artisan route:cache 2>&1
php artisan view:cache 2>&1
php artisan migrate --force 2>&1
php artisan storage:link 2>&1 || true
php artisan db:seed --force 2>&1 || true

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
