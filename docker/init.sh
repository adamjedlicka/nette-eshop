#!/usr/bin/env sh

composer install

php vendor/bin/phinx migrate

php-fpm -R
