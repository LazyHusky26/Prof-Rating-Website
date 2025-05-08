FROM php:8.2-apache

RUN echo 'DirectoryIndex landing.html' > /etc/apache2/conf-enabled/default-index.conf

COPY . /var/www/html/

EXPOSE 80
