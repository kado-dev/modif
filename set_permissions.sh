#!/bin/bash
# Script untuk set permission file dan folder aplikasi linggarbaru
# Permission yang digunakan:
# - File: 644 (rw-r--r--)
# - Folder: 755 (rwxr-xr-x)

echo "Setting permissions for linggarbaru application..."

# Set permission untuk semua file menjadi 644
find . -type f -exec chmod 644 {} \;

# Set permission untuk semua folder menjadi 755
find . -type d -exec chmod 755 {} \;

# Set permission khusus untuk file executable jika ada
if [ -f "index.php" ]; then
    chmod 644 index.php
fi

echo "Permissions set completed!"
echo ""
echo "File permissions: 644 (rw-r--r--)"
echo "Directory permissions: 755 (rwxr-xr-x)"

