FROM php:8.2-apache

# Copy files
COPY index.php /var/www/html/

# Enable apache mod_rewrite (optional)
RUN a2enmod rewrite

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80
