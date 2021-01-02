FROM php:7.3-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql \
&& pecl install xdebug-3.0.1 \
&& docker-php-ext-enable xdebug

ADD php.ini /usr/local/etc/php/php.ini
