# Deployment Production — Asella CMS (Laravel 11 + Filament 3)

CMS ini menjadi sumber data untuk frontend React yang di-deploy di Netlify
(`https://travelumroh-v1.netlify.app`). Frontend memanggil API lewat HTTPS,
jadi **CMS wajib punya HTTPS juga** — API `http://` akan diblokir browser
sebagai _mixed content_.

Ringkasan arsitektur:

```
Browser ──https──> travelumroh-v1.netlify.app  (React SPA)
   │
   └──https──> https://cms.example.com/api/*    (Laravel, VPS)
                    └── /admin                 (Filament)
```

---

## 1. Yang perlu disiapkan

| Kebutuhan        | Keterangan                                   |
| ---------------- | -------------------------------------------- |
| VPS              | Ubuntu 22.04 / 24.04, min. 1 GB RAM          |
| Domain/subdomain | contoh `cms.example.com`, A record ke IP VPS |
| PHP              | 8.2 atau 8.3 + FPM                           |
| MySQL / MariaDB  | 8.0 / 10.6+                                  |
| Nginx + Certbot  | reverse proxy + SSL                          |
| Composer         | 2.x                                          |

Node.js **tidak** diperlukan di server — aset Filament sudah ter-bundle.

---

## 2. Install paket server

```bash
sudo apt update && sudo apt upgrade -y

sudo apt install -y nginx mysql-server unzip curl git \
  php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
  php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

> `php8.3-gd` wajib: dipakai `intervention/image` untuk mengolah upload gambar.

---

## 3. Database

```bash
sudo mysql -e "CREATE DATABASE asella_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'asella'@'localhost' IDENTIFIED BY 'GANTI_PASSWORD_KUAT';"
sudo mysql -e "GRANT ALL PRIVILEGES ON asella_cms.* TO 'asella'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

---

## 4. Ambil kode & konfigurasi

```bash
sudo mkdir -p /var/www/asella-cms
sudo chown -R $USER:$USER /var/www/asella-cms

# dari repo Git Anda
git clone <URL_REPO> /var/www/asella-cms
cd /var/www/asella-cms

composer install --no-dev --optimize-autoloader
cp deploy/env.production.example .env
```

Isi `.env` (nilai bertanda `TODO` di template):

```dotenv
APP_URL=https://cms.example.com        # WAJIB https
APP_DEBUG=false
DB_DATABASE=asella_cms
DB_USERNAME=asella
DB_PASSWORD=...                        # password dari langkah 3
FILESYSTEM_DISK=public                 # WAJIB, jangan "local"
SESSION_SECURE_COOKIE=true
CORS_ALLOWED_ORIGINS="https://travelumroh-v1.netlify.app"
```

Lalu:

```bash
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force
```

### Seed data awal (opsional)

`DatabaseSeeder` mengisi konten demo **dan** membuat user
`test@example.com` dengan password `password`. Jangan jalankan di
production apa adanya.

Bila hanya butuh 4 item Trust Bar default:

```bash
php artisan db:seed --class=TrustBarSeeder --force
```

### Membuat akun admin

```bash
php artisan tinker --execute='App\Models\User::create(["name"=>"Admin","email"=>"admin@domain-anda.com","password"=>bcrypt("PASSWORD_KUAT_ANDA")]);'
```

Lalu login di `https://cms.example.com/admin`. Ganti password dari menu
profil setelah login pertama.

### Permission

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

> `storage/app/public` harus bisa ditulis `www-data` agar upload dari
> Filament tersimpan dan bisa diakses lewat `/storage/...`.

---

## 5. Cache produksi

Jalankan setiap kali deploy (setelah `composer install` & migrate):

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

`config:cache` penting: config baru (`config/api.php`, `config/cors.php`)
baru terbaca setelah cache dibersihkan.

---

## 6. Nginx + SSL

```bash
sudo cp deploy/nginx.conf.example /etc/nginx/sites-available/asella-cms
sudo nano /etc/nginx/sites-available/asella-cms   # sesuaikan domain & path
sudo ln -s /etc/nginx/sites-available/asella-cms /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

Terbitkan sertifikat:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d cms.example.com
```

