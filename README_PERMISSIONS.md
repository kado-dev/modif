# Panduan Permission Aplikasi Linggarbaru

## Permission Standar

Aplikasi ini menggunakan permission standar untuk memastikan konsistensi saat zip/unzip:

- **File**: `644` (rw-r--r--)
- **Folder**: `755` (rwxr-xr-x)

## Cara Set Permission

### Menggunakan Script

Jalankan script `set_permissions.sh`:

```bash
./set_permissions.sh
```

Atau:

```bash
bash set_permissions.sh
```

### Manual

Set permission secara manual:

```bash
# Set permission untuk semua file
find . -type f -exec chmod 644 {} \;

# Set permission untuk semua folder
find . -type d -exec chmod 755 {} \;
```

## Saat Zip/Unzip

### Menggunakan Script (Recommended)

**Membuat Zip:**
```bash
./zip_linggarbaru.sh
```

Script ini akan:
- Set permission yang benar sebelum zip
- Membuat file zip dengan timestamp
- Menjaga permission saat zip

**Unzip:**
```bash
./unzip_linggarbaru.sh linggarbaru.zip
```

Script ini akan:
- Extract file dengan menjaga permission
- Set permission yang benar setelah unzip

### Manual Zip/Unzip

**Zip dengan Permission:**

```bash
# Linux/Mac
zip -r linggarbaru.zip . -X

# Atau dengan tar (lebih baik untuk permission)
tar -czf linggarbaru.tar.gz --preserve-permissions .
```

**Unzip dengan Permission:**

```bash
# Linux/Mac
unzip -X linggarbaru.zip

# Atau dengan tar
tar -xzf linggarbaru.tar.gz --preserve-permissions
```

## Catatan

- Permission `644` untuk file memastikan file dapat dibaca oleh semua user, tetapi hanya owner yang dapat menulis
- Permission `755` untuk folder memastikan folder dapat diakses dan di-list oleh semua user, tetapi hanya owner yang dapat membuat/menghapus file di dalamnya
- Setelah unzip, jika permission berubah, jalankan script `set_permissions.sh` untuk memperbaikinya

