# Utilise PHP 8.2 avec Apache
FROM php:8.2-apache

# Installe l'extension pour MySQL (PDO)
RUN docker-php-ext-install pdo pdo_mysql

# Active le module de réécriture d'URL
RUN a2enmod rewrite

# Copie tous tes fichiers dans le dossier web d'Apache
COPY . /var/www/html/

# Render va détecter le port automatiquement
EXPOSE 80