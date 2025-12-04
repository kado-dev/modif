<?php 
error_reporting(1);
session_start();

require_once("vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
include "config/koneksi.php";

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun = $_POST['tahun'];

// upload file xls
$target = basename($_FILES['fileexcel']['name']);
move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['fileexcel']['name'],0777);

// nama file xls
$filesexcels = $_FILES['fileexcel']['name'];

$extension = pathinfo($filesexcels, PATHINFO_EXTENSION);

if ('csv' == $extension) {
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
}else if('xls' == $extension) {     
  	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
}else{
  	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
}

$spreadsheet = $reader->load($filesexcels);
$sheetData = $spreadsheet->getActiveSheet()->toArray();

$no = 0;
foreach ($sheetData as $dt) {
	if ($no > 0) {
		if ($dt[1] != '') {
			$satu1 = mysqli_real_escape_string($koneksi, $dt[0]);
			$satu = strtoupper($satu1);
			$dua     = $dt[1];
			$tiga     = $dt[2];
			$empat     = $dt[3];
			$str = "INSERT INTO `tbpasien_BHAKTISEHAT`(`NamaPasien`,`Alamat`,`NoRM`,`Telpon`) 
			VALUES ('$satu','$dua','$tiga','$empat')";
			echo $str;
			
			mysqli_query($koneksi, $str);
			$berhasil++;

		}
	}
	$no++;
}
// die();
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
echo "<script>";
echo "alert('Data berhasil diimport');";
// echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual';".$links;
echo "document.location.href='index.php?page=import_data';";
echo "</script>";
?>