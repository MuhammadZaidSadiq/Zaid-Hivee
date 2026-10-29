FROM php:8.1-fpm

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN mkdir -p /var/www/html/uploads && chmod -R 777 /var/www/html/uploads

# TASK 1: Declare a Docker Volume for uploads folder
# This ensures uploaded book images persist even if container is deleted
VOLUME /var/www/html/uploads

EXPOSE 9000
