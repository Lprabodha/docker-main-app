# Add PHP-FPM base image
FROM php:8.2-fpm

WORKDIR /var/www/html

# Install your extensions
# To connect to MySQL, add mysqli
RUN apt-get update && \
    apt-get install -y libpng-dev && \
    docker-php-ext-install pdo pdo_mysql gd

EXPOSE 80

