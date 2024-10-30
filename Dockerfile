FROM php:8.2-fpm

# Installer les extensions nécessaires, y compris pdo_pgsql pour PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl \
    unzip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le contenu de l'application
COPY . /var/www/symfony

# Définir le répertoire de travail
WORKDIR /var/www/symfony