Certbot akan mengisi `ssl_certificate` dan menambahkan redirect HTTPS.
Perpanjangan otomatis sudah aktif lewat systemd timer.

---

## 7. Hubungkan frontend Netlify

Di dashboard Netlify → **Site configuration → Environment variables**, tambahkan:

| Key                 | Value                     |
| ------------------- | ------------------------- |
| `VITE_API_BASE_URL` | `https://cms.example.com` |

Lalu **Deploys → Trigger deploy → Clear cache and deploy site**.

Tanpa variabel ini, build akan memakai fallback `http://localhost:8000`
dan seluruh halaman kosong karena request gagal.

`VITE_SITE_URL` opsional — isi bila suatu saat memasang domain custom
(mis. `https://asellatravel.id`) agar canonical & Open Graph menunjuk ke
domain tersebut. Default-nya `https://travelumroh-v1.netlify.app`.

---

## 8. Verifikasi

Dari mesin mana pun:

```bash
# Health check Laravel
curl -I https://cms.example.com/up
# -> HTTP/2 200

# API mengembalikan data
curl https://cms.example.com/api/trust-bars

# CORS untuk origin Netlify
curl -I -H "Origin: https://travelumroh-v1.netlify.app" \
  https://cms.example.com/api/trust-bars
# -> access-control-allow-origin: https://travelumroh-v1.netlify.app

# Preflight (dipanggil browser sebelum GET lintas-origin)
curl -i -X OPTIONS \
  -H "Origin: https://travelumroh-v1.netlify.app" \
  -H "Access-Control-Request-Method: GET" \
  https://cms.example.com/api/trust-bars
# -> HTTP/2 204 + Access-Control-Allow-Origin
```

Cek juga di browser:

1. Buka `https://cms.example.com/admin` → login.
2. Upload gambar di salah satu paket → buka URL gambar, harus `https://` dan tampil.
3. Buka frontend Netlify → data CMS muncul (Trust Bar, paket, testimoni).
4. Di DevTools → Network, tidak ada request yang diblokir CORS / mixed content.

---

## 9. Update / deploy berikutnya

```bash
cd /var/www/asella-cms
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
sudo chown -R www-data:www-data storage bootstrap/cache
```

Atau gunakan `deploy/deploy.sh` (sesuaikan variabel di bagian atas file).

---

## 10. Troubleshooting

| Gejala                                       | Penyebab & solusi                                                                                               |
| -------------------------------------------- | --------------------------------------------------------------------------------------------------------------- |
| `blocked by CORS policy`                     | Origin tidak terdaftar. Tambahkan di `CORS_ALLOWED_ORIGINS` lalu `php artisan config:cache`.                    |
| `Mixed Content: ... was loaded over HTTP`    | `APP_URL` masih `http://`, atau Nginx belum mengirim `HTTPS`. Perbaiki `APP_URL` + baris `fastcgi_param HTTPS`. |
| Gambar 404 / tidak tampil                    | `FILESYSTEM_DISK` bukan `public`, atau `php artisan storage:link` belum dijalankan.                             |
| Gambar tampil tapi URL `http://`             | `APP_URL` salah / `config:cache` belum dijalankan.                                                              |
| Halaman `/admin` redirect loop               | `SESSION_SECURE_COOKIE=true` tapi akses lewat HTTP, atau `TRUSTED_PROXIES` tidak mencakup proxy.                |
| `419 Page Expired` saat login                | Cookie sesi tidak terkirim: cek `SESSION_DOMAIN`, `SESSION_SECURE_COOKIE`, dan HTTPS.                           |
| `500` setelah deploy                         | Cek `storage/logs/laravel.log`; biasanya permission `storage`/`bootstrap/cache`.                                |
| Frontend kosong, request ke `localhost:8000` | `VITE_API_BASE_URL` belum diset di Netlify → redeploy.                                                          |
| `429 Too Many Requests`                      | Rate limit API (default 120/menit per IP). Naikkan lewat `API_RATE_LIMIT`.                                      |

### Kalau memakai Cloudflare

Set `TRUSTED_PROXIES="*"` di `.env` agar header `X-Forwarded-Proto` dari
Cloudflare dipercaya. Tanpa itu Laravel menganggap request masih HTTP.
