#!/bin/sh
set -eu
cd /var/www/html
mkdir -p storage/app/public storage/app/private storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs /var/lib/tet
php deployment/initialize-database.php
chown -R www-data:www-data storage bootstrap/cache /var/lib/tet
php artisan storage:link --force
php artisan migrate --force
php artisan view:cache
exec "$@"
