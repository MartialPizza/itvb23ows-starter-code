FROM php:8.3-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apachectl restart

COPY ./ /hive

WORKDIR /hive/php/src

EXPOSE 3000

CMD ["php", "-S", "0.0.0.0:3000"]