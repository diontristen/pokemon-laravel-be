FROM php:8.2.0 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer 

WORKDIR /var/www/app
COPY . .

ENTRYPOINT [ "docker/entrypoint.sh" ]
