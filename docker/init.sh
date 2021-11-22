#!/usr/bin/env sh

composer install

php-fpm -R
