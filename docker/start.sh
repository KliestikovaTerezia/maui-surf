#!/bin/sh
set -e

# Render urcuje port cez premennu PORT
PORT="${PORT:-10000}"
sed -i "s/Listen 80\$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:cache
php artisan view:cache
php artisan migrate --force

exec apache2-foreground
