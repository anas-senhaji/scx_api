FROM php:8.2.0-apache
# FROM php:8.0.2-apache
# FROM php:7.4.0-apache

RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
# TEMP
RUN echo "memory_limit = -1\n" >> /usr/local/etc/php/php.ini  
RUN echo "extension=pdo_pgsql\n" \
    "extension=pgsql\n" \
    >> /usr/local/etc/php/php.ini

RUN a2enmod rewrite headers deflate

# install necessary extentions
RUN apt-get update -y && apt-get install -y libpng-dev git libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install gd
RUN docker-php-ext-install sockets


# install pgsql
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# setup a work directory
WORKDIR /var/www/html

# install dependencies
#COPY composer.json ./

# COPY . ./

# RUN composer install --no-scripts

# RUN composer dump-autoload --optimize  --no-scripts

# RUN php artisan cache:clear

COPY composer.json ./

RUN composer install --no-scripts --no-autoloader

COPY . ./

#RUN cp .env.develop .env

RUN composer dump-autoload --optimize  --no-scripts



RUN rm /etc/apache2/sites-available/000-default.conf && rm /etc/apache2/sites-enabled/000-default.conf
ADD vhost.docker.conf /etc/apache2/sites-available/vhost.docker.conf
RUN a2ensite vhost.docker.conf

RUN chmod -R 777 .


## generate a storage link

# RUN php artisan storage:link



# RUN php artisan migrate --seed

# RUN php artisan elastic:migrate:fresh
# RUN php artisan optimize:clear
# RUN php artisan storage:link

# RUN chown -R www-data:www-data ./ \
#     && a2enmod rewrite
# COPY entry-point.sh /entry-point.sh
# RUN chmod +x /entry-point.sh

RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p storage/framework/cache
RUN chmod -R 775 storage/framework
RUN chown -R www-data:www-data storage/framework
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80

USER www-data

# CMD bash /entry-point.sh