FROM php:7.3.4-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
 && apt-get install --no-install-recommends -y procps git zlib1g-dev zip unzip \
 && docker-php-ext-install zip \
 && docker-php-ext-install sockets \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app
