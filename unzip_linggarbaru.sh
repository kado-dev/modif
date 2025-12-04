#!/bin/bash
# Script untuk unzip file aplikasi linggarbaru dengan menjaga permission

if [ -z "$1" ]; then
    echo "Usage: ./unzip_linggarbaru.sh <zip_file>"
    echo "Example: ./unzip_linggarbaru.sh linggarbaru.zip"
    exit 1
fi

ZIP_FILE="$1"

if [ ! -f "$ZIP_FILE" ]; then
    echo "Error: File $ZIP_FILE not found!"
    exit 1
fi

echo "Extracting $ZIP_FILE..."
unzip -X "$ZIP_FILE"

echo ""
echo "Setting permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

echo ""
echo "Extraction completed!"
echo "Permissions have been set:"
echo "  - Files: 644 (rw-r--r--)"
echo "  - Directories: 755 (rwxr-xr-x)"

