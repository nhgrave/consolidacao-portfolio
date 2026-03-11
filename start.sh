#!/bin/bash

echo "Instalando dependências..."

composer install
npm ci

echo "Iniciando Vite..."
npm run dev &

echo "Iniciando Laravel..."
php artisan serve --host=0.0.0.0 --port=8000
