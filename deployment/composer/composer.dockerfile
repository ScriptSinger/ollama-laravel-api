# docker/composer.Dockerfile
FROM php:8.2-cli-alpine

ARG UID=1000
ARG GID=1000

# Установка системных пакетов и PHP-расширений
RUN apk add --no-cache \
    icu-dev icu-libs \
    libzip-dev \
    oniguruma-dev \
    unzip \
    curl \
    git \
    bash \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip pdo_mysql

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Создание пользователя
RUN addgroup -g ${GID} composer && \
    adduser -u ${UID} -G composer -s /bin/bash -D composer

USER composer

WORKDIR /var/www/html
