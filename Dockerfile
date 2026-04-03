# ============================================================
# Stage 1: Node.js binary
# ============================================================
FROM node:20-slim AS node_base

# ============================================================
# Stage 2: Main image - PHP 8.2 FPM + Nginx
# ============================================================
FROM php:8.2-fpm

# Copy Node.js
COPY --from=node_base /usr/local/bin/node /usr/local/bin/node
COPY --from=node_base /usr/local/bin/npm  /usr/local/bin/npm
COPY --from=node_base /usr/local/bin/npx  /usr/local/bin/npx
COPY --from=node_base /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && node -v && npm -v

# Install sistem + nginx
RUN apt-get update && apt-get install -y \
    libpq-dev libonig-dev libxml2-dev libzip-dev \
    zip unzip git curl gnupg ca-certificates sudo nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring xml zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Permissions
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Nginx config
RUN echo 'server { \n\
    listen ${PORT}; \n\
    server_name _; \n\
    root /var/www/html/public; \n\
    index index.php index.html; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        include fastcgi_params; \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Startup script
RUN printf '#!/bin/sh\n\
# Jalankan migration\n\
php /var/www/html/artisan migrate --force\n\
php /var/www/html/artisan db:seed --force\n\
php /var/www/html/artisan storage:link\n\
php /var/www/html/artisan config:cache\n\
php /var/www/html/artisan route:cache\n\
php /var/www/html/artisan view:cache\n\
# Ganti port nginx sesuai Railway\n\
sed -i "s/listen \${PORT}/listen ${PORT:-80}/" /etc/nginx/sites-available/default\n\
# Start php-fpm\n\
php-fpm -D\n\
# Start nginx\n\
nginx -g "daemon off;"\n' \
    > /usr/local/bin/startup && chmod +x /usr/local/bin/startup

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/startup"]
