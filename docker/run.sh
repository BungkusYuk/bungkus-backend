#!/bin/sh

cd /var/www
composer install --optimize-autoloader --no-dev

php artisan migrate
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache

/usr/bin/supervisord -c /etc/supervisord.conf
