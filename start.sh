#!/bin/sh

cd /var/www/html

cp -n .env.example .env 2>/dev/null || true

# Parse Render's DB_URL key=value format into Laravel env vars
if [ -n "$DB_URL" ]; then
  DB_HOST=$(echo "$DB_URL" | sed -n 's/.*host=\([^ ]*\).*/\1/p')
  DB_PORT=$(echo "$DB_URL" | sed -n 's/.*port=\([^ ]*\).*/\1/p')
  DB_DATABASE=$(echo "$DB_URL" | sed -n 's/.*dbname=\([^ ]*\).*/\1/p')
  DB_USERNAME=$(echo "$DB_URL" | sed -n 's/.*user=\([^ ]*\).*/\1/p')
  DB_PASSWORD=$(echo "$DB_URL" | sed -n 's/.*password=\([^ ]*\).*/\1/p')
  export DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD
  echo "Parsed DB: host=$DB_HOST port=$DB_PORT db=$DB_DATABASE user=$DB_USERNAME"
fi

php artisan key:generate --force 2>&1 || true
php artisan config:clear 2>&1
php artisan config:cache 2>&1
php artisan route:cache 2>&1
php artisan view:cache 2>&1
php artisan migrate --force 2>&1
php artisan storage:link 2>&1 || true

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
