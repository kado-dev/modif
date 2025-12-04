#!/bin/bash
# Script untuk membuat zip file aplikasi linggarbaru dengan menjaga permission

# Nama file zip
ZIP_NAME="linggarbaru_$(date +%Y%m%d_%H%M%S).zip"

# Pastikan permission sudah benar sebelum zip
echo "Setting permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Buat zip dengan menjaga permission
echo "Creating zip file: $ZIP_NAME"
zip -r "$ZIP_NAME" . \
    -x "*.git*" \
    -x "*.DS_Store" \
    -x "*node_modules*" \
    -x "*.zip" \
    -x "*.tar.gz" \
    -x "*.log" \
    -x "error_log" \
    -x "*.tmp"

echo ""
echo "Zip file created: $ZIP_NAME"
echo ""
echo "To extract with preserved permissions, use:"
echo "  unzip -X $ZIP_NAME"
echo ""
echo "Or use tar for better permission preservation:"
echo "  tar -czf linggarbaru.tar.gz --preserve-permissions ."

