FROM aleixp/php-8.4-builder

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

WORKDIR /var/www
