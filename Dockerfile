FROM php:7.2-apache
RUN docker-php-ext-install pdo
COPY index.php /var/www/html/
COPY config.php /var/www/html/
