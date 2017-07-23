FROM php:7.0-apache

RUN apt-get update \
 && apt-get install -y git vim zlib1g-dev \
 && docker-php-ext-install zip \
 && a2enmod rewrite \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -
RUN apt-get install -y nodejs

RUN pecl install xdebug

ENV DIR_PATH /var/www/auto

COPY ./docker/dev/000-default.conf /etc/apache2/sites-enabled/000-default.conf

COPY . $DIR_PATH

WORKDIR $DIR_PATH

RUN chmod 744 ./docker/wait-for-it.sh