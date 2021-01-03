FROM php:7.2-apache

COPY ./infra/api.upsw/etc/php.ini /usr/local/etc/php/php.ini
COPY ./infra/api.upsw/etc/httpd/conf.d/*.conf /etc/apache2/sites-enabled/

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        jq \
        zip \
        unzip \
        zlib1g-dev \
        libpq-dev \
        libxml2-dev \
        libmagickwand-dev \
        libzip-dev \
        libmcrypt-dev \
  && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        opcache \
        zip \
        soap \
        xmlrpc \
        bcmath \
        gd \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

RUN pecl install \
        xdebug \
        apcu \
        mcrypt-1.0.1 \
        imagick \
        redis \
        apfd \
  && docker-php-ext-enable \
        xdebug \
        apcu \
        imagick \
        redis \
        apfd

# enable mod_rewrite
RUN a2enmod rewrite

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php && \
    mv ./composer.phar /usr/local/bin/composer

COPY . /var/www/html
RUN composer install --prefer-dist
