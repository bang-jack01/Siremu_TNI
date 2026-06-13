FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=${PORT}