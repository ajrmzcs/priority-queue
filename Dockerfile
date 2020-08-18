FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    supervisor \
    sudo \
    procps

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -p "$(openssl passwd -1 devuser)" -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Supervisor
RUN mkdir -p /var/log/supervisor && chown -R $user:$user /var/log/supervisor
COPY ./run/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chown -R $user:$user /etc/supervisor/conf.d/supervisord.conf && chmod 755 /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www

USER root
