# Add PHP-FPM base image
FROM php:8.0-fpm

WORKDIR /var/www/html

# Install your extensions
# To connect to MySQL, add mysqli
RUN apt-get update && \
    apt-get install -y libpng-dev && \
    docker-php-ext-install mysqli && docker-php-ext-enable mysqli
    
EXPOSE 80

