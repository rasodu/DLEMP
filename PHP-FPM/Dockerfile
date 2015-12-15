FROM php:5.6.16-fpm
RUN mkdir -p /usr/share/nginx/html
COPY htdocs /var/www/html
RUN chown -R www-data:www-data /usr/share/nginx/html && chmod -R 755 /usr/share/nginx/html
COPY php-fpm.conf /usr/local/etc/
CMD ["php-fpm"]
