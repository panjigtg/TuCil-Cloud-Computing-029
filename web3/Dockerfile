FROM php:8.2-alpine

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev $PHPIZE_DEPS
# Copy files
COPY index.php /var/www/html/
COPY router.php /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# Expose port
EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]