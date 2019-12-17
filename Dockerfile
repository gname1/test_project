FROM php:7.1.3-apache
RUN docker-php-ext-install mysqli
COPY ./www/ /var/www/html/
CMD echo "ServerName localhost:80" >> /etc/apache2/apache2.conf
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
