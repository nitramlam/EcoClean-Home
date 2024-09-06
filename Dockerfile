FROM php:7.4-apache

# Installer l'extension mysqli
RUN docker-php-ext-install mysqli

# Copier le code source dans le conteneur
COPY ./code /var/www/html/
