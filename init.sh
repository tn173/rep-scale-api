#!/bin/sh

COMPOSER_MEMORY_LIMIT=-1 composer install

mkdir -p storage/framework/cache/data
# Permission modify
chmod -R 777 storage
chmod -R 777 bootstrap/cache

php artisan config:clear && php artisan optimize:clear
