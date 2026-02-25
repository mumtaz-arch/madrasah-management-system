# PONSPES - Deployment Guide

## System Requirements

### Server Requirements
- PHP >= 8.2
- MySQL >= 8.0 / MariaDB >= 10.4
- Composer >= 2.0
- Node.js >= 18.x
- NPM >= 9.x

### PHP Extensions
- BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## Installation Steps

### 1. Clone Repository
```bash
git clone [your-repository-url] ponspes
cd ponspes
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure .env
```env
APP_NAME="PONSPES"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ponspes_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Database Setup
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6. Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## Web Server Configuration

### Apache (.htaccess)
The `.htaccess` file is included in `/public` directory.

### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/ponspes/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ponspes.test | password |

> ⚠️ **Change default passwords immediately after deployment!**

---

## Maintenance Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Check routes
php artisan route:list

# Queue worker (if using queues)
php artisan queue:work
```

---

## Troubleshooting

### Storage Permission Issues
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Verify `.env` file exists and is configured
- Run `php artisan config:cache`

### Assets Not Loading
```bash
php artisan storage:link
npm run build
```
