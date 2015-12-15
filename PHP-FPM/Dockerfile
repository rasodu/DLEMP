FROM php:5.6.16-fpm
RUN mkdir -p /usr/share/nginx/mysite
COPY htdocs /usr/share/nginx/mysite
RUN chown -R www-data:www-data /usr/share/nginx/mysite && chmod -R 755 /usr/share/nginx/mysite
COPY php-fpm.conf /usr/local/etc/
CMD ["php-fpm"]
