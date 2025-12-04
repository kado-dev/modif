<?php 
error_reporting(1);
session_start();
include "config/koneksi.php";
require_once("vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

			$satu     = $dt[1];
			$dua     = $dt[2];
			$tiga     = $dt[3];
			$empat     = $dt[4];
			$lima     = $dt[5];
			$enam     = $dt[6];
			$tujuh     = $dt[7];
			$delapan     = $dt[8];
			$str = "INSERT INTO `tbkk_NAGRAK1`(`TanggalDaftar`, `NoIndex`, `NoRM`, `NamaKK`, `Alamat`, `Kota`, `Kecamatan`, `Kelurahan`) 
			VALUES ('$satu','$dua','$tiga','$empat','$lima','$enam','$tujuh','$delapan')";
			echo $str;
			  die();
			//mysqli_query($koneksi, $str);
			$berhasil++;

		}
	}
	$no++;
}
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
echo "<script>";
echo "alert('Data berhasil diimport');";
// echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual';".$links;
echo "document.location.href='index.php?page=import_data';";
echo "</script>";
?>