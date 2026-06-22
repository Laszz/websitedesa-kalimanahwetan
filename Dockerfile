FROM serversideup/php:8.4.1-fpm-nginx AS base

USER root

# Install semua PHP extensions yang dibutuhkan Laravel
RUN install-php-extensions \
    exif \
    gd \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    zip \
    bcmath \
    pcntl \
    intl \
    opcache

# Install Node.js
ARG NODE_VERSION=20.18.0
ENV PATH=/usr/local/node/bin:$PATH
RUN curl -sL https://github.com/nodenv/node-build/archive/master.tar.gz | tar xz -C /tmp/ && \
    /tmp/node-build-master/bin/node-build "${NODE_VERSION}" /usr/local/node && \
    corepack enable && \
    rm -rf /tmp/node-build-master

# ============================================
# BUILD STAGE - Install dependencies as root
# ============================================
FROM base AS builder

USER root

WORKDIR /var/www/html

# Copy composer files FIRST (leverage Docker cache)
COPY --chown=www-data:www-data composer.json composer.lock* ./

# Install composer dependencies as root (avoid permission issues)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Copy rest of app
COPY --chown=www-data:www-data . .

# Create storage directory
RUN mkdir -p storage/app/public && \
    chown -R www-data:www-data storage bootstrap/cache

# Build assets
RUN npm install && \
    npm run build && \
    rm -rf node_modules

# ============================================
# FINAL STAGE - Clean runtime image
# ============================================
FROM base

ENV SSL_MODE="off"
ENV AUTORUN_ENABLED="true"
ENV PHP_OPCACHE_ENABLE="1"
ENV HEALTHCHECK_PATH="/up"

WORKDIR /var/www/html

# Copy everything from builder stage
COPY --from=builder --chown=www-data:www-data /var/www/html /var/www/html

# Final permission fix
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data