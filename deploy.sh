#!/bin/bash

# Deploy Script
echo "Starting Deployment..."

# Install Dependencies
composer install --optimize-autoloader --no-dev

# Environment
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Maintenance Mode
php artisan down

# Migration
php artisan migrate --force

# Storage Link
php artisan storage:link

# Optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Bring Up
php artisan up

echo "Deployment Completed!"
