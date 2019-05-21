FROM php:7.3-cli

RUN apt-get update &&  \
    apt-get install -y \
        git \
        unzip \
        zlib1g-dev \
        libzip-dev \
        libicu-dev \
            && docker-php-ext-install zip \
            && docker-php-ext-configure intl \
            && docker-php-ext-install intl

RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/app