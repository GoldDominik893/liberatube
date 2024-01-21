FROM php:8.0-apache

RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

COPY ./ /var/www/html/

EXPOSE 80/tcp
EXPOSE 443/tcp