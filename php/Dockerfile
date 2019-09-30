FROM php:7.2-fpm

WORKDIR /var/www/container

RUN apt-get update \
  && apt-get install -y \
  vim\
  zlib1g-dev\
  default-mysql-client \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  curl \
  cron \
  procps \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install zip pdo_mysql 


#Composer install
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php
RUN rm composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

#Vue nodejs & npm install
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
WORKDIR /var/www/container
RUN pwd
RUN ls
RUN npm install

#Vuex
# RUN npm install vuex --save
# RUN npm install axios --save
