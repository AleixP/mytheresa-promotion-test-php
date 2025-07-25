FROM aleixp/php-8.4-test

RUN echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN export PATH="$PATH:/root/.composer/vendor/bin"

