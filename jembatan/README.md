# API Baru - CodeIgniter 3 REST API

Aplikasi REST API CodeIgniter 3 dengan perbaikan keamanan untuk sistem kesehatan Puskesmas Linggar.

## Fitur Perbaikan Keamanan

1. **SQL Injection Prevention**
   - Semua query menggunakan Query Builder dengan parameter binding
   - Validasi input sebelum query
   - Sanitasi nama tabel

2. **Password Security**
   - Menggunakan bcrypt untuk password hashing
   - Backward compatibility dengan MD5 (untuk migrasi)
   - Tidak menyimpan password di session

3. **Environment Variables**
   - Semua credentials disimpan di file `.env`
   - File `.env` tidak di-commit ke git
   - Konfigurasi terpusat dan mudah diubah

4. **Token Security**
   - Token generation menggunakan cryptographically secure random bytes
   - Token disimpan dengan expire time
   - Tracking IP address dan user agent

5. **Input Validation**
   - Validasi format input (NIK, nomor kartu, tanggal)
   - XSS filtering
   - Sanitasi semua input

## Instalasi

1. Copy file `.env.example` ke `.env` dan isi dengan konfigurasi yang sesuai:
   ```bash
   cp .env.example .env
   ```

2. Edit file `.env` dan sesuaikan dengan environment Anda:
   - Database credentials
   - API credentials (BPJS, Dukcapil)
   - Email configuration
   - Encryption key

3. Install dependencies (jika menggunakan composer):
   ```bash
   composer install
   ```

4. Set permissions untuk folder logs dan cache:
   ```bash
   chmod -R 755 application/logs
   chmod -R 755 application/cache
   ```

## Struktur Aplikasi

```
apibaru/
├── application/
│   ├── config/          # Konfigurasi aplikasi
│   ├── controllers/     # REST Controllers
│   ├── models/          # Data models
│   ├── libraries/       # Custom libraries
│   ├── helpers/         # Helper functions
│   └── views/           # View files
├── system/              # CodeIgniter core
├── vendor/              # Composer dependencies
├── .env                 # Environment variables (tidak di-commit)
├── .env.example         # Template environment variables
└── index.php            # Entry point
```

## Endpoint API

### Authentication
- `GET /auth` - Get authentication token
  - Headers: `X-Username`, `X-Password`
  - Response: Token dengan expire time

### Pasien Rawat Jalan
- `GET /pasienrj/{tanggal}/{kodepuskesmas}/{start}/{limit}` - Get data pasien rawat jalan

### Antrean
- `POST /antrean` - Daftar antrian baru
- `GET /antrean/status/{kodepoli}/{tanggal}` - Status antrian
- `GET /antrean/sisapeserta/{nokartu}/{kodepoli}/{tanggal}` - Sisa antrian peserta
- `POST /antrean/batal` - Batalkan antrian

## Keamanan

### Best Practices yang Diterapkan

1. **Prepared Statements**: Semua query database menggunakan Query Builder
2. **Password Hashing**: Bcrypt dengan cost factor yang sesuai
3. **Input Validation**: Validasi dan sanitasi semua input
4. **Error Handling**: Error logging tanpa expose sensitive information
5. **Token Management**: Secure token generation dan expiration
6. **Environment Variables**: Credentials tidak hardcoded

### Migrasi Password

Untuk migrasi password lama ke bcrypt, sistem mendukung:
- Bcrypt (preferred)
- MD5 (backward compatibility)
- Plain text (untuk migrasi awal)

Saat user login dengan password lama, sistem akan otomatis upgrade ke bcrypt.

## Konfigurasi

### Database
Edit file `.env`:
```
DB_HOST=localhost
DB_USERNAME=your_username
DB_PASSWORD=your_password
DB_DATABASE=your_database
```

### BPJS API
```
BPJS_BASE_URL=https://apijkn.bpjs-kesehatan.go.id/pcare-rest
BPJS_CONS_ID=your_cons_id
BPJS_SECRET_KEY=your_secret_key
```

### Email
```
EMAIL_HOST=mail.example.com
EMAIL_PORT=25
EMAIL_USER=your_email@example.com
EMAIL_PASS=your_password
```

## Troubleshooting

### Error: Database connection failed
- Pastikan credentials di `.env` benar
- Pastikan database server running
- Check firewall settings

### Error: Token expired
- Token berlaku 30 menit (default)
- Dapat diubah di `.env`: `TOKEN_EXPIRE_MINUTES=30`

### Error: API key not found
- Pastikan API key sudah di-approve (`Approve = 'Y'`)
- Check header `keyid` di request

## Support

Untuk pertanyaan atau issue, silakan hubungi tim development.

## License

MIT License

