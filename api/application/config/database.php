<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Simple function to read .env file
// This is needed because config files load before helpers
if (!function_exists('getEnvFromFile')) {
    function getEnvFromFile($key, $default = '') {
        // Determine FCPATH - config files are in application/config/
        $envFile = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . '.env';
        
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || strpos($line, '#') === 0) continue;
                if (strpos($line, '=') === false) continue;
                
                $parts = explode('=', $line, 2);
                if (count($parts) !== 2) continue;
                
                $name = trim($parts[0]);
                $value = trim($parts[1]);
                $value = trim($value, '"\'');
                
                if ($name === $key) {
                    return $value;
                }
            }
        }
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname' => getEnvFromFile('DB_HOST', 'localhost'),
    'username' => getEnvFromFile('DB_USERNAME', ''),
    'password' => getEnvFromFile('DB_PASSWORD', ''),
    'database' => getEnvFromFile('DB_DATABASE', ''),
    'dbdriver' => getEnvFromFile('DB_DRIVER', 'mysqli'),
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

