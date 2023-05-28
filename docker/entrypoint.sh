#!/usr/bin/env bash

chmod -R 777 storage/
composer install
php artisan migrate --force

docker-php-entrypoint php-fpm &
tail -f /dev/null
