<?php 
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun = $_POST['tahun'];
$namaprogram = $_POST['namaprogram'];
// menghubungkan dengan koneksi
include 'config/koneksi.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";


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
   
	// stokawal 
	$stokawalapbd   = str_replace(array(",","* "), "", $data->val($i, 5));
    if($stokawalapbd == " "){
        $stokawalapbd = 0;
    }		
	$stokawaljkn   = str_replace(array(",","* "), "", $data->val($i, 6));
    if($stokawaljkn == " "){
        $stokawaljkn = 0;
    }
	
	// penerimaan
	$penerimaan_apbd = str_replace(array(",","* "), "", $data->val($i, 7));
    if($penerimaan_apbd == " "){
        $penerimaan_apbd = 0;
    }
	
	$penerimaan_jkn = str_replace(array(",","* "), "", $data->val($i, 8));
    if($penerimaan_jkn == " "){
        $penerimaan_jkn = 0;
    }
	
	// pemakaian rata rata
	$pemakaianrata_apbd = str_replace(array(",","* "), "", $data->val($i, 9));
    if($pemakaianrata_apbd == " "){
        $pemakaianrata_apbd = 0;
    }
	
	$pemakaianrata_jkn = str_replace(array(",","* "), "", $data->val($i, 10));
    if($pemakaianrata_jkn == " "){
        $pemakaianrata_jkn = 0;
    }
	
	// sisa stok
	$sisastok_apbd = str_replace(array(",","* "), "", $data->val($i, 11));
    if($sisastok_apbd == " "){
        $sisastok_apbd = 0;
    }
	
	$sisastok_jkn = str_replace(array(",","* "), "", $data->val($i, 12));
    if($sisastok_jkn == " "){
        $sisastok_jkn = 0;
    }
	
	// tingkat kecukupan
	$tingkatkecukupan = str_replace(array(",","* "), "", $data->val($i, 13));
    if($tingkatkecukupan == " "){
        $tingkatkecukupan = 0;
    }
	
	// total kebutuhan
	$totalkebutuhan_apbd = str_replace(array(",","* "), "", $data->val($i, 14));
    if($totalkebutuhan_apbd == " "){
        $totalkebutuhan_apbd = 0;
    }
	
	$totalkebutuhan_jkn = str_replace(array(",","* "), "", $data->val($i, 15));
    if($totalkebutuhan_jkn == " "){
        $totalkebutuhan_jkn = 0;
    }
	
	// rencana pengadaan koreksi
	$rencanapengadaankoreksi = str_replace(array(",","* "), "", $data->val($i, 16));
    if($rencanapengadaankoreksi == " "){
        $rencanapengadaankoreksi = 0;
    }
	
	// rencana pengadaan koreksi
	$rencanapengadaan_apbd = str_replace(array(",","* "), "", $data->val($i, 17));
    if($rencanapengadaan_apbd == " "){
        $rencanapengadaan_apbd = 0;
    }
	
	$rencanapengadaan_jkn = str_replace(array(",","* "), "", $data->val($i, 18));
    if($rencanapengadaan_jkn == " "){
        $rencanapengadaan_jkn = 0;
    }
		
	// update data
	if($kodeobat != ""){
		$strupdate = "UPDATE `tbrko_bogorkab_puskesmas`
		SET `StokAwal_Apbd`='$stokawalapbd', `StokAwal_Jkn`='$stokawaljkn',
		`Penerimaan_Apbd`='$penerimaan_apbd', `Penerimaan_Jkn`='$penerimaan_jkn',
		`PemakaianRata_Apbd`='$pemakaianrata_apbd', `PemakaianRata_Jkn`='$pemakaianrata_jkn',
		`SisaStok_Apbd`='$sisastok_apbd', `SisaStok_Jkn`='$sisastok_jkn',
		`TingkatKecukupan`='$tingkatkecukupan',
		`TotalKebutuhan_Apbd`='$totalkebutuhan_apbd',`TotalKebutuhan_Jkn`='$totalkebutuhan_jkn',
		`RencanaPengadaanKoreksi`='$rencanapengadaankoreksi',
		`RencanaPengadaan_Apbd`='$rencanapengadaan_apbd',`RencanaPengadaan_Jkn`='$rencanapengadaan_jkn'
        WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'";
		// echo $strupdate;
		// die();
        mysqli_query($koneksi, $strupdate);  		  
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);
// $links = $_POST['link'];
// alihkan halaman ke index.php
// header("location:index.php?page=lap_farmasi_importdata");

// echo "<script>";
// echo "alert('Data berhasil diimport...');";
// echo "document.location.href='index.php?page=lap_farmasi_rko_bogorkab&tahun=$tahun&namaprogram=$namaprogram';";
// echo "</script>";
echo "sukses";
?>