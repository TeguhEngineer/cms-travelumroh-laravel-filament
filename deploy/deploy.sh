#!/usr/bin/env bash
#
# Asella CMS — script deploy untuk VPS.
# Jalankan dari root project:  bash deploy/deploy.sh
#
# Ubah nilai di bawah bila struktur server berbeda.
#
set -euo pipefail

APP_DIR="/var/www/asella-cms"
BRANCH="main"
PHP="php"
WEB_USER="www-data"

cd "$APP_DIR"

echo "==> Git pull ($BRANCH)"
git pull origin "$BRANCH"

echo "==> Composer install"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Migrasi database"
"$PHP" artisan migrate --force

echo "==> Rebuild cache"
"$PHP" artisan optimize:clear
"$PHP" artisan config:cache
"$PHP" artisan route:cache
"$PHP" artisan view:cache
"$PHP" artisan filament:optimize

echo "==> Perbaiki permission"
sudo chown -R "$WEB_USER":"$WEB_USER" storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "==> Selesai. Cek https://<domain-anda>/up"
