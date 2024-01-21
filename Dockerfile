FROM php:8.0-apache

RUN apt-get update && \
    apt-get install -y default-mysql-client && \
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli

WORKDIR /var/www/html

COPY ./ /var/www/html/

COPY ./database.sql /docker-entrypoint-initdb.d/

EXPOSE 7893