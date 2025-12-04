# Cara Generate Encryption Key

CodeIgniter memerlukan encryption key 32 karakter untuk keamanan. Berikut beberapa cara untuk generate key:

## Metode 1: Menggunakan Script PHP (Recommended)

1. Jalankan script yang sudah disediakan:
   ```bash
   php generate_key.php
   ```

2. Copy output key dan paste ke file `.env`:
   ```
   APP_ENCRYPTION_KEY=paste_key_di_sini
   ```

## Metode 2: Menggunakan Command Line (OpenSSL)

```bash
openssl rand -hex 16
```

Output akan berupa 32 karakter hex (16 bytes = 32 hex characters).

## Metode 3: Menggunakan Command Line (Base64)

```bash
openssl rand -base64 24 | head -c 32
```

## Metode 4: Menggunakan PHP One-liner

```bash
php -r "echo bin2hex(random_bytes(16));"
```

## Metode 5: Menggunakan Online Generator (Kurang Disarankan)

Jika tidak ada akses ke command line, bisa menggunakan:
- https://randomkeygen.com/
- Pilih "CodeIgniter Encryption Keys"
- Copy salah satu key yang dihasilkan

**Catatan:** Online generator kurang aman karena key di-generate di server pihak ketiga.

## Contoh Output

```
Generated Key: a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
```

## Setelah Generate

1. Copy key yang dihasilkan
2. Edit file `.env`
3. Ganti `APP_ENCRYPTION_KEY=generate_random_32_char_key_here` dengan:
   ```
   APP_ENCRYPTION_KEY=a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
   ```
4. Simpan file

## Penting!

- **JANGAN** commit file `.env` ke git (sudah di-ignore)
- **JANGAN** share encryption key ke publik
- **JANGAN** gunakan key yang sama untuk multiple environment
- Generate key baru untuk setiap environment (development, staging, production)

## Verifikasi

Setelah set encryption key, test dengan:
```php
$this->load->library('encryption');
$encrypted = $this->encryption->encrypt('test');
$decrypted = $this->encryption->decrypt($encrypted);
```

Jika tidak error, key sudah benar.

