# Consolidação de Portifólio

....

## Requisitos para rodar o projeto

Docker

## Como rodar o projeto

```bash
# Copiar o .env.example
cp .env.example .env

# Remover o container caso precise
docker compose down

# Construir o container
docker compose build

# Rodar o container
docker compose up
```

## Para rodar os testes

Para rodar os testes o container precisa estar rodando

```bash
docker compose exec app php artisan test
```

## Caso precise rodar o php ou composer

```bash
# Acessar o container
docker compose exec app bash

# Executar o comando php ou composer, exemplo:
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```

## Stack

- Laravel 10.50
- PHP 8.4
- Inertia.js
- Vue.js 3
