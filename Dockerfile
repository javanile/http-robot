FROM php:7.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
 && apt-get install --no-install-recommends -y procps \
 && docker-php-ext-install sockets \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app


