FROM php:8.1-cli

# 1. Install dependency sistem yang dibutuhkan oleh PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    libzip-dev

# 2. Hapus pdo_mysql lama, PAKSA install pdo_pgsql dan pgsql
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

WORKDIR /app

COPY . .

# 3. Ambil composer terbaru
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Install semua package laravel tanpa development tools
RUN composer install --no-dev --optimize-autoloader

# 5. Jalankan server utama via port yang dikasih Railway
CMD php artisan serve --host=0.0.0.0 --port=${PORT}