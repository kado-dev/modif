<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load composer autoload if exists
if (file_exists(FCPATH . 'vendor/autoload.php')) {
    require_once FCPATH . 'vendor/autoload.php';
}

/**
 * Decrypt string using AES-256-CBC
 * @param string $key
 * @param string $string
 * @return string
 */
function stringDecrypt($key, $string) {
    $encrypt_method = 'AES-256-CBC';
    $key_hash = hex2bin(hash('sha256', $key));
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
    return $output;
}

/**
 * Decompress LZString
 * @param string $string
 * @return string
 */
function decompress($string) {
    if (class_exists('\LZCompressor\LZString')) {
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    return $string;
}

/**
 * Validate date format
 * @param string $date
 * @param string $format
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Get environment variable
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
if (!function_exists('getEnv')) {
    function getEnv($key, $default = '') {
        // FCPATH might not be defined yet, use __DIR__ as fallback
        if (!defined('FCPATH')) {
            // Try to determine FCPATH from common paths
            $possiblePaths = [
                dirname(__DIR__) . '/../',
                dirname(dirname(__DIR__)) . '/',
                __DIR__ . '/../../',
            ];
            foreach ($possiblePaths as $path) {
                if (file_exists($path . '.env')) {
                    define('FCPATH', $path);
                    break;
                }
            }
            if (!defined('FCPATH')) {
                // Last resort: assume current directory
                define('FCPATH', dirname(__DIR__) . '/../');
            }
        }
        
        $envFile = FCPATH . '.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || strpos($line, '#') === 0) continue;
                if (strpos($line, '=') === false) continue;
                
                // Handle both "KEY=value" and "KEY = value" formats
                $parts = explode('=', $line, 2);
                if (count($parts) !== 2) continue;
                
                $name = trim($parts[0]);
                $value = trim($parts[1]);
                // Remove quotes if present
                $value = trim($value, '"\'');
                
                if ($name === $key) {
                    return $value;
                }
            }
        }
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}

function navsidactive($ctrl, $uri) {
    $ar = explode(",", $ctrl);
    if (in_array($uri, $ar)) {
        echo "class='active'";
    }
}

function menuactive($x, $y) {
    if ($x == $y) {
        echo "active";
    }
}

function selecteds($x, $y) {
    if ($x == $y) {
        echo "SELECTED";
    }
}

function angkarupiah($angka) {
    if ($angka == 0) {
        $jadi = " ";
    } else {
        $jadi = number_format($angka, 0, ',', '.');
    }
    return $jadi;
}

function rupiah($angka) {
    if ($angka == 0) {
        $jadi = " ";
    } else {
        $jadi = "Rp. " . number_format($angka, 2, ',', '.');
    }
    return $jadi;
}

/**
 * Generate secure password
 * @param int $length
 * @return string
 */
function get_password($length = 10) {
    $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
    $max = strlen($base) - 1;
    $acak = '';
    // Use cryptographically secure random
    if (function_exists('random_int')) {
        for ($i = 0; $i < $length; $i++) {
            $acak .= $base[random_int(0, $max)];
        }
    } else {
        mt_srand((double)microtime() * 1000000);
        while (strlen($acak) < $length) {
            $acak .= $base[mt_rand(0, $max)];
        }
    }
    return $acak;
}

// Pagination security functions
function pagination_alpha($str) {
    return (!preg_match("/^([a-z])+$/i", $str)) ? "" : $str;
}

function pagination_alpha_numeric($str) {
    return (!preg_match("/^([a-z0-9])+$/i", $str)) ? "" : $str;
}

function pagination_alpha_dash($str) {
    return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? "" : $str;
}

function pagination_alpha_all($str) {
    return $str;
}

function set_my_pagination() {
    $config['full_tag_open'] = '<ul class="pagination pull-left">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['next_link'] = '<span class="glyphicon glyphicon-circle-arrow-right"></span>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '<span class="glyphicon glyphicon-circle-arrow-left"></span>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    return $config;
}

function valid($text) {
    $html = '<div class="alert alert-success alert-dismissible fade show" style="font-size:13px" role="alert">';
    $html .= $text;
    $html .= '<button type="button" class="close" style="padding:8px 8px" data-dismiss="alert" aria-label="Close">';
    $html .= '<span aria-hidden="true">&times;</span>';
    $html .= '</button>';
    $html .= '</div>';
    return $html;
}

function error($text) {
    $html = '<div class="alert alert-danger alert-dismissible fade show" style="font-size:13px" role="alert">';
    $html .= $text;
    $html .= '<button type="button" class="close" style="padding:8px 8px" data-dismiss="alert" aria-label="Close">';
    $html .= '<span aria-hidden="true">&times;</span>';
    $html .= '</button>';
    $html .= '</div>';
    return $html;
}

function url($text) {
    $arr = array(",", ".", "'", "?", "!", "&");
    $text2 = str_replace($arr, "", $text);
    $hasil = str_replace(" ", "-", $text2);
    return strtolower($hasil);
}

function urlkey($text) {
    $hasil = str_replace("-", " ", $text);
    return $hasil;
}

function tgl_indos($date) {
    $month_names = array(
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $for = explode("-", $date);
    if (count($for) == 3) {
        $tanggal = $for[2] . " " . $month_names[$for[1] - 1] . " " . $for[0];
        return $tanggal;
    }
    return $date;
}

function bulan_indos($bln) {
    $month_names = array(
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    if ($bln >= 1 && $bln <= 12) {
        return $month_names[$bln - 1];
    }
    return '';
}

function tgl_indo($date) {
    $for = explode("-", $date);
    if (count($for) == 3) {
        $tanggal = $for[2] . "-" . $for[1] . "-" . $for[0];
        return $tanggal;
    }
    return $date;
}

