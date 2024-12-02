FROM php:8.2-apache

RUN apt update && apt install -y \
    git \
    libzip-dev \
    libsqlite3-dev \
    sqlite3

RUN docker-php-ext-install pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite

RUN useradd -s /bin/bash php
