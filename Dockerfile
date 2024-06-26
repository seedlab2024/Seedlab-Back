# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Direccionamiento de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto
COPY . .

# Instala las dependencias de Laravel
RUN composer install

# Ejecuta los comandos de Passport -- unicamente cuando se usa passport
RUN php artisan passport:key --force \
    && php artisan passport:client --personal

# Expone el puerto en el que se ejecutará la aplicación -- puerto donde se ejecuta la aplicacion 
EXPOSE 8000


# Comando para iniciar el servidor de desarrollo -- el host 0.0.0.0 busca puertos abiertamente en el servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
