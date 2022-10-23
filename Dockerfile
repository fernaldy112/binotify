FROM php:8.0-apache
COPY . /usr/src/binotify

RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
WORKDIR /usr/src/binotify

ENV APACHE_DOCUMENT_ROOT /usr/src/binotify/public_html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80