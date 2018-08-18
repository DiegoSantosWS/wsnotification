FROM php:7.1-apache

LABEL MAINTAINER="DIEGO SANTOS <diegosantosws1@gmail.com>"

COPY . .
#COPY vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /src/github.com/DiegoSantosWS/wsitebrasil/wsnotification

RUN apt-get update -y
RUN a2enmod rewrite
RUN a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip


# PHP extensions deps
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        #libpng12-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        unixodbc-dev \
        libxml2-dev \
        libaio-dev \
        libmemcached-dev \
        freetds-dev \
	    libssl-dev \
	    openssl

# PHP extensions
RUN docker-php-ext-configure pdo_dblib --with-libdir=/lib/x86_64-linux-gnu \
    && pecl install sqlsrv \
    && pecl install pdo_sqlsrv \
    && pecl install memcached 

RUN docker-php-ext-install \
            iconv \
            mbstring \
            intl \
            mcrypt \
            #pgsql \
            mysqli \
            #pdo_pgsql \
            pdo_mysql \
            pdo_dblib \
            soap \
            sockets \
            zip \
            pcntl \
            ftp

RUN docker-php-ext-enable \
            sqlsrv \
            pdo_sqlsrv \
            memcached

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN service apache2 restart