<?php 
session_start();
include "config/koneksi.php";
include "excel_reader2.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$sumberanggaran = $_POST['sumberanggaran'];
$tblplpomanual_bogorkab = "tblplpomanual_bogorkab_".$kodepuskesmas;

// upload file xls
$target = basename($_FILES['fileexcel']['name']);
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
	
	// stokawal apbd
	$stokawal_apbd   = $data->val($i, 5);
    if($stokawal_apbd == " "){
        $stokawal_apbd = 0;
    }
	$stokawal_apbd = preg_replace('/\D/', '', $stokawal_apbd);
	
	// stokawal program
	$stokawal_program   = $data->val($i, 6);
    if($stokawal_program == " "){
        $stokawal_program = 0;
    }
	$stokawal_program = preg_replace('/\D/', '', $stokawal_program);
	
	// stokawal jkn
	$stokawal_jkn   = $data->val($i, 7);
    if($stokawal_jkn == " "){
        $stokawal_jkn = 0;
    }
	$stokawal_jkn = preg_replace('/\D/', '', $stokawal_jkn);
	
	// pemakaian apbd
	$pemakaian_apbd   = $data->val($i, 8);
    if($pemakaian_apbd == " "){
        $pemakaian_apbd = 0;
    }
	$pemakaian_apbd = preg_replace('/\D/', '', $pemakaian_apbd);
	
	// pemakaian program
	$pemakaian_program   = $data->val($i, 9);
    if($pemakaian_program == " "){
        $pemakaian_program = 0;
    }
	$pemakaian_program = preg_replace('/\D/', '', $pemakaian_program);
	
	// pemakaian jkn
	$pemakaian_jkn   = $data->val($i, 10);
    if($pemakaian_jkn == " "){
        $pemakaian_jkn = 0;
    }
	$pemakaian_jkn = preg_replace('/\D/', '', $pemakaian_jkn);

	// permintaan
	$permintaan   = $data->val($i, 11);
    if($permintaan == " "){
        $permintaan = 0;
    }
	$permintaan = preg_replace('/\D/', '', $permintaan);	
	
	// update data
	if($kodeobat != ""){
        mysqli_query($koneksi,"UPDATE `$tblplpomanual_bogorkab` SET 
		`StokAwal`= '$stokawal_apbd',
		`StokAwalProgram`= '$stokawal_program',
		`StokAwalJkn`= '$stokawal_jkn',
		`Pemakaian`='$pemakaian_apbd',
		`PemakaianProgram`='$pemakaian_program',
		`PemakaianJkn`='$pemakaian_jkn',
		`Permintaan`='$permintaan'
        WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan'");  		  
		// $berhasil++;
	}
}
// hapus kembali file .xls yang di upload tadi
// unlink($_FILES['fileexcel']['name']);
// $links = $_POST['link'];
// alihkan halaman ke index.php
// header("location:index.php?page=lap_farmasi_lplpo_manual&".$links);

unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
echo "<script>";
echo "alert('Data berhasil diupload...');";
// echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual';".$links;
echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual_bogorkab&bulan=$bulan&tahun=$tahun&sumberanggaran=$sumberanggaran';";
echo "</script>";
?>