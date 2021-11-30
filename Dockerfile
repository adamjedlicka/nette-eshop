FROM php:8.0.11-fpm-alpine3.14

WORKDIR /app

RUN apk update

RUN apk upgrade

RUN apk add composer postgresql-dev

RUN docker-php-source extract

RUN docker-php-ext-install pdo pdo_pgsql intl

RUN docker-php-source delete

COPY composer.json composer.lock ./

RUN composer install

COPY . ./

CMD composer install && php-fpm -R
