FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    acl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    unzip \
    libcurl4-openssl-dev \
    libonig-dev \
    libicu-dev \
	libpng-dev \
	libtool \
    libwebp-dev \
	libxml2-dev \
	libzip-dev \
    git \
    supervisor \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install gd

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    zip \
    bcmath \
    ctype \
    curl \
    fileinfo \
    intl \
    mysqli \
    opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clean up unnecessary files
RUN apt-get clean && \
rm -rf /var/lib/apt/lists/*

RUN usermod -u 1000 www-data
RUN chmod -R 775 /var/www/
RUN chown -R 1000:1000 /var/www/

RUN mkdir -p /var/www/.composer && \
	chown -R www-data:www-data /var/www/.composer

USER www-data
