#!/bin/bash

echo "🚀 Starting Production Deployment..."

# 1. Pull latest code (if using git on server)
# git pull origin main

# 2. Install Dependencies
echo "📦 Installing Composer Dependencies..."
composer install --no-dev --optimize-autoloader

# 3. Optimize Config, Routes, and Views
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 4. Run Migrations
echo "🗄️ Running Migrations..."
php artisan migrate --force

# 5. Build Assets
echo "🎨 Building Frontend Assets..."
npm ci
npm run build

# 6. Clear unexpected cache
php artisan optimize

echo "✅ Deployment Complete! System is ready."
