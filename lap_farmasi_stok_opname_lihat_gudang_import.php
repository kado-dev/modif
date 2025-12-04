<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
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
    $stokgudang   = $data->val($i, 7);
    if($stokgudang == "-"){
        $stokgudang = 0;
    }
    $stokdepot   = $data->val($i, 9);
    if($stokdepot == "-"){
        $stokdepot  = 0;
    }
    $stokpoli  = $data->val($i, 11);
    if($stokpoli == "-"){
        $stokpoli = 0;
    }
    $stokigd  = $data->val($i, 13);
    if($stokigd == "-"){
        $stokigd = 0;
    }
    $stokranap  = $data->val($i, 15);
    if($stokranap == "-"){
        $stokranap = 0;
    }
    $stokponed  = $data->val($i, 17);
    if($stokponed == "-"){
        $stokponed = 0;
    }
    $stokpustu  = $data->val($i, 19);
    if($stokpustu == "-"){
        $stokpustu = 0;
    }
    //$keterangan  = $data->val($i, 20);

	if($kodeobat != ""){

         
		// input data ke database (table data_pegawai)
        //mysqli_query($koneksi,"INSERT into data_pegawai values('','$nama','$alamat','$telepon')");
        mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokGudang`='$stokgudang',
        `StokDepot` = '$stokdepot',
         `StokPoli` = '$stokpoli',
         `StokIgd` = '$stokigd',
         `StokRanap` = '$stokranap',
         `StokPoned`= '$stokponed',
         `StokPustu` = '$stokpustu'
          WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");    


		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);
$links = $_POST['link'];
// alihkan halaman ke index.php
header("location:index.php?page=lap_farmasi_stok_opname_lihat_gudang&".$links);
?>