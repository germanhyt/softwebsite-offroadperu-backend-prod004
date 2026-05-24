#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    echo "ERROR: .env file not found. Mount .env.laravel as /var/www/html/.env on the VPS."
    exit 1
fi

echo "Waiting for MySQL..."
until php artisan db:show >/dev/null 2>&1; do
    sleep 2
done

php artisan storage:link --force >/dev/null 2>&1 || true
php artisan migrate --force --no-interaction || {
    echo "WARNING: migrate finished with errors, continuing startup..."
}
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize 2>/dev/null || true

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
