# Panduan Instalasi API Baru

## Langkah 1: Setup Environment

1. Copy file `.env.example` ke `.env`:

   ```bash
   cp .env.example .env
   ```

2. Edit file `.env` dan isi dengan konfigurasi yang sesuai:
   - Database credentials
   - API credentials (BPJS, Dukcapil)
   - Email configuration
   - Generate encryption key (32 karakter random)

## Langkah 2: Install Dependencies

Jika menggunakan composer:

```bash
composer install
```

## Langkah 3: Set Permissions

```bash
chmod -R 755 application/logs
chmod -R 755 application/cache
chmod 644 .env
```

## Langkah 4: Konfigurasi Web Server

### Apache (.htaccess)

Pastikan mod_rewrite enabled dan buat file `.htaccess`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

### Nginx

#### Untuk Laravel Herd (Development)

Laravel Herd otomatis mendeteksi folder project. Untuk setup manual, buat file konfigurasi Nginx di `~/.config/herd/config/nginx/`:

```nginx
server {
    listen 80;
    server_name apibaru.test;
    root /Users/dodisyaripudin/Documents/docs_ht/apibaru;
    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /Users/dodisyaripudin/Documents/docs_ht/apibaru/application/logs/error.log;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/Users/dodisyaripudin/.config/herd/valet.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
    }

    location ~ /\. {
        deny all;
    }
}
```

**Atau gunakan cara otomatis Herd:**

1. Pastikan folder `apibaru` ada di path yang di-scan Herd
2. Herd akan otomatis membuat virtual host: `apibaru.test`
3. Jika perlu custom domain, edit konfigurasi Herd

#### Untuk Nginx Standar (Production)

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

## Langkah 5: Testing

1. Test koneksi database:

   - Akses endpoint yang memerlukan database
   - Check error logs jika ada masalah

2. Test authentication:

   ```bash
   curl -X GET "https://yourdomain.com/apibaru/auth" \
     -H "X-Username: your_username" \
     -H "X-Password: your_password"
   ```

3. Test API endpoint:
   ```bash
   curl -X GET "https://yourdomain.com/apibaru/pasienrj/2024-01-01/P0001" \
     -H "keyid: your_api_key"
   ```

## Troubleshooting

### Error: Database connection failed

- Check credentials di `.env`
- Pastikan database server running
- Check firewall rules

### Error: Class 'REST_Controller' not found

- Pastikan library REST_Controller.php ada di `application/libraries/`
- Check autoload configuration

### Error: Token expired

- Default expire: 30 menit
- Dapat diubah di `.env`: `TOKEN_EXPIRE_MINUTES=30`

### Error: API key not found

- Pastikan API key sudah di-approve di database
- Check header `keyid` di request

## Security Checklist

- [ ] File `.env` tidak di-commit ke git
- [ ] Encryption key sudah digenerate (32 karakter random)
- [ ] Database credentials aman
- [ ] File permissions sudah benar
- [ ] Error logging enabled
- [ ] HTTPS enabled (untuk production)

## Next Steps

1. Review dan perbaiki controller Antrean (lihat `INSTRUKSI_PERBAIKAN_ANTREAN.md`)
2. Review controller REST lainnya untuk SQL injection
3. Setup monitoring dan logging
4. Implement rate limiting
5. Setup backup database
