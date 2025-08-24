FROM alpine:3.22

# LABEL maintainer="Taylor Otwell"

ARG WWWGROUP=sail
ARG NODE_VERSION=20
# ARG MYSQL_CLIENT="mariadb-client"
# ARG POSTGRES_VERSION=17

WORKDIR /var/www/html

ENV TZ=UTC
ENV PHPIZE_DEPS="autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c"

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN rm -f /etc/apk/repositories
RUN echo "https://mirror.yandex.ru/mirrors/alpine/v3.22/main" > /etc/apk/repositories
RUN echo "https://mirror.yandex.ru/mirrors/alpine/v3.22/community" >> /etc/apk/repositories

RUN apk update
RUN apk add --no-cache \
    bash \
    busybox \
    #    shadow \
    curl \
    #    ca-certificates \
    zip \
    unzip \
    procps \
    procps-ng \
    #    sqlite \
    libcap \
    libpng-dev \
    #    python3 \
    #    bind-tools \
    #    librsvg \
    ffmpeg
#    gnupg
# fswatch \
# gosu \
# PHP 8.4 и расширения
RUN apk add --no-cache \
    php84 \
    php84-common \
    php84-cli \
    php84-dev \
    php84-pdo \
    php84-pdo_pgsql \
    php84-pdo_sqlite \
    php84-pdo_mysql \
    php84-gd \
    php84-curl \
    php84-imap \
    php84-mbstring \
    php84-openssl \
    php84-xml \
    php84-zip \
    php84-bcmath \
    php84-soap \
    php84-intl \
    php84-dom \
    php84-ldap \
    php84-msgpack \
    php84-tokenizer \
    php84-pcntl \
    php84-posix \
    php84-pecl-redis \
    php84-pecl-memcached \
    php84-pecl-imagick \
    php84-pecl-xdebug \
    php84-pecl-swoole
# Базы данных
# $MYSQL_CLIENT \
# postgresql$POSTGRES_VERSION-client \
# Node.js
# nodejs \
# npm \
# npm install -g npm \
# npm install -g pnpm \
# npm install -g bun \
# npm install -g yarn \
# curl -sS https://getcomposer.org/installer | php83 -- --install-dir=/usr/bin --filename=composer \
# apk del $PHPIZE_DEPS \
RUN rm -rf /var/cache/apk/* /tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php84

RUN addgroup -g 1000 -S sail
RUN adduser -S -D -H -u 1337 -G sail -s /bin/bash sail

COPY php.ini /etc/php84/conf.d/99-sail.ini

RUN if [ -f "/etc/ImageMagick-6/policy.xml" ]; then rm /etc/ImageMagick-6/policy.xml; fi

EXPOSE 80/tcp