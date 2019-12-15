FROM php:7.1.3-apache
RUN docker-php-ext-install mysqli
