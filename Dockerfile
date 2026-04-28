FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install intl zip pdo pdo_mysql mbstring xml bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction
RUN npm install && npm run build
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000

