FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
        libpq-dev \
        git \
        libzip-dev \
        unzip \
    && docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-install  pdo_pgsql \
    && docker-php-ext-configure zip --with-zip \
    && docker-php-ext-install  zip

RUN curl --silent --show-error https://getcomposer.org/installer | php