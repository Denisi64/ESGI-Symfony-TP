FROM php:8.2-fpm

# Install necessary extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy existing application directory contents
COPY . /var/www/symfony

# Set working directory
WORKDIR /var/www/symfony