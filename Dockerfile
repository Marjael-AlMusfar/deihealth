FROM php:8.3-fpm-alpine AS app

RUN apk add --no-cache bash curl git icu-dev libzip-dev oniguruma-dev mysql-client \
    && docker-php-ext-install intl mbstring pdo_mysql zip bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000
CMD ["sh", "-c", "php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=8000"]
