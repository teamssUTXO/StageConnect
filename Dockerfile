# Utiliser l'image PHP officielle avec Apache
FROM php:8.1-apache

# Mettre à jour les dépôts et installer les dépendances nécessaires pour PDO et MySQL
RUN apt-get update
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier ton code source dans le conteneur
COPY . /var/www/html/

# Exposer le port 80 pour Apache
EXPOSE 80