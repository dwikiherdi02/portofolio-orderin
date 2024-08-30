# FROM nginx:latest AS base
FROM php:8.2.19-fpm AS base

ENV COMPOSER_ALLOW_SUPERUSER=1

# Get composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Get NodeJS
COPY --from=node:20.16-slim /usr/local/bin /usr/local/bin

# Get npm
COPY --from=node:20.16-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN apt-get update && apt-get --no-install-recommends -y install \
  zip \
  unzip \
  nano \
  nginx \
  g++ \
  autoconf \
  zlib1g-dev \
  libfreetype-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libzip-dev \
  supervisor

RUN docker-php-ext-install pdo_mysql

RUN pecl install redis && docker-php-ext-enable redis

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install zip

# RUN pecl install grpc && docker-php-ext-enable grpc

# RUN pecl install protobuf && docker-php-ext-enable protobuf

COPY ./.deploy/nginx /etc/nginx

COPY ./.deploy/php/php.ini /usr/local/etc/php/php.ini

COPY ./.deploy/supervisor/supervisord.conf.dev /etc/supervisor/conf.d/supervisord.conf

ARG WORKDIR=/var/www/html

WORKDIR ${WORKDIR}

COPY ./src /var/www/html

ARG USER=www-data

# Use "adduser -D ${USER}" for alpine based distros
# RUN useradd -D ${USER};

# Give write access
# RUN chown -R ${USER}:${USER} ${WORKDIR}/public ${WORKDIR}/storage ${WORKDIR}/bootstrap/cache;

RUN \
  # Use "adduser -D ${USER}" for alpine based distros
  useradd -D ${USER}; \
  # Give write access to /data/caddy and /config/caddy
  chown -R ${USER}:${USER} ${WORKDIR}/public ${WORKDIR}/storage ${WORKDIR}/bootstrap/cache

# Command to run service nginx & php-fpm when the container start
# CMD ["/bin/bash", "-c", "service nginx start && php-fpm"]
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/conf.d/supervisord.conf"]