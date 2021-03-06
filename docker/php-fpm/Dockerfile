FROM php:7.1-fpm

RUN \
  apt-get update && \
  apt-get install -y \
      curl \
      git

RUN apt-get update && \
    apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev \
        zip \
        unzip && \
    docker-php-ext-configure gd --with-png-dir=/usr/include --with-jpeg-dir=/usr/include && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache && \
    docker-php-ext-install gd && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl


# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_9.x | bash && \
        apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

COPY symfony.pool.conf  /usr/local/etc/

RUN usermod -u 1000 www-data

EXPOSE 9000
CMD ["php-fpm", "-F"]