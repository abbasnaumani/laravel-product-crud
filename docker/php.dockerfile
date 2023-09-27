#FROM php:8.0.24-fpm
FROM php:8.1.11-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    libonig-dev \
    libxml2-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libicu-dev \
    libmemcached-dev \
    jpegoptim optipng pngquant gifsicle \
    imagemagick \
    curl \
    zip \
    unzip \
    openssl \
    libzip-dev \
    autoconf pkg-config libssl-dev \
    nano

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install the PHP Memcached and Redis extension
#RUN pecl install memcached
#RUN pecl install redis

RUN apt-get update
#RUN apt-get install -y libzstd1
#RUN apt-get install -y openssl zip unzip git curl
#RUN apt-get install -y libzip-dev libonig-dev libicu-dev
#RUN apt-get install -y autoconf pkg-config libssl-dev
#RUN apt-get install -y nano
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo mysqli mbstring exif pcntl bcmath gd intl opcache
RUN docker-php-ext-configure gd --with-freetype --with-jpeg


# Copy OPcache configuration file
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

#RUN pecl install mongodb-1.14.0
RUN apt-get update -y
RUN apt-get -y install gcc make autoconf libc-dev pkg-config libssl-dev

#RUN pecl install mongodb-1.14.2
#RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
#RUN echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

#RUN docker-php-ext-enable memcached redis

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

CMD ["php-fpm"]
#touch /usr/local/etc/php/conf.d/ext-mongodb.ini
#pecl list
#extension="/usr/local/lib/php/extensions/no-debug-non-zts-20210902/mongodb.so"
#/usr/local/etc/php  pear config-set php_ini /usr/local/etc/php/php.ini
#/usr/local/etc/php  pecl config-set php_ini /usr/local/etc/php/php.ini

#/usr/local/etc/php  pear config-set php_ini /usr/local/etc/php/conf.d/ext-mongodb.ini
#/usr/local/etc/php  pecl config-set php_ini /usr/local/etc/php/conf.d/ext-mongodb.ini

#php --ri mongodb
