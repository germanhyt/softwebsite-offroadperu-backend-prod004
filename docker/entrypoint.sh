#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    echo "ERROR: .env file not found. Mount or create it before starting the container."
    exit 1
fi

echo "Waiting for MySQL..."
until php -r "
    try {
        new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
        exit(0);
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null; do
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
