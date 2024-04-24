FROM composer:2.3.3 AS composer
FROM php:8.2.11-fpm-alpine3.18

RUN apk add --update nodejs npm

RUN apk update && apk add --no-cache \
    zlib-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    nano \
    bash \
    tidyhtml-dev \
    imagemagick-dev \
    && docker-php-ext-install pdo pdo_mysql pcntl gd zip

RUN docker-php-ext-configure intl && docker-php-ext-install intl

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www
