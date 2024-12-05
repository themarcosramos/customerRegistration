# Use a imagem base do PHP 7.1 com Apache
FROM php:7.1-apache

# Atualize o sistema e instale dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo_mysql mbstring gd

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar o diretório público do Laravel
ARG APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar o mod_rewrite para o Apache
RUN a2enmod rewrite

# Definir diretório de trabalho
WORKDIR /var/www/html
