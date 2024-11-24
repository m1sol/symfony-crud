# Используйте официальный образ PHP 8.2
FROM php:8.3-fpm

# Установите необходимые зависимости и утилиты
RUN apt-get update && apt-get install -y \
    libssl-dev \
    librabbitmq-dev \
    pkg-config \
    libtool \
    autoconf \
    build-essential \
    libpng-dev \
    nano \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    git \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql \
    gd
# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установите рабочую директорию
WORKDIR /var/www

# Скопируйте файлы зависимостей
COPY composer.json ./
COPY composer.lock ./

# Установите зависимости
RUN composer install --no-scripts

RUN #php bin/console cache:clear
RUN docker-php-ext-install pdo pdo_pgsql
# Скопируйте исходный код
COPY . .

# Убедитесь, что файл bin/console существует
RUN [ -f ./bin/console ] || (echo "Error: ./bin/console not found." && exit 1)

# Настройте Nginx или используйте встроенный PHP сервер
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]
