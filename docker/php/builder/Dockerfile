FROM aleixp/php-8.4-base:8.4

ARG COMPOSER_VERSION=2.8.1
ARG XDEBUG_CLIENT_HOST
ENV COMPOSER_ALLOW_SUPERUSER=1


# Install Composer
RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION}
RUN export PATH="$PATH:$HOME/.composer/vendor/bin"

RUN usermod -u 1000 www-data
RUN usermod -a -G www-data root
RUN mkdir -p /var/www
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer
