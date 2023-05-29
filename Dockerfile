FROM php:7.4.28-apache-bullseye
COPY web/* /var/www/html/
COPY web/images /var/www/html/images/
COPY web/resources /var/www/html/resources/
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install sockets
CMD ["apache2ctl", "-D", "FOREGROUND"]
