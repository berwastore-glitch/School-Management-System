#!/bin/sh

LOG=/var/www/html/storage/logs/startup.log
mkdir -p /var/www/html/storage/logs

echo "=== SchoolMS Startup $(date) ===" > "$LOG"
echo "PORT=$PORT" >> "$LOG"
echo "DB_URL=$DB_URL" >> "$LOG"
echo "APP_KEY=${APP_KEY:-(not set)}" >> "$LOG"
echo "APP_URL=$APP_URL" >> "$LOG"

cd /var/www/html

# Copy env if not present
if [ ! -f .env ]; then
  cp .env.example .env
  echo "Copied .env.example to .env" >> "$LOG"
fi

# Set DB_URL into .env for Laravel
if [ -n "$DB_URL" ]; then
  sed -i "s|DB_HOST=.*|DB_HOST=|" .env
  sed -i "s|DB_PORT=.*|DB_PORT=|" .env
  sed -i "s|DB_DATABASE=.*|DB_DATABASE=|" .env
  sed -i "s|DB_USERNAME=.*|DB_USERNAME=|" .env
  sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=|" .env
fi

php artisan key:generate --force 2>> "$LOG" || echo "key:generate failed" >> "$LOG"
php artisan config:clear 2>> "$LOG" || echo "config:clear failed" >> "$LOG"
php artisan config:cache 2>> "$LOG" || echo "config:cache failed" >> "$LOG"
php artisan route:cache 2>> "$LOG" || echo "route:cache failed" >> "$LOG"
php artisan view:cache 2>> "$LOG" || echo "view:cache failed" >> "$LOG"

php artisan migrate --force 2>> "$LOG" && echo "Migrations OK" >> "$LOG" || echo "MIGRATION FAILED" >> "$LOG"

php artisan storage:link 2>> "$LOG" || true

echo "Starting server on port ${PORT:-8000}" >> "$LOG"
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
