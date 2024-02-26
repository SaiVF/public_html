FROM php:7.2-apache

USER root

WORKDIR /var/www/html

RUN apt update && apt install -y \
    # nodejs \
    # npm \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

RUN apt-get install -y \
    libmagickwand-dev \
    libmagickcore-dev
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

RUN apt install -y \
    exif \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
