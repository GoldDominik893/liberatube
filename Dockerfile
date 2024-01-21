# Use PHP 7.4 FPM
FROM php:8.0-fpm

# Install MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Copy your project files
COPY . /var/www/html/

# Expose port 7893
EXPOSE 7893

# Start PHP-FPM server
CMD ["php-fpm"]
