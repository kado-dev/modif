<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
session_start();
include "config/koneksi.php";
// $kodepuskesmas = $_SESSION['kodepuskesmas'];
// $tahun = $_POST['tahun'];
// $namaprogram = $_POST['namaprogram'];
// menghubungkan dengan library excel reader
include "excel_reader2.php";
?>

<?php

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
    $satuan   = $data->val($i, 4);
    if($satuan == "-"){
        $satuan = 0;
    }
	
	if($kodeobat != ""){         
		// input data ke database (table data_pegawai)
        mysqli_query($koneksi,"UPDATE `tbgfkstok` SET `Satuan`='$satuan'
          WHERE `KodeBarang`='$kodeobat'");  		  
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
// alihkan halaman ke index.php
header("location:index.php?page=gudang_besar_stok");
?>