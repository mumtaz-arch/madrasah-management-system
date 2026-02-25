# Production Checklist — Sekolah System

## 🚀 Pre-Deployment Checks
- [ ] **Environment Configuration**: Ensure `.env` is set to `APP_ENV=production` and `APP_DEBUG=false`.
- [ ] **Database Backup**: Run `php artisan backup:run` before deploying new code.
- [ ] **Space Check**: Ensure server has at least 1GB free space for build artifacts.

## 🔒 Security Hardening
- [ ] **SSL Certificate**: Ensure HTTPS is active (managed by Laragon/Server provider).
- [ ] **File Permissions**:
  - `storage` and `bootstrap/cache`: 775/777
  - All other files: 644
- [ ] **App Key**: Confirm `APP_KEY` is set and secret.
- [ ] **XSS/CSRF**: Middleware `SecurityHeaders` is active.

## ⚡ Performance Optimization
- [ ] **Route Cache**: `php artisan route:cache`
- [ ] **Config Cache**: `php artisan config:cache`
- [ ] **View Cache**: `php artisan view:cache`
- [ ] **Event Cache**: `php artisan event:cache`
- [ ] **Autoloader**: `composer install --optimize-autoloader --no-dev`
- [ ] **Frontend Build**: `npm run build` (confirm `public/build` exists)

## 🔄 Routine Maintenance (SaaS Readiness)
- [ ] **Queue Worker**: Ensure `php artisan queue:work` is running (Supervisor/Systemd).
- [ ] **Scheduler**: Ensure cron job `php artisan schedule:run` is active (every minute).
- [ ] **Log Rotation**: Check `storage/logs` size periodically.

## 🚨 Troubleshooting
- **500 Error**: Check `storage/logs/laravel.log`.
- **403 Forbidden**: Check file permissions or `RoleMiddleware`.
- **419 Page Expired**: Session timeout or CSRF token mismatch (clear browser cache).
