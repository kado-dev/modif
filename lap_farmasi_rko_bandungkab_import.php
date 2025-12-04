<?php 
session_start();
include "config/koneksi.php";
include "excel_reader2.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun = $_POST['tahun'];
$sumberanggaran = $_POST['sumberanggaran'];

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
    $kodeobat     = $data->val($i, 2);
	
	// sisa stok desember / stok awal
	$stokawal   = $data->val($i, 5);
    if($stokawal == "-"){
        $stokawal = 0;
    }

	// pemakaian rata-rata perbulan
	$pemakaianrata   = $data->val($i, 6);
    if($pemakaianrata == "-"){
        $pemakaianrata = 0;
    }

	// rencana pengadaan
	$rencanapengadaan   = $data->val($i, 9);
    if($rencanapengadaan == "-"){
        $rencanapengadaan = 0;
    }

	// realisasi pengadaan
	$realisasipengadaan   = $data->val($i, 10);
    if($realisasipengadaan == "-"){
        $realisasipengadaan = 0;
    }
	
	// update data
	if($kodeobat != ""){
		mysqli_query($koneksi,"UPDATE `tbrkobandungkab` 
		SET `StokAwal`='$stokawal',
		`PemakaianRata`='$pemakaianrata',
		`RencanaPengadaan`='$rencanapengadaan',
		`RealisasiPengadaan`='$realisasipengadaan'
		WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"); 		
		// $berhasil++;
	}
	
	
}

// hapus kembali file .xls yang di upload tadi
// unlink($_FILES['fileexcel']['name']);
// $links = $_POST['link'];
// alihkan halaman ke index.php
// header("location:index.php?page=lap_farmasi_rko_bandungkab&".$links);

unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
echo "<script>";
echo "alert('Data berhasil diimport');";
// echo "document.location.href='index.php?page=lap_farmasi_rko_bandungkab';".$links;
echo "document.location.href='index.php?page=lap_farmasi_rko_bandungkab&tahun=$tahun&sumberanggaran=$sumberanggaran';";
echo "</script>";
?>