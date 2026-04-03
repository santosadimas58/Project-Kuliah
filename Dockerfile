FROM node:20-slim AS node_base

FROM php:8.2-fpm

COPY --from=node_base /usr/local/bin/node /usr/local/bin/node
COPY --from=node_base /usr/local/bin/npm  /usr/local/bin/npm
COPY --from=node_base /usr/local/bin/npx  /usr/local/bin/npx
COPY --from=node_base /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && node -v && npm -v

RUN apt-get update && apt-get install -y \
    libpq-dev libonig-dev libxml2-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip unzip git curl gnupg ca-certificates sudo nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN printf 'server {\n\
    listen %s;\n\
    server_name _;\n\
    root /var/www/html/public;\n\
    index index.php index.html;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \\.php$ {\n\
        include fastcgi_params;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    }\n\
}\n' '${PORT:-80}' > /etc/nginx/sites-available/default

RUN printf '#!/bin/sh\n\
php /var/www/html/artisan migrate --force\n\
php /var/www/html/artisan storage:link\n\
php /var/www/html/artisan config:cache\n\
php /var/www/html/artisan route:cache\n\
php /var/www/html/artisan view:cache\n\
sed -i "s/\${PORT:-80}/${PORT:-80}/" /etc/nginx/sites-available/default\n\
php-fpm -D\n\
nginx -g "daemon off;"\n' \
    > /usr/local/bin/startup && chmod +x /usr/local/bin/startup

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/startup"]
