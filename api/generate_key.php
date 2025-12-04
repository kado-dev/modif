<?php
/**
 * Script untuk generate encryption key untuk CodeIgniter
 * 
 * Usage: php generate_key.php
 */

// Generate 32 character random key
// CodeIgniter encryption key harus 32 karakter
$key = bin2hex(random_bytes(16)); // 16 bytes = 32 hex characters

echo "========================================\n";
echo "CodeIgniter Encryption Key Generator\n";
echo "========================================\n\n";
echo "Generated Key: " . $key . "\n\n";
echo "Copy key ini ke file .env:\n";
echo "APP_ENCRYPTION_KEY=" . $key . "\n\n";
echo "========================================\n";

