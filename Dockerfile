FROM php:7.2-apache
# For troubleshooting you might need these packages below
# RUN apt update
#RUN apt install mysql-client telnet net-tools iputils-ping vim -y
RUN docker-php-ext-install pdo_mysql
COPY index.php /var/www/html/
COPY config.php /var/www/html/
