FROM php:8.2-fpm-alpine

ARG UID=1000
ARG GID=1000

RUN echo "📦 UID: ${UID}, GID: ${GID}"

# Установка системных зависимостей и библиотек
RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    mysql-client \
    bash \
    unzip \
    curl \
    git \
    shadow \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo_mysql zip

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Создание пользователя и группы (Alpine-совместимая команда)
RUN addgroup -g ${GID} phpuser && \
    adduser -u ${UID} -G phpuser -s /bin/sh -D phpuser

# Настройка PHP-FPM user/group
RUN sed -i "s/^user = .*/user = phpuser/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/^group = .*/group = phpuser/" /usr/local/etc/php-fpm.d/www.conf

USER phpuser

EXPOSE 9000

CMD ["php-fpm"]
