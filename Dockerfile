FROM php:7.4.25-cli-alpine

WORKDIR /home/app
#ADD composer.json /home/app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ONBUILD RUN composer update


# install PHP & nginx unit
RUN apk add --no-cache curl wget unzip
RUN apk update && apk upgrade
RUN apk add php7 php7-fpm php7-mysqli php7-opcache php7-gd php7-mysqli php7-zlib php7-curl php7-phar php7-json php7-mbstring 
RUN docker-php-ext-install pdo pdo_mysql 

EXPOSE 3004 3005 3006
