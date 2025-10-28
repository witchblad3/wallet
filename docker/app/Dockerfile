FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
      bash git curl libpq-dev postgresql-dev oniguruma-dev icu-dev \
  && docker-php-ext-install pdo pdo_pgsql intl \
  && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN docker-php-ext-enable opcache || true

 RUN addgroup -g 1000 app && adduser -G app -u 1000 -D app
CMD ["php-fpm", "-F"]
