FROM php:8.4.5-fpm-bullseye

WORKDIR /var/www

RUN apt-get update && \
    apt-get -y --no-install-recommends install \
        git \
        unzip \
        zip \
        libzip-dev \
        libpng-dev && \
    docker-php-ext-install pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

COPY . .

EXPOSE 9000

CMD ["php-fpm"]
