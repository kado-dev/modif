<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load getEnvFromFile function (same as database.php)
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

$config['base_url'] = getEnvFromFile('APP_BASE_URL', 'https://simpus.puskesmaslinggar.com/apibaru/');
$config['index_page'] = 'index.php';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['log_threshold'] = (ENVIRONMENT === 'production') ? 1 : 4;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = getEnvFromFile('APP_ENCRYPTION_KEY', '');
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = APPPATH . 'sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = TRUE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'Asia/Jakarta';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

