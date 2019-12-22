FROM php:7.4-fpm

RUN apt update
RUN apt -y install git unzip
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/www/log
RUN touch /var/www/dev.log
RUN chmod 775 -R /var/www/log

WORKDIR /var/www