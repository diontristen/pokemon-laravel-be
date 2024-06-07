FROM php:8.2.0 as php

# Update and install necessary packages
RUN apt-get update -y \
    && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Install and enable the redis extension
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Copy composer from the composer image
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/app

# Copy the application files
COPY . .

# Set the entrypoint
ENTRYPOINT ["docker/entrypoint.sh"]

