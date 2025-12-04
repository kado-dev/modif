# Fix Database Connection

## Status

✅ **getEnvFromFile() sudah bekerja dengan benar** - bisa membaca `.env` file

## Masalah

Error: `No such file or directory` di `mysqli_driver.php:201`

Ini adalah error koneksi database, bukan error file. Kemungkinan:
1. Database `laravel` tidak ada
2. Username/password salah
3. Database server tidak running

## Solusi

### Option 1: Update .env dengan database yang benar

Jika ingin menggunakan database yang sama dengan production:

```env
DB_HOST=localhost
DB_USERNAME=dblinggarpkmuser
DB_PASSWORD=Tomi481216!
DB_DATABASE=dblinggarpkm
DB_DRIVER=mysqli
```

### Option 2: Buat database baru

Jika ingin menggunakan database baru untuk development:

```bash
# Login ke MySQL
mysql -u root

# Buat database
CREATE DATABASE apibaru_dev CHARACTER SET utf8 COLLATE utf8_general_ci;

# Buat user (optional)
CREATE USER 'apibaru_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON apibaru_dev.* TO 'apibaru_user'@'localhost';
FLUSH PRIVILEGES;
```

Kemudian update `.env`:
```env
DB_HOST=localhost
DB_USERNAME=apibaru_user
DB_PASSWORD=password
DB_DATABASE=apibaru_dev
DB_DRIVER=mysqli
```

### Option 3: Import database dari production

```bash
# Export dari production (jika ada akses)
mysqldump -u dblinggarpkmuser -p dblinggarpkm > dblinggarpkm.sql

# Import ke database baru
mysql -u root apibaru_dev < dblinggarpkm.sql
```

## Testing

Setelah update `.env`, test koneksi:

```bash
# Test via PHP
php test_db.php

# Test via curl
curl http://apibaru.test
```

## Catatan

- Pastikan MySQL/MariaDB service running
- Pastikan user memiliki permission untuk database
- Check firewall jika menggunakan remote host

