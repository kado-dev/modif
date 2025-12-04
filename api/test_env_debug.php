<?php
define('FCPATH', __DIR__ . '/');
echo "FCPATH: " . FCPATH . "\n";
echo ".env exists: " . (file_exists(FCPATH . '.env') ? 'YES' : 'NO') . "\n";
echo ".env path: " . FCPATH . '.env' . "\n";
echo "\n";

if (file_exists(FCPATH . '.env')) {
    echo "=== Reading .env file ===\n";
    $lines = file(FCPATH . '.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        $value = trim($value, '"\'');
        echo "Line " . ($i+1) . ": $name = $value\n";
    }
}
