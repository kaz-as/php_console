FROM php:8.0-fpm

RUN apt update && \
    apt install -y \
        git \
        && \
    pecl install \
        xdebug \
        && \
    docker-php-ext-enable \
        xdebug \
        && \
    apt autoremove && \
    apt clean && \
    rm -r /var/lib/apt/lists/*

# Using the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
# Overriding default config
COPY php.override.ini $PHP_INI_DIR/conf.d/

WORKDIR /app
