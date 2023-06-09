FROM php:8.0-apache
#COPY . /usr/src/binotify
COPY ./assets /usr/src/binotify/assets

RUN apt-get update && apt-get install -y libxml2-dev
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install soap
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-enable soap
RUN apt-get install -y ffmpeg
RUN apt-get install -y cron
RUN a2enmod rewrite
RUN a2enmod headers
RUN apachectl restart

USER root

WORKDIR /usr/src/binotify

ENV APACHE_DOCUMENT_ROOT /usr/src/binotify/public_html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chown -R root assets/music assets/image
RUN chmod -R 777 assets/music && chmod -R 777 assets/image

EXPOSE 80

CMD ["run"]