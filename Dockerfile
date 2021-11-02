ARG PHP_VERSION=7.4.0

FROM php:${PHP_VERSION}-fpm as php

WORKDIR /app

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_CACHE_DIR /var/cache/composer
VOLUME $COMPOSER_CACHE_DIR
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/

