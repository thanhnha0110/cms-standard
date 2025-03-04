#!/bin/bash

php artisan migrate --force
chmod -R 777 bootstrap/ storage/

service nginx start
php-fpm
