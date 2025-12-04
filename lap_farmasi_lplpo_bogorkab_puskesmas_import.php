<?php 
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
// menghubungkan dengan koneksi
include 'config/koneksi.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";
?>

<?php

// upload file xls
$target = basename($_FILES['fileexcel']['name']) ;
move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['fileexcel']['name'],0777);

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
    $kodeobat = $data->val($i, 2);
    $stokawal_apbd = $data->val($i, 6);
    $stokawal_jkn = $data->val($i, 7); 
	$penerimaan_apbd = $data->val($i, 8); 
	$penerimaan_jkn = $data->val($i, 9); 
	$persediaan_apbd = $data->val($i, 10); 
	$persediaan_jkn = $data->val($i, 11); 
	$pemakaian_apbd  = $data->val($i, 12);   
	$pemakaian_jkn = $data->val($i, 13);  
	$sisaakhir_apbd = $data->val($i, 14);  
	$sisaakhir_jkn = $data->val($i, 15);  
	$permintaan_apbd  = $data->val($i, 16);  
	$permintaan_jkn  = $data->val($i, 17);  
			
	if($kodeobat != ""){ 
        mysqli_query($koneksi,"UPDATE `tbgudangpkmlplpomanual` 
		SET `StokAwalApbd`='$stokawal_apbd',
        `StokAwalJkn` = '$stokawal_jkn',
        `PenerimaanApbd` = '$penerimaan_apbd',
        `PenerimaanJkn`= '$penerimaan_jkn',
		`PersediaanApbd` = '$persediaan_apbd',
        `PersediaanJkn`= '$persediaan_jkn',
        `PemakaianApbd` = '$pemakaian_apbd',
        `PemakaianJkn` = '$pemakaian_jkn',
		`SisaAkhirApbd` = '$sisaakhir_apbd',
        `SisaAkhirJkn` = '$sisaakhir_jkn',
        `PermintaanApbd` = '$permintaan_apbd',
        `PermintaanJkn` = '$permintaan_jkn'
        WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodeobat' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"); 
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
// alihkan halaman ke index.php
header("location:index.php?page=lap_farmasi_lplpo_bogorkab_puskesmas&".$links);
?>