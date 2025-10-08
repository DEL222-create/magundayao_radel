FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y unzip libzip-dev libpng-dev libonig-dev libxml2-dev git \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Enable Apache rewrite
RUN a2enmod rewrite

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]