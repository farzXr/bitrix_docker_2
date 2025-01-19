# Dockerfile
FROM php:8.1-fpm

# Установка необходимых пакетов и зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    pkg-config \
    zip \
    unzip \
    git \
    curl

# Устанавливаем и конфигурируем расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        mysqli \
        pdo \
        pdo_mysql \
        mbstring \
        opcache \
        soap

# Копируем файл настроек PHP
COPY php.ini /usr/local/etc/php/php.ini

# Устанавливаем рабочую директорию
WORKDIR /var/www/html
