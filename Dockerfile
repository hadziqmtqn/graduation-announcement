# ============================================
# Dockerfile for EasyPanel - Stable PHP-FPM + Caddy (Debian Edition)
# ============================================
# Switching to Debian Bookworm for maximum network stability

FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    supervisor \
    gnupg \
    ca-certificates \
    apt-transport-https \
    gosu \
    && rm -rf /var/lib/apt/lists/*

# Install Caddy (Official Debian Repository)
RUN curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg && \
    curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list && \
    apt-get update && apt-get install -y caddy && \
    rm -rf /var/lib/apt/lists/*

# Install Node.js (Official NodeSource 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j2 \
        pdo_mysql \
        zip \
        gd \
        exif \
        bcmath \
        intl

# Install Composer
RUN curl -sS --retry 3 -L https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# --- CACHE OPTIMIZATION START ---
# Step 1: Copy only dependency files first with correct ownership
COPY --chown=www-data:www-data composer.json composer.lock ./

# Step 2: Install PHP dependencies (This layer is cached unless composer.json/lock changes)
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --ignore-platform-req=php

# Step 3: Copy NPM dependency files with correct ownership
COPY --chown=www-data:www-data package.json package-lock.json* ./

# Step 4: Install NPM dependencies
# We use an ARG to allow skipping this during dev if needed
ARG BUILD_ASSETS=true
RUN if [ "$BUILD_ASSETS" = "true" ] && [ -f "package.json" ]; then \
    npm install; \
    fi
# --- CACHE OPTIMIZATION END ---

# Copy application code (Everything else) with correct ownership
COPY --chown=www-data:www-data . .

# Step 5: Build Assets (Now that all files are copied)
RUN if [ "$BUILD_ASSETS" = "true" ] && [ -f "package.json" ]; then \
    npm run build; \
    fi

# Finish Composer setup (generate optimized autoloader)
RUN composer dump-autoload --optimize --no-dev

# Set permissions - ONLY for necessary folders
# Ini jauh lebih cepat dibanding chown -R ke seluruh folder
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure storage/framework/views is always writable (handles view compilation issues)
RUN mkdir -p /var/www/html/storage/framework/views && \
    chown -R www-data:www-data /var/www/html/storage/framework/views && \
    chmod -R 775 /var/www/html/storage/framework/views

# Copy Caddyfile
COPY docker/Caddyfile.easypanel.phpfpm /etc/caddy/Caddyfile

# Trik agar Laravel mendeteksi HTTPS (Mixed Content Fix) tanpa ubah kode PHP
RUN sed -i 's/php_fastcgi 127.0.0.1:9000/php_fastcgi 127.0.0.1:9000 {\n        env HTTPS on\n    }/g' /etc/caddy/Caddyfile

# Create supervisord config
RUN printf "[supervisord]\nnodaemon=true\nlogfile=/dev/null\nlogfile_maxbytes=0\n\n[program:php-fpm]\ncommand=php-fpm -F\nstdout_logfile=/dev/stdout\nstdout_logfile_maxbytes=0\nstderr_logfile=/dev/stderr\nstderr_logfile_maxbytes=0\n\n[program:caddy]\ncommand=caddy run --config /etc/caddy/Caddyfile --adapter caddyfile\nstdout_logfile=/dev/stdout\nstdout_logfile_maxbytes=0\nstderr_logfile=/dev/stderr\nstderr_logfile_maxbytes=0\n\n[program:laravel-worker]\ncommand=php /var/www/html/artisan queue:work --queue=high,default --sleep=3 --tries=3 --max-time=3600\nautostart=true\nautorestart=true\nuser=www-data\nstdout_logfile=/dev/stdout\nstdout_logfile_maxbytes=0\nstderr_logfile=/dev/stderr\nstderr_logfile_maxbytes=0\n" > /etc/supervisord.conf

# Expose port 80
EXPOSE 80

# Set entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Start supervisord
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]