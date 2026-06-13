FROM php:8.1-cli

# 1. Install dependency sistem yang dibutuhkan oleh PostgreSQL & GD (ekstensi gambar)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    git \
    unzip \
    zip \
    libzip-dev

# 2. Konfigurasi ekstensi GD sebelum diinstall
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# 3. INSTALL SEMUA DRIVER (Lengkap: PGSQL + GD + ZIP)
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    gd \
    zip

WORKDIR /app

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=${PORT}