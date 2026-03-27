FROM node:22-slim AS node_base

FROM php:8.4-fpm AS base

ARG WWWUSER=1000
ARG WWWGROUP=1000
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 \
    libcap2-bin libpng-dev dnsutils librsvg2-bin fswatch ffmpeg nano \
    libzip-dev libjpeg-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd pdo pdo_mysql opcache bcmath sockets pcntl zip redis

COPY --from=node_base /usr/local/bin/node /usr/local/bin/node
COPY --from=node_base /usr/local/bin/npm  /usr/local/bin/npm
COPY --from=node_base /usr/local/bin/npx  /usr/local/bin/npx
COPY --from=node_base /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && node -v && npm -v

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY .docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

RUN mkdir -p /var/log/supervisor \
    && touch /var/log/supervisord.log /var/log/supervisord.err \
    && chown -R www-data:www-data /var/log/supervisor /var/log/supervisord.* \
    && chmod -R 777 /var/log/supervisor /var/log/supervisord.*

COPY .docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN groupmod -g ${WWWGROUP} www-data && \
    usermod -u ${WWWUSER} -g ${WWWGROUP} www-data

ENTRYPOINT ["/entrypoint.sh"]

FROM base AS dev
RUN install-php-extensions xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
CMD ["supervisord", "-c", "/etc/supervisord.conf"]

FROM base AS prod
COPY . /var/www
COPY .docker/supervisord.conf /etc/supervisord.conf
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
EXPOSE 9000
