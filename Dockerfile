FROM php:8.4-fpm

# instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    nodejs \
    npm

# instalar extensões PHP necessárias para Laravel
RUN docker-php-ext-install zip

# instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# definir o diretório de trabalho
WORKDIR /var/www

# copiar os arquivos do projeto para o contêiner
COPY . .

# expor a porta do PHP-FPM
EXPOSE 9000
