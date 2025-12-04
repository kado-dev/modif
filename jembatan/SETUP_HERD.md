# Setup Laravel Herd untuk API Baru

## Cara 1: Otomatis (Recommended)

Laravel Herd otomatis mendeteksi folder project. Pastikan:

1. Folder project ada di path yang di-scan Herd (biasanya `~/Sites` atau custom path)
2. Herd akan otomatis membuat virtual host: `apibaru.test`
3. Akses via: `http://apibaru.test`

### Setup Custom Path (jika perlu)

Jika project tidak di `~/Sites`, tambahkan path ke Herd:

1. Buka Herd Settings
2. Pilih "Paths"
3. Tambahkan path: `/Users/dodisyaripudin/Documents/docs_ht/linggar2`
4. Herd akan scan folder `apibaru` dan membuat `apibaru.test`

## Cara 2: Manual Nginx Configuration

Jika perlu konfigurasi khusus, edit file Nginx Herd:

1. Buka terminal dan jalankan:

   ```bash
   open ~/.config/herd/config/nginx/
   ```

2. Buat file baru: `apibaru.test.conf`

3. Isi dengan konfigurasi berikut:

```nginx
server {
    listen 80;
    server_name apibaru.test;
    root /Users/dodisyaripudin/Documents/docs_ht/apibaru;
    index index.php;

    charset utf-8;

    # CodeIgniter routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Security - deny access to hidden files
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    # Deny access to system folder
    location ~ ^/(application|system)/ {
        deny all;
    }

    # PHP handler
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

    # Static files
    location ~* \.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt)$ {
        access_log off;
        expires 30d;
    }

    # Logs
    access_log off;
    error_log /Users/dodisyaripudin/Documents/docs_ht/apibaru/application/logs/nginx_error.log;

    # Max upload size
    client_max_body_size 100m;
}
```

4. Restart Herd:
   ```bash
   herd restart
   ```

## Cara 3: Symlink (Alternative)

Jika ingin menggunakan domain custom:

1. Buat symlink:

   ```bash
   cd ~/Sites
   ln -s /Users/dodisyaripudin/Documents/docs_ht/apibaru apibaru
   ```

2. Herd akan otomatis detect dan membuat `apibaru.test`

## Update Base URL di .env

Setelah setup, update file `.env`:

```env
APP_BASE_URL=http://apibaru.test/
```

## Testing

1. Test akses web:

   ```
   http://apibaru.test
   ```

2. Test API endpoint:

   ```bash
   curl -X GET "http://apibaru.test/auth" \
     -H "X-Username: your_username" \
     -H "X-Password: your_password"
   ```

3. Test REST endpoint:
   ```bash
   curl -X GET "http://apibaru.test/pasienrj/2024-01-01/P0001" \
     -H "keyid: your_api_key"
   ```

## Troubleshooting

### Error: 404 Not Found

1. Check apakah Herd sudah detect folder:

   ```bash
   herd paths
   ```

2. Check log Nginx:

   ```bash
   tail -f ~/.config/herd/log/nginx-error.log
   ```

3. Pastikan file `index.php` ada di root folder

### Error: 500 Internal Server Error

1. Check PHP error log:

   ```bash
   tail -f application/logs/log-*.php
   ```

2. Check permission:

   ```bash
   chmod -R 755 application/logs
   chmod -R 755 application/cache
   ```

3. Check `.env` file sudah ada dan benar

### Error: Database connection failed

1. Pastikan MySQL/MariaDB running di Herd
2. Check credentials di `.env`
3. Test koneksi:
   ```bash
   mysql -u your_user -p your_database
   ```

## Herd Commands

```bash
# Restart Herd
herd restart

# Check status
herd status

# List sites
herd links

# Open Herd dashboard
herd open
```

## Catatan

- Herd menggunakan PHP-FPM via Unix socket
- Path socket: `~/.config/herd/valet.sock`
- Default domain: `.test`
- Herd otomatis handle SSL untuk `.test` domains
