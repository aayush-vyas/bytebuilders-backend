FROM php:8.1-apache

WORKDIR /var/www/html/byte_builders

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



# Copy application files
COPY . /var/www/html/byte_builders/

RUN composer install --no-scripts

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
