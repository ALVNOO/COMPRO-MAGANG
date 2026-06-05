#!/bin/sh
set -e

echo "Preparing storage directories..."
mkdir -p storage/framework/views \
         storage/framework/cache \
         storage/framework/sessions \
         storage/logs \
         bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

echo "Linking storage..."
php artisan storage:link || true

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting supervisord..."
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
