# Use official PHP with Apache
FROM php:8.1-apache

# Install mysqli extension for PHP-MySQL connection
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (useful for clean URLs)
RUN a2enmod rewrite

# Copy project files into the Apache web root
COPY . /var/www/html/

# Set proper permissions for uploads folder
RUN chmod -R 777 /var/www/html/uploads

# Expose port 80 (Apache default)
EXPOSE 80
