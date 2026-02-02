FROM php:7.3-apache

RUN apt-get update && apt-get install -y     git     curl     zip     unzip     libpq-dev     libonig-dev     libxml2-dev     libzip-dev     libpng-dev     && docker-php-ext-install         pdo         pdo_pgsql         mbstring         zip         gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

RUN chown -R www-data:www-data /var/www/html     && chmod -R 755 /var/www/html/storage     && chmod -R 755 /var/www/html/bootstrap/cache
EXPOSE 80
