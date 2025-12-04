<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

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
    $kodeobat     = $data->val($i, 1);
	
	// stok awal
	$stokawal_apbd   = $data->val($i, 6);
    if($stokawal_apbd == "-"){
        $stokawal_apbd = 0;
    }
	$stokawal_jkn   = $data->val($i, 7);
    if($stokawal_jkn == "-"){
        $stokawal_jkn = 0;
    }
	
	// penerimaan
	$penerimaan_apbd   = $data->val($i, 8);
    if($penerimaan_apbd == "-"){
        $penerimaan_apbd = 0;
    }
	$penerimaan_jkn   = $data->val($i, 9);
    if($penerimaan_jkn == "-"){
        $penerimaan_jkn = 0;
    }
	
	// pemakaian
	$pemakaian_apbd   = $data->val($i, 10);
    if($pemakaian_apbd == "-"){
        $pemakaian_apbd = 0;
    }
	$pemakaian_jkn   = $data->val($i, 11);
    if($pemakaian_jkn == "-"){
        $pemakaian_jkn = 0;
    }
	
	// sisa stok
    $stokgudang   = $data->val($i, 12);
    if($stokgudang == "-"){
        $stokgudang = 0;
    }
    $stokdepot   = $data->val($i, 13);
    if($stokdepot == "-"){
        $stokdepot  = 0;
    }
    $stokpoli  = $data->val($i, 14);
    if($stokpoli == "-"){
        $stokpoli = 0;
    }
    $stokigd  = $data->val($i, 15);
    if($stokigd == "-"){
        $stokigd = 0;
    }
    $stokranap  = $data->val($i, 16);
    if($stokranap == "-"){
        $stokranap = 0;
    }
    $stokponed  = $data->val($i, 17);
    if($stokponed == "-"){
        $stokponed = 0;
    }
    $stokpustu  = $data->val($i, 18);
    if($stokpustu == "-"){
        $stokpustu = 0;
    }
	
	// Total Sisa Stok
	$totalsisastokapbd  = $data->val($i, 19);
    if($totalsisastokapbd == "-"){
        $totalsisastokapbd = 0;
    }
    $totalsisastokjkn  = $data->val($i, 20);
    if($totalsisastokjkn == "-"){
        $totalsisastokjkn = 0;
    }
	
	// Total Rupiah
	$totalrupiahapbd  = $data->val($i, 21);
    if($totalrupiahapbd == "-"){
        $totalrupiahapbd = 0;
    }
    $totalrupiahjkn  = $data->val($i, 22);
    if($totalrupiahjkn == "-"){
        $totalrupiahjkn = 0;
    }

	if($kodeobat != ""){
        mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET 
		`StokAwalApbd`='$stokawal_apbd',
		`StokAwalJkn`='$stokawal_jkn',
		`PenerimaanApbd`='$penerimaan_apbd',
		`PenerimaanJkn`='$penerimaan_jkn',
		`PemakaianApbd`='$pemakaian_apbd',
		`PemakaianJkn`='$pemakaian_jkn',
		`StokGudang`='$stokgudang',
        `StokDepot` = '$stokdepot',
        `StokPoli` = '$stokpoli',
        `StokIgd` = '$stokigd',
        `StokRanap` = '$stokranap',
        `StokPoned`= '$stokponed',
        `StokPustu` = '$stokpustu',
        `TotalSisaStokApbd` = '$totalsisastokapbd',
        `TotalSisaStokJkn` = '$totalsisastokjkn',
        `TotalRupiahApbd` = '$totalrupiahapbd',
        `TotalRupiahJkn` = '$totalrupiahjkn'
        WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'");   
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
// alihkan halaman ke index.php
header("location:index.php?page=lap_farmasi_stok_opname_triwulan_lihat_gudang&".$links);
?>