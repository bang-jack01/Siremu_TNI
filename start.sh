#!/bin/bash

echo "Install dependency"
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-gd

echo "Generate key"
php artisan key:generate

echo "Cache config"
php artisan config:cache

echo "Run migration"
php artisan migrate --force

echo "Start Laravel"
php artisan serve --host=0.0.0.0 --port=$PORT

