FROM php:7.1.3-apache
RUN docker-php-ext-install mysqli
CMD echo "ServerName localhost" >> /etc/apache2/apache2.conf
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
