<?php
// Test database connection
define('FCPATH', __DIR__ . '/');
define('BASEPATH', __DIR__ . '/system/');
define('ENVIRONMENT', 'development');

// Load helper
require 'application/helpers/my_helper.php';

echo "=== Testing .env Reading ===\n";
echo "DB_HOST: " . getEnv('DB_HOST', 'NOT_FOUND') . "\n";
echo "DB_USERNAME: " . getEnv('DB_USERNAME', 'NOT_FOUND') . "\n";
echo "DB_PASSWORD: " . (getEnv('DB_PASSWORD', 'NOT_FOUND') ? '***SET***' : 'EMPTY') . "\n";
echo "DB_DATABASE: " . getEnv('DB_DATABASE', 'NOT_FOUND') . "\n";
echo "DB_DRIVER: " . getEnv('DB_DRIVER', 'NOT_FOUND') . "\n";
echo "\n";

// Test database connection
echo "=== Testing Database Connection ===\n";
$host = getEnv('DB_HOST', 'localhost');
$user = getEnv('DB_USERNAME', 'root');
$pass = getEnv('DB_PASSWORD', '');
$db = getEnv('DB_DATABASE', '');
$driver = getEnv('DB_DRIVER', 'mysqli');

if ($driver === 'mysqli') {
    $conn = @new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        echo "❌ Connection failed: " . $conn->connect_error . "\n";
        echo "Error code: " . $conn->connect_errno . "\n";
    } else {
        echo "✅ Connection successful!\n";
        echo "Server info: " . $conn->server_info . "\n";
        $conn->close();
    }
} else {
    echo "Driver $driver not tested in this script\n";
}

