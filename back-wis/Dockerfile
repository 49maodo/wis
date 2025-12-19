# Dockerfile pour Laravel avec intl et PostgreSQL
FROM php:8.2-cli

# Installer les dépendances système nécessaires à Laravel et intl
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libicu-dev \
    && docker-php-ext-install pdo_pgsql zip exif pcntl bcmath gd intl

# Installer Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copier les fichiers du projet
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances du projet sans les devs
RUN composer install --optimize-autoloader --no-dev


# Exposer le port pour le serveur PHP
EXPOSE 8000

# Démarrer le serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
