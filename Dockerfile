# Use the official PHP runtime as a parent image
FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache --update \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    git \
    python3 \
    py3-pip \    
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/cache/apk/*

# Set the working directory in the container
WORKDIR /var/www

# Copy the current directory contents into the container
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Expose the port the app runs on
EXPOSE 443

# Set environment variable for production
ENV APP_ENV=debug

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Run artisan optimize during the container startup
CMD ["sh", "-c", "php artisan optimize && php artisan serve --host=0.0.0.0 --port=443"]

