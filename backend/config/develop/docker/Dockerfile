FROM composer AS composer-php

FROM php:8.4-apache

COPY ../../../ .
WORKDIR /var/www/html/backend

# copy composer
COPY --from=composer-php /usr/bin/composer /usr/bin/composer

# installing dependencies
RUN apt-get update && apt-get install -y \
	libzip-dev \
	zip \
	unzip \
	libpq-dev \
	zlib1g-dev \
    wget

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install \
	opcache \
	pdo \
	pdo_pgsql \
	pgsql \
	zip

# Config Fuse
RUN ln -snf /usr/share/zoneinfo/America/Recife /etc/localtime \
	&& echo "America/Recife" > /etc/timezone \
	&& dpkg-reconfigure -f noninteractive tzdata

RUN echo "date.timezone = America/Recife" >> /usr/local/etc/php/php.ini

## Apply permissions
RUN chown -R root:www-data /var/www &&  \
    chmod -R 775 /var/www/

# Modifying apache
RUN a2enmod rewrite
RUN addgroup --gid 1000 appuser; \
    adduser --uid 1000 --gid 1000 --disabled-password appuser; \
    adduser www-data appuser; \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf; \
    sed -i 's|/var/www/html|/var/www/html/backend/public|' /etc/apache2/sites-available/000-default.conf; \
    chown -R www-data:www-data /var/www/html/backend/public; \
    service apache2 restart;

# Installing and setting xdbug
RUN pecl install xdebug \
    && echo "[XDEBUG]" > /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "zend_extension=\"xdebug.so\"" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.client_host = 127.0.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini

# installing dockerize
ENV DOCKERIZE_VERSION=v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN rm -f /var/run/apache2/apache2.pid
