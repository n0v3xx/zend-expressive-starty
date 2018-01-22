########################################################################################################################
### Define base image
########################################################################################################################

FROM ubuntu:16.04

########################################################################################################################
### Load build args provided by .env file and add user/group from your host
########################################################################################################################

ARG userId
ARG groupId

RUN groupadd --gid $groupId developer
RUN useradd --no-log-init --create-home --uid $userId --gid developer developer

# Set env specific configs
ENV DEBIAN_FRONTEND noninteractive

########################################################################################################################
### Install base packages and basic php extensions
########################################################################################################################

# Update core dependencies
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

# Update dependencies ready
RUN apt-get upgrade -y

# prepare and install php7.1 repo
RUN apt-get install -y software-properties-common python-software-properties
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-get update

# install all
RUN apt-get update && apt-get install -y --allow-unauthenticated \
        curl \
        htop \
        wget \
        git \
        unzip \
        vim \
        nano \
        libbz2-dev \
        libicu-dev \
        libmcrypt-dev \
        libzip-dev \
        mysql-client \
        libxml2-dev \
        supervisor \
        php7.1 \
        php7.1-fpm \
        php7.1-common \
        php7.1-curl \
        php7.1-mbstring \
        php7.1-soap \
        php7.1-xml \
        php7.1-mysql \
        php7.1-dev \
        php7.1-bz2 \
        php7.1-intl \
        php7.1-xdebug \
        php7.1-ldap \
        php7.1-memcache \
        php7.1-memcached \
        php7.1-apcu \
        php7.1-zip \
        php7.1-mcrypt

# cleanup
RUN apt-get clean -y

# ldap cert fix
RUN echo "TLS_REQCERT never" >> /etc/ldap/ldap.conf

########################################################################################################################
### php settings
########################################################################################################################

# copy docker.ini to the php-fpm configuration
COPY ./docker/template/php-fpm/docker.ini /etc/php/7.1/fpm/conf.d/99-docker.ini

# create a symlink from the php-fpm configuration to the php-cli configuration
RUN ln -s /etc/php/7.1/fpm/conf.d/99-docker.ini /etc/php/7.1/cli/conf.d/99-docker.ini

########################################################################################################################
### php-fpm configuration
########################################################################################################################

COPY ./docker/template/php-fpm/pool/pool.conf /etc/php/7.1/fpm/pool.d/pool.conf

RUN mkdir -p /run/php \
    && systemctl disable php7.1-fpm.service

########################################################################################################################
### Install MongoDb & Tideways Ext - ACHTUNG nur mit PHP 5.5 und höher
########################################################################################################################

# Tideways PHP Profiling Ext
# Github: https://github.com/tideways/php-profiler-extension
RUN apt-get install -y libcurl4-openssl-dev libpcre3-dev \
    && cd /usr/local/ \
    && git clone https://github.com/tideways/php-profiler-extension.git \
    && cd php-profiler-extension \
    && /usr/bin/phpize \
    && ./configure --with-php-config=/usr/bin/php-config \
    && make && make install

# copy tideways ext config
COPY ./docker/template/tideways/tideways.ini /etc/php/7.1/mods-available/tideways.ini

# enable extension
RUN ln -s /etc/php/7.1/mods-available/tideways.ini /etc/php/7.1/fpm/conf.d/20-tideways.ini \
    && ln -s /etc/php/7.1/mods-available/tideways.ini /etc/php/7.1/cli/conf.d/20-tideways.ini

########################################################################################################################
### Supervisor
########################################################################################################################

# copy supvisor config to /etc
COPY ./docker/template/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

# see http://tiborsimko.org/docker-running-multiple-processes.html
CMD ["/usr/bin/supervisord"]