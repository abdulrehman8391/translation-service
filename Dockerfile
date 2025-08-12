FROM php:8.1-fpm
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip
WORKDIR /var/www/html
