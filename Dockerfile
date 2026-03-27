# ============================================================
# Stage 1: Node.js binary (ambil dari image resmi)
# ============================================================
FROM node:20-slim AS node_base

# ============================================================
# Stage 2: Main image - PHP 8.2 FPM
# ============================================================
FROM php:8.2-fpm

# --- Copy Node.js dari stage node_base (BUKAN langsung dari node:20-slim) ---
# Cara ini lebih aman karena PATH dan symlink sudah terbentuk dengan benar
COPY --from=node_base /usr/local/bin/node /usr/local/bin/node
COPY --from=node_base /usr/local/bin/npm  /usr/local/bin/npm
COPY --from=node_base /usr/local/bin/npx  /usr/local/bin/npx
COPY --from=node_base /usr/local/lib/node_modules /usr/local/lib/node_modules

# Pastikan symlink npm mengarah ke file yang benar
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && node -v \
    && npm -v

# ============================================================
# Install dependensi sistem
# ============================================================
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg \
    ca-certificates \
    sudo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ============================================================
# Install PHP extensions
# ============================================================
RUN docker-php-ext-install pdo pdo_mysql mbstring xml zip

# ============================================================
# Install Composer
# ============================================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ============================================================
# Set working directory & copy project
# ============================================================
WORKDIR /var/www/html

COPY . .

# ============================================================
# Setup Permission Laravel
# ============================================================
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN mkdir -p storage/app/fet-results \
    && chown -R www-data:www-data storage/app/fet-results \
    && chmod -R 775 storage/app/fet-results

# ============================================================
# Sinkronkan UID/GID www-data dengan user Linux host (UID 1000)
# ============================================================
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# ============================================================
# Startup script untuk symlink + jalankan php-fpm
# ============================================================
RUN printf '#!/bin/sh\nmkdir -p /var/www/watcher\nln -sf /mnt/fet-results /var/www/watcher/fet-results\nexec php-fpm\n' \
    > /usr/local/bin/startup \
    && chmod +x /usr/local/bin/startup

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/startup"]