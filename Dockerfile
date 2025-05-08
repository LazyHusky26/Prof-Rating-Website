FROM php:8.2-apache

RUN echo 'DirectoryIndex landing.html' > /etc/apache2/conf-available/custom-directory-index.conf \
 && a2enconf custom-directory-index

COPY . /var/www/html/

EXPOSE 80
