FROM composer/composer:2-bin AS composer

FROM dunglas/frankenphp:php8.5-trixie

RUN install-php-extensions intl pdo_pgsql zip

COPY --from=composer /composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader \
    && mkdir -p var/cache var/log
