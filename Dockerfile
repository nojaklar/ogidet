# Create an image base on php:7.4-apache (https://hub.docker.com/_/php)
FROM php:7.4-apache 
# Install the extension mysqli
RUN docker-php-ext-install mysqli