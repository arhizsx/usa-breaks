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

# Set environment variables for production
ENV APP_ENV=production \
    APP_URL=https://usa-breaks-669015860017.us-central1.run.app/ \
    APP_DEBUG=false

# Expose the port the app runs on
EXPOSE 8080

# Set environment variable for production
ENV APP_ENV=debug

# Run Laravel's artisan serve command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]


RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
