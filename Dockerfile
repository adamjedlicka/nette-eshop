FROM php:8-fpm-alpine

WORKDIR /app

RUN apk update

RUN apk upgrade

RUN apk add composer postgresql-dev

RUN docker-php-ext-configure tokenizer

RUN docker-php-ext-install pdo pdo_pgsql intl tokenizer

COPY composer.json composer.lock ./

RUN composer install

COPY . ./

CMD composer install && php-fpm -R
