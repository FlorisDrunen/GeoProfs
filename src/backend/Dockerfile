# Use the official PHP image with Composer installed
FROM php:8.2-fpm

# Set the author label
LABEL authors="sinta"

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer by copying from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . .

# Install Laravel dependencies
RUN composer install

# Expose port 8000
EXPOSE 8000

# Start the Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
