<?php
include('config/koneksi.php');
session_start();

$tanggal = date("d-m-Y");
$jam = date("H:i:s");
$bulan = date("Y-m");
$userLog = isset($_POST['userlog']) ? $_POST['userlog'] : '';
$nip = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '-';
$namapegawai = isset($_SESSION['nama_petugas']) ? $_SESSION['nama_petugas'] : '-';

if($userLog == "online"){
    // Update status online
    mysqli_query($koneksi, "UPDATE `tbpegawai` SET `StatusLogin`='1' WHERE `Nip`='$nip'");
} else if($userLog == "offline"){
    // Update status offline
    mysqli_query($koneksi, "UPDATE `tbpegawai` SET `StatusLogin`='0' WHERE `Nip`='$nip'");
}

// Rotasi log per bulan - simpan di folder logs
$logDir = __DIR__ . '/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}

$logFile = $logDir . '/userlog_' . $bulan . '.txt';

// Format: status | NIP | nama | tanggal jam
$logEntry = $userLog . " | " . $nip . " | " . $namapegawai . " | " . $tanggal . " " . $jam . "\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);
?>
