<?php 
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
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

// delete tbgudangpkmstok berdasarkan puskesmas
// mysqli_query($koneksi, "DELETE FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas'");	

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){
	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
    $kodebarang     = $data->val($i, 2);
   
	// harga 
	$hargaapbd   = str_replace(array(",","* "), "", $data->val($i, 5));
    if($hargaapbd == "" OR $hargaapbd == "-"){
        $hargaapbd = '0';
    }	
	$hargajkn   = str_replace(array(",","* "), "", $data->val($i, 6));
    if($hargajkn == "" OR $hargajkn == "-"){
        $hargajkn = '0';
    }
	
	// stokawal 
	$stokawalapbd   = str_replace(array(",","* "), "", $data->val($i, 7));
    if($stokawalapbd == "" OR $stokawalapbd == "-"){
        $stokawalapbd = '0';
    }	
	$stokawaljkn   = str_replace(array(",","* "), "", $data->val($i, 8));
    if($stokawaljkn == "" OR $stokawaljkn == "-"){
        $stokawaljkn = '0';
    }
	
	// penerimaan 
	$PenerimaanJkn_01   = str_replace(array(",","* "), "", $data->val($i, 9));
    if($PenerimaanJkn_01 == "" OR $PenerimaanJkn_01 == "-"){
        $PenerimaanJkn_01 = '0';
    }
	$PenerimaanJkn_02   = str_replace(array(",","* "), "", $data->val($i, 10));
    if($PenerimaanJkn_02 == "" OR $PenerimaanJkn_02 == ""){
        $PenerimaanJkn_02 = '0';
    }	
	$PenerimaanJkn_03   = str_replace(array(",","* "), "", $data->val($i, 11));
    if($PenerimaanJkn_03 == "" OR $PenerimaanJkn_03 == ""){
        $PenerimaanJkn_03 = '0';
    }
	$PenerimaanJkn_04   = str_replace(array(",","* "), "", $data->val($i, 12));
    if($PenerimaanJkn_04 == "" OR $PenerimaanJkn_04 == ""){
        $PenerimaanJkn_04 = '0';
    }	
	$PenerimaanJkn_05   = str_replace(array(",","* "), "", $data->val($i, 13));
    if($PenerimaanJkn_05 == "" OR $PenerimaanJkn_05 == ""){
        $PenerimaanJkn_05 = '0';
    }
	$PenerimaanJkn_06   = str_replace(array(",","* "), "", $data->val($i, 14));
    if($PenerimaanJkn_06 == "" OR $PenerimaanJkn_06 == ""){
        $PenerimaanJkn_06 = '0';
    }
	$PenerimaanJkn_07   = str_replace(array(",","* "), "", $data->val($i, 15));
    if($PenerimaanJkn_07 == "" OR $PenerimaanJkn_07 == ""){
        $PenerimaanJkn_07 = '0';
    }
	$PenerimaanJkn_08   = str_replace(array(",","* "), "", $data->val($i, 16));
    if($PenerimaanJkn_08 == "" OR $PenerimaanJkn_08 == ""){
        $PenerimaanJkn_08 = '0';
    }	
	$PenerimaanJkn_09   = str_replace(array(",","* "), "", $data->val($i, 17));
    if($PenerimaanJkn_09 == "" OR $PenerimaanJkn_09 == ""){
        $PenerimaanJkn_09 = '0';
    }	
	$PenerimaanJkn_10   = str_replace(array(",","* "), "", $data->val($i, 18));
    if($PenerimaanJkn_10 == "" OR $PenerimaanJkn_10 == ""){
        $PenerimaanJkn_10 = '0';
    }	
	$PenerimaanJkn_11   = str_replace(array(",","* "), "", $data->val($i, 19));
    if($PenerimaanJkn_11 == "" OR $PenerimaanJkn_11 == ""){
        $PenerimaanJkn_11 = '0';
    }
	$PenerimaanJkn_12   = str_replace(array(",","* "), "", $data->val($i, 20));
    if($PenerimaanJkn_12 == "" OR $PenerimaanJkn_12 == ""){
        $PenerimaanJkn_12 = '0';
    }
	
	// Sisa Stok 01
	$SisaStok_Gudang_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 21));
    if($SisaStok_Gudang_Apbd_01 == "" OR $SisaStok_Gudang_Apbd_01 == "-"){
        $SisaStok_Gudang_Apbd_01 = '0';
    }
	
	$SisaStok_Gudang_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 22));
    if($SisaStok_Gudang_Jkn_01 == "" OR $SisaStok_Gudang_Jkn_01 == "-"){
        $SisaStok_Gudang_Jkn_01 = '0';
    }
	
	$SisaStok_Depot_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 23));
    if($SisaStok_Depot_Apbd_01 == " " OR $SisaStok_Depot_Apbd_01 == "-"){
        $SisaStok_Depot_Apbd_01 = '0';
    }
	
	$SisaStok_Depot_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 24));
    if($SisaStok_Depot_Jkn_01 == "" OR $SisaStok_Depot_Jkn_01 == "-"){
        $SisaStok_Depot_Jkn_01 = '0';
    }
	
	$SisaStok_Igd_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 25));
    if($SisaStok_Igd_Apbd_01 == "" OR $SisaStok_Igd_Apbd_01 == "-"){
        $SisaStok_Igd_Apbd_01 = '0';
    }
	
	$SisaStok_Igd_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 26));
    if($SisaStok_Igd_Jkn_01 == "" OR $SisaStok_Igd_Jkn_01 == "-"){
        $SisaStok_Igd_Jkn_01 = '0';
    }
	
	$SisaStok_Ranap_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 27));
    if($SisaStok_Ranap_Apbd_01 == "" OR $SisaStok_Ranap_Apbd_01 == "-"){
        $SisaStok_Ranap_Apbd_01 = '0';
    }
	
	$SisaStok_Ranap_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 28));
    if($SisaStok_Ranap_Jkn_01 == "" OR $SisaStok_Ranap_Jkn_01 == "-"){
        $SisaStok_Ranap_Jkn_01 = '0';
    }
	
	$SisaStok_Poned_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 29));
    if($SisaStok_Poned_Apbd_01 == "" OR $SisaStok_Poned_Apbd_01 == "-"){
        $SisaStok_Poned_Apbd_01 = '0';
    }
	
	$SisaStok_Poned_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 30));
    if($SisaStok_Poned_Jkn_01 == "" OR $SisaStok_Poned_Jkn_01 == "-"){
        $SisaStok_Poned_Jkn_01 = '0';
    }
	
	$SisaStok_Pustu_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 31));
    if($SisaStok_Pustu_Apbd_01 == "" OR $SisaStok_Pustu_Apbd_01 == "-"){
        $SisaStok_Pustu_Apbd_01 = '0';
    }
	
	$SisaStok_Pustu_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 32));
    if($SisaStok_Pustu_Jkn_01 == "" OR $SisaStok_Pustu_Jkn_01 == "-"){
        $SisaStok_Pustu_Jkn_01 = '0';
    }
	
	$SisaStok_Pusling_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 33));
    if($SisaStok_Pusling_Apbd_01 == "" OR $SisaStok_Pusling_Apbd_01 == "-"){
        $SisaStok_Pusling_Apbd_01 = '0';
    }
	
	$SisaStok_Pusling_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 34));
    if($SisaStok_Pusling_Jkn_01 == "" OR $SisaStok_Pusling_Jkn_01 == "-"){
        $SisaStok_Pusling_Jkn_01 = '0';
    }
	
	$SisaStok_Poli_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 35));
    if($SisaStok_Poli_Apbd_01 == "" OR $SisaStok_Poli_Apbd_01 == "-"){
        $SisaStok_Poli_Apbd_01 = '0';
    }
	
	$SisaStok_Poli_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 36));
    if($SisaStok_Poli_Jkn_01 == "" OR $SisaStok_Poli_Jkn_01 == "-"){
        $SisaStok_Poli_Jkn_01 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_01   = str_replace(array(",","* "), "", $data->val($i, 37));
    if($SisaStok_Lainnya_Apbd_01 == "" OR $SisaStok_Lainnya_Apbd_01 == "-"){
        $SisaStok_Lainnya_Apbd_01 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_01   = str_replace(array(",","* "), "", $data->val($i, 38));
    if($SisaStok_Lainnya_Jkn_01 == "" OR $SisaStok_Lainnya_Jkn_01 == "-"){
        $SisaStok_Lainnya_Jkn_01 = '0';
    }
	
	// Sisa Stok 02
	$SisaStok_Gudang_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 39));
    if($SisaStok_Gudang_Apbd_02 == "" OR $SisaStok_Gudang_Apbd_02 == "-"){
        $SisaStok_Gudang_Apbd_02 = '0';
    }
	
	$SisaStok_Gudang_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 40));
    if($SisaStok_Gudang_Jkn_02 == "" OR $SisaStok_Gudang_Jkn_02 == "-"){
        $SisaStok_Gudang_Jkn_02 = '0';
    }
	
	$SisaStok_Depot_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 41));
    if($SisaStok_Depot_Apbd_02 == "" OR $SisaStok_Depot_Apbd_02 == "-"){
        $SisaStok_Depot_Apbd_02 = '0';
    }
	
	$SisaStok_Depot_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 42));
    if($SisaStok_Depot_Jkn_02 == "" OR $SisaStok_Depot_Jkn_02 == "-"){
        $SisaStok_Depot_Jkn_02 = '0';
    }
	
	$SisaStok_Igd_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 43));
    if($SisaStok_Igd_Apbd_02 == "" OR $SisaStok_Igd_Apbd_02 == "-"){
        $SisaStok_Igd_Apbd_02 = '0';
    }
	
	$SisaStok_Igd_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 44));
    if($SisaStok_Igd_Jkn_02 == "" OR $SisaStok_Igd_Jkn_02 == "-"){
        $SisaStok_Igd_Jkn_02 = '0';
    }
	
	$SisaStok_Ranap_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 45));
    if($SisaStok_Ranap_Apbd_02 == "" OR $SisaStok_Ranap_Apbd_02 == "-"){
        $SisaStok_Ranap_Apbd_02 = '0';
    }
	
	$SisaStok_Ranap_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 46));
    if($SisaStok_Ranap_Jkn_02 == "" OR $SisaStok_Ranap_Jkn_02 == "-"){
        $SisaStok_Ranap_Jkn_02 = '0';
    }
	
	$SisaStok_Poned_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 47));
    if($SisaStok_Poned_Apbd_02 == "" OR $SisaStok_Poned_Apbd_02 == "-"){
        $SisaStok_Poned_Apbd_02 = '0';
    }
	
	$SisaStok_Poned_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 48));
    if($SisaStok_Poned_Jkn_02 == "" OR $SisaStok_Poned_Jkn_02 == "-"){
        $SisaStok_Poned_Jkn_02 = '0';
    }
	
	$SisaStok_Pustu_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 49));
    if($SisaStok_Pustu_Apbd_02 == "" OR $SisaStok_Pustu_Apbd_02 == "-"){
        $SisaStok_Pustu_Apbd_02 = '0';
    }
	
	$SisaStok_Pustu_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 50));
    if($SisaStok_Pustu_Jkn_02 == "" OR $SisaStok_Pustu_Jkn_02 == "-"){
        $SisaStok_Pustu_Jkn_02 = '0';
    }
	
	$SisaStok_Pusling_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 51));
    if($SisaStok_Pusling_Apbd_02 == "" OR $SisaStok_Pusling_Apbd_02 == "-"){
        $SisaStok_Pusling_Apbd_02 = '0';
    }
	
	$SisaStok_Pusling_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 52));
    if($SisaStok_Pusling_Jkn_02 == "" OR $SisaStok_Pusling_Jkn_02 == "-"){
        $SisaStok_Pusling_Jkn_02 = '0';
    }
	
	$SisaStok_Poli_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 53));
    if($SisaStok_Poli_Apbd_02 == "" OR $SisaStok_Poli_Apbd_02 == "-"){
        $SisaStok_Poli_Apbd_02 = '0';
    }
	
	$SisaStok_Poli_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 54));
    if($SisaStok_Poli_Jkn_02 == "" OR $SisaStok_Poli_Jkn_02 == "-"){
        $SisaStok_Poli_Jkn_02 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_02   = str_replace(array(",","* "), "", $data->val($i, 55));
    if($SisaStok_Lainnya_Apbd_02 == "" OR $SisaStok_Lainnya_Apbd_02 == "-"){
        $SisaStok_Lainnya_Apbd_02 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_02   = str_replace(array(",","* "), "", $data->val($i, 56));
    if($SisaStok_Lainnya_Jkn_02 == "" OR $SisaStok_Lainnya_Jkn_02 == "-"){
        $SisaStok_Lainnya_Jkn_02 = '0';
    }
	
	// Sisa Stok 03
	$SisaStok_Gudang_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 57));
    if($SisaStok_Gudang_Apbd_03 == "" OR $SisaStok_Gudang_Apbd_03 == "-"){
        $SisaStok_Gudang_Apbd_03 = '0';
    }
	
	$SisaStok_Gudang_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 58));
    if($SisaStok_Gudang_Jkn_03 == "" OR $SisaStok_Gudang_Jkn_03 == "-"){
        $SisaStok_Gudang_Jkn_03 = '0';
    }
	
	$SisaStok_Depot_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 59));
    if($SisaStok_Depot_Apbd_03 == "" OR $SisaStok_Depot_Apbd_03 == "-"){
        $SisaStok_Depot_Apbd_03 = '0';
    }
	
	$SisaStok_Depot_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 60));
    if($SisaStok_Depot_Jkn_03 == "" OR $SisaStok_Depot_Jkn_03 == "-"){
        $SisaStok_Depot_Jkn_03 = '0';
    }
	
	$SisaStok_Igd_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 61));
    if($SisaStok_Igd_Apbd_03 == "" OR $SisaStok_Igd_Apbd_03 == "-"){
        $SisaStok_Igd_Apbd_03 = '0';
    }
	
	$SisaStok_Igd_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 62));
    if($SisaStok_Igd_Jkn_03 == "" OR $SisaStok_Igd_Jkn_03 == "-"){
        $SisaStok_Igd_Jkn_03 = '0';
    }
	
	$SisaStok_Ranap_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 63));
    if($SisaStok_Ranap_Apbd_03 == "" OR $SisaStok_Ranap_Apbd_03 == "-"){
        $SisaStok_Ranap_Apbd_03 = '0';
    }
	
	$SisaStok_Ranap_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 64));
    if($SisaStok_Ranap_Jkn_03 == "" OR $SisaStok_Ranap_Jkn_03 == "-"){
        $SisaStok_Ranap_Jkn_03 = '0';
    }
	
	$SisaStok_Poned_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 65));
    if($SisaStok_Poned_Apbd_03 == "" OR $SisaStok_Poned_Apbd_03 == "-"){
        $SisaStok_Poned_Apbd_03 = '0';
    }
	
	$SisaStok_Poned_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 66));
    if($SisaStok_Poned_Jkn_03 == "" OR $SisaStok_Poned_Jkn_03 == "-"){
        $SisaStok_Poned_Jkn_03 = '0';
    }
	
	$SisaStok_Pustu_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 67));
    if($SisaStok_Pustu_Apbd_03 == "" OR $SisaStok_Pustu_Apbd_03 == "-"){
        $SisaStok_Pustu_Apbd_03 = '0';
    }
	
	$SisaStok_Pustu_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 68));
    if($SisaStok_Pustu_Jkn_03 == "" OR $SisaStok_Pustu_Jkn_03 == "-"){
        $SisaStok_Pustu_Jkn_03 = '0';
    }
	
	$SisaStok_Pusling_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 69));
    if($SisaStok_Pusling_Apbd_03 == "" OR $SisaStok_Pusling_Apbd_03 == "-"){
        $SisaStok_Pusling_Apbd_03 = '0';
    }
	
	$SisaStok_Pusling_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 70));
    if($SisaStok_Pusling_Jkn_03 == "" OR $SisaStok_Pusling_Jkn_03 == "-"){
        $SisaStok_Pusling_Jkn_03 = '0';
    }
	
	$SisaStok_Poli_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 71));
    if($SisaStok_Poli_Apbd_03 == "" OR $SisaStok_Poli_Apbd_03 == "-"){
        $SisaStok_Poli_Apbd_03 = '0';
    }
	
	$SisaStok_Poli_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 72));
    if($SisaStok_Poli_Jkn_03 == "" OR $SisaStok_Poli_Jkn_03 == "-"){
        $SisaStok_Poli_Jkn_03 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_03   = str_replace(array(",","* "), "", $data->val($i, 73));
    if($SisaStok_Lainnya_Apbd_03 == "" OR $SisaStok_Lainnya_Apbd_03 == "-"){
        $SisaStok_Lainnya_Apbd_03 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_03   = str_replace(array(",","* "), "", $data->val($i, 74));
    if($SisaStok_Lainnya_Jkn_03 == "" OR $SisaStok_Lainnya_Jkn_03 == "-"){
        $SisaStok_Lainnya_Jkn_03 = '0';
    }
	
	// Sisa Stok 04
	$SisaStok_Gudang_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 75));
    if($SisaStok_Gudang_Apbd_04 == "" OR $SisaStok_Gudang_Apbd_04 == "-"){
        $SisaStok_Gudang_Apbd_04 = '0';
    }
	
	$SisaStok_Gudang_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 76));
    if($SisaStok_Gudang_Jkn_04 == "" OR $SisaStok_Gudang_Jkn_04 == "-"){
        $SisaStok_Gudang_Jkn_04 = '0';
    }
	
	$SisaStok_Depot_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 77));
    if($SisaStok_Depot_Apbd_04 == "" OR $SisaStok_Depot_Apbd_04 == "-"){
        $SisaStok_Depot_Apbd_04 = '0';
    }
	
	$SisaStok_Depot_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 78));
    if($SisaStok_Depot_Jkn_04 == "" OR $SisaStok_Depot_Jkn_04 == "-"){
        $SisaStok_Depot_Jkn_04 = '0';
    }
	
	$SisaStok_Igd_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 79));
    if($SisaStok_Igd_Apbd_04 == "" OR $SisaStok_Igd_Apbd_04 == "-"){
        $SisaStok_Igd_Apbd_04 = '0';
    }
	
	$SisaStok_Igd_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 80));
    if($SisaStok_Igd_Jkn_04 == "" OR $SisaStok_Igd_Jkn_04 == "-"){
        $SisaStok_Igd_Jkn_04 = '0';
    }
	
	$SisaStok_Ranap_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 81));
    if($SisaStok_Ranap_Apbd_04 == "" OR $SisaStok_Ranap_Apbd_04 == "-"){
        $SisaStok_Ranap_Apbd_04 = '0';
    }
	
	$SisaStok_Ranap_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 82));
    if($SisaStok_Ranap_Jkn_04 == "" OR $SisaStok_Ranap_Jkn_04 == "-"){
        $SisaStok_Ranap_Jkn_04 = '0';
    }
	
	$SisaStok_Poned_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 83));
    if($SisaStok_Poned_Apbd_04 == "" OR $SisaStok_Poned_Apbd_04 == "-"){
        $SisaStok_Poned_Apbd_04 = '0';
    }
	
	$SisaStok_Poned_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 84));
    if($SisaStok_Poned_Jkn_04 == "" OR $SisaStok_Poned_Jkn_04 == "-"){
        $SisaStok_Poned_Jkn_04 = '0';
    }
	
	$SisaStok_Pustu_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 85));
    if($SisaStok_Pustu_Apbd_04 == "" OR $SisaStok_Pustu_Apbd_04 == "-"){
        $SisaStok_Pustu_Apbd_04 = '0';
    }
	
	$SisaStok_Pustu_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 86));
    if($SisaStok_Pustu_Jkn_04 == "" OR $SisaStok_Pustu_Jkn_04 == "-"){
        $SisaStok_Pustu_Jkn_04 = '0';
    }
	
	$SisaStok_Pusling_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 87));
    if($SisaStok_Pusling_Apbd_04 == "" OR $SisaStok_Pusling_Apbd_04 == "-"){
        $SisaStok_Pusling_Apbd_04 = '0';
    }
	
	$SisaStok_Pusling_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 88));
    if($SisaStok_Pusling_Jkn_04 == "" OR $SisaStok_Pusling_Jkn_04 == "-"){
        $SisaStok_Pusling_Jkn_04 = '0';
    }
	
	$SisaStok_Poli_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 89));
    if($SisaStok_Poli_Apbd_04 == "" OR $SisaStok_Poli_Apbd_04 == "-"){
        $SisaStok_Poli_Apbd_04 = '0';
    }
	
	$SisaStok_Poli_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 90));
    if($SisaStok_Poli_Jkn_04 == "" OR $SisaStok_Poli_Jkn_04 == "-"){
        $SisaStok_Poli_Jkn_04 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_04   = str_replace(array(",","* "), "", $data->val($i, 91));
    if($SisaStok_Lainnya_Apbd_04 == "" OR $SisaStok_Lainnya_Apbd_04 == "-"){
        $SisaStok_Lainnya_Apbd_04 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_04   = str_replace(array(",","* "), "", $data->val($i, 92));
    if($SisaStok_Lainnya_Jkn_04 == "" OR $SisaStok_Lainnya_Jkn_04 == "-"){
        $SisaStok_Lainnya_Jkn_04 = '0';
    }
	
	// Sisa Stok 05
	$SisaStok_Gudang_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 93));
    if($SisaStok_Gudang_Apbd_05 == "" OR $SisaStok_Gudang_Apbd_05 == "-"){
        $SisaStok_Gudang_Apbd_05 = '0';
    }
	
	$SisaStok_Gudang_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 94));
    if($SisaStok_Gudang_Jkn_05 == "" OR $SisaStok_Gudang_Jkn_05 == "-"){
        $SisaStok_Gudang_Jkn_05 = '0';
    }
	
	$SisaStok_Depot_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 95));
    if($SisaStok_Depot_Apbd_05 == "" OR $SisaStok_Depot_Apbd_05 == "-"){
        $SisaStok_Depot_Apbd_05 = '0';
    }
	
	$SisaStok_Depot_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 96));
    if($SisaStok_Depot_Jkn_05 == "" OR $SisaStok_Depot_Jkn_05 == "-"){
        $SisaStok_Depot_Jkn_05 = '0';
    }
	
	$SisaStok_Igd_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 97));
    if($SisaStok_Igd_Apbd_05 == "" OR $SisaStok_Igd_Apbd_05 == "-"){
        $SisaStok_Igd_Apbd_05 = '0';
    }
	
	$SisaStok_Igd_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 98));
    if($SisaStok_Igd_Jkn_05 == "" OR $SisaStok_Igd_Jkn_05 == "-"){
        $SisaStok_Igd_Jkn_05 = '0';
    }
	
	$SisaStok_Ranap_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 99));
    if($SisaStok_Ranap_Apbd_05 == "" OR $SisaStok_Ranap_Apbd_05 == "-"){
        $SisaStok_Ranap_Apbd_05 = '0';
    }
	
	$SisaStok_Ranap_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 100));
    if($SisaStok_Ranap_Jkn_05 == "" OR $SisaStok_Ranap_Jkn_05 == "-"){
        $SisaStok_Ranap_Jkn_05 = '0';
    }
	
	$SisaStok_Poned_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 101));
    if($SisaStok_Poned_Apbd_05 == "" OR $SisaStok_Poned_Apbd_05 == "-"){
        $SisaStok_Poned_Apbd_05 = '0';
    }
	
	$SisaStok_Poned_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 102));
    if($SisaStok_Poned_Jkn_05 == "" OR $SisaStok_Poned_Jkn_05 == "-"){
        $SisaStok_Poned_Jkn_05 = '0';
    }
	
	$SisaStok_Pustu_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 103));
    if($SisaStok_Pustu_Apbd_05 == "" OR $SisaStok_Pustu_Apbd_05 == "-"){
        $SisaStok_Pustu_Apbd_05 = '0';
    }
	
	$SisaStok_Pustu_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 104));
    if($SisaStok_Pustu_Jkn_05 == "" OR $SisaStok_Pustu_Jkn_05 == "-"){
        $SisaStok_Pustu_Jkn_05 = '0';
    }
	
	$SisaStok_Pusling_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 105));
    if($SisaStok_Pusling_Apbd_05 == "" OR $SisaStok_Pusling_Apbd_05 == "-"){
        $SisaStok_Pusling_Apbd_05 = '0';
    }
	
	$SisaStok_Pusling_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 106));
    if($SisaStok_Pusling_Jkn_05 == "" OR $SisaStok_Pusling_Jkn_05 == "-"){
        $SisaStok_Pusling_Jkn_05 = '0';
    }
	
	$SisaStok_Poli_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 107));
    if($SisaStok_Poli_Apbd_05 == "" OR $SisaStok_Poli_Apbd_05 == "-"){
        $SisaStok_Poli_Apbd_05 = '0';
    }
	
	$SisaStok_Poli_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 108));
    if($SisaStok_Poli_Jkn_05 == "" OR $SisaStok_Poli_Jkn_05 == "-"){
        $SisaStok_Poli_Jkn_05 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_05   = str_replace(array(",","* "), "", $data->val($i, 109));
    if($SisaStok_Lainnya_Apbd_05 == "" OR $SisaStok_Lainnya_Apbd_05 == "-"){
        $SisaStok_Lainnya_Apbd_05 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_05   = str_replace(array(",","* "), "", $data->val($i, 110));
    if($SisaStok_Lainnya_Jkn_05 == "" OR $SisaStok_Lainnya_Jkn_05 == "-"){
        $SisaStok_Lainnya_Jkn_05 = '0';
    }
	
	// Sisa Stok 06
	$SisaStok_Gudang_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 111));
    if($SisaStok_Gudang_Apbd_06 == "" OR $SisaStok_Gudang_Apbd_06 == "-"){
        $SisaStok_Gudang_Apbd_06 = '0';
    }
	
	$SisaStok_Gudang_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 112));
    if($SisaStok_Gudang_Jkn_06 == "" OR $SisaStok_Gudang_Jkn_06 == "-"){
        $SisaStok_Gudang_Jkn_06 = '0';
    }
	
	$SisaStok_Depot_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 113));
    if($SisaStok_Depot_Apbd_06 == "" OR $SisaStok_Depot_Apbd_06 == "-"){
        $SisaStok_Depot_Apbd_06 = '0';
    }
	
	$SisaStok_Depot_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 114));
    if($SisaStok_Depot_Jkn_06 == "" OR $SisaStok_Depot_Jkn_06 == "-"){
        $SisaStok_Depot_Jkn_06 = '0';
    }
	
	$SisaStok_Igd_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 115));
    if($SisaStok_Igd_Apbd_06 == "" OR $SisaStok_Igd_Apbd_06 == "-"){
        $SisaStok_Igd_Apbd_06 = '0';
    }
	
	$SisaStok_Igd_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 116));
    if($SisaStok_Igd_Jkn_06 == "" OR $SisaStok_Igd_Jkn_06 == "-"){
        $SisaStok_Igd_Jkn_06 = '0';
    }
	
	$SisaStok_Ranap_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 117));
    if($SisaStok_Ranap_Apbd_06 == "" OR $SisaStok_Ranap_Apbd_06 == "-"){
        $SisaStok_Ranap_Apbd_06 = '0';
    }
	
	$SisaStok_Ranap_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 118));
    if($SisaStok_Ranap_Jkn_06 == "" OR $SisaStok_Ranap_Jkn_06 == "-"){
        $SisaStok_Ranap_Jkn_06 = '0';
    }
	
	$SisaStok_Poned_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 119));
    if($SisaStok_Poned_Apbd_06 == "" OR $SisaStok_Poned_Apbd_06 == "-"){
        $SisaStok_Poned_Apbd_06 = '0';
    }
	
	$SisaStok_Poned_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 120));
    if($SisaStok_Poned_Jkn_06 == "" OR $SisaStok_Poned_Jkn_06 == "-"){
        $SisaStok_Poned_Jkn_06 = '0';
    }
	
	$SisaStok_Pustu_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 121));
    if($SisaStok_Pustu_Apbd_06 == "" OR $SisaStok_Pustu_Apbd_06 == "-"){
        $SisaStok_Pustu_Apbd_06 = '0';
    }
	
	$SisaStok_Pustu_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 122));
    if($SisaStok_Pustu_Jkn_06 == "" OR $SisaStok_Pustu_Jkn_06 == "-"){
        $SisaStok_Pustu_Jkn_06 = '0';
    }
	
	$SisaStok_Pusling_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 123));
    if($SisaStok_Pusling_Apbd_06 == "" OR $SisaStok_Pusling_Apbd_06 == "-"){
        $SisaStok_Pusling_Apbd_06 = '0';
    }
	
	$SisaStok_Pusling_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 124));
    if($SisaStok_Pusling_Jkn_06 == "" OR $SisaStok_Pusling_Jkn_06 == "-"){
        $SisaStok_Pusling_Jkn_06 = '0';
    }
	
	$SisaStok_Poli_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 125));
    if($SisaStok_Poli_Apbd_06 == "" OR $SisaStok_Poli_Apbd_06 == "-"){
        $SisaStok_Poli_Apbd_06 = '0';
    }
	
	$SisaStok_Poli_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 126));
    if($SisaStok_Poli_Jkn_06 == "" OR $SisaStok_Poli_Jkn_06 == "-"){
        $SisaStok_Poli_Jkn_06 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_06   = str_replace(array(",","* "), "", $data->val($i, 127));
    if($SisaStok_Lainnya_Apbd_06 == "" OR $SisaStok_Lainnya_Apbd_06 == "-"){
        $SisaStok_Lainnya_Apbd_06 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_06   = str_replace(array(",","* "), "", $data->val($i, 128));
    if($SisaStok_Lainnya_Jkn_06 == "" OR $SisaStok_Lainnya_Jkn_06 == "-"){
        $SisaStok_Lainnya_Jkn_06 = '0';
    }
	
	// Sisa Stok 07
	$SisaStok_Gudang_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 129));
    if($SisaStok_Gudang_Apbd_07 == "" OR $SisaStok_Gudang_Apbd_07 == "-"){
        $SisaStok_Gudang_Apbd_07 = '0';
    }
	
	$SisaStok_Gudang_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 130));
    if($SisaStok_Gudang_Jkn_07 == "" OR $SisaStok_Gudang_Jkn_07 == "-"){
        $SisaStok_Gudang_Jkn_07 = '0';
    }
	
	$SisaStok_Depot_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 131));
    if($SisaStok_Depot_Apbd_07 == "" OR $SisaStok_Depot_Apbd_07 == "-"){
        $SisaStok_Depot_Apbd_07 = '0';
    }
	
	$SisaStok_Depot_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 132));
    if($SisaStok_Depot_Jkn_07 == "" OR $SisaStok_Depot_Jkn_07 == "-"){
        $SisaStok_Depot_Jkn_07 = '0';
    }
	
	$SisaStok_Igd_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 133));
    if($SisaStok_Igd_Apbd_07 == "" OR $SisaStok_Igd_Apbd_07 == "-"){
        $SisaStok_Igd_Apbd_07 = '0';
    }
	
	$SisaStok_Igd_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 134));
    if($SisaStok_Igd_Jkn_07 == "" OR $SisaStok_Igd_Jkn_07 == "-"){
        $SisaStok_Igd_Jkn_07 = '0';
    }
	
	$SisaStok_Ranap_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 135));
    if($SisaStok_Ranap_Apbd_07 == "" OR $SisaStok_Ranap_Apbd_07 == "-"){
        $SisaStok_Ranap_Apbd_07 = '0';
    }
	
	$SisaStok_Ranap_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 136));
    if($SisaStok_Ranap_Jkn_07 == "" OR $SisaStok_Ranap_Jkn_07 == "-"){
        $SisaStok_Ranap_Jkn_07 = '0';
    }
	
	$SisaStok_Poned_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 137));
    if($SisaStok_Poned_Apbd_07 == "" OR $SisaStok_Poned_Apbd_07 == "-"){
        $SisaStok_Poned_Apbd_07 = '0';
    }
	
	$SisaStok_Poned_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 138));
    if($SisaStok_Poned_Jkn_07 == "" OR $SisaStok_Poned_Jkn_07 == "-"){
        $SisaStok_Poned_Jkn_07 = '0';
    }
	
	$SisaStok_Pustu_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 139));
    if($SisaStok_Pustu_Apbd_07 == "" OR $SisaStok_Pustu_Apbd_07 == "-"){
        $SisaStok_Pustu_Apbd_07 = '0';
    }
	
	$SisaStok_Pustu_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 140));
    if($SisaStok_Pustu_Jkn_07 == "" OR $SisaStok_Pustu_Jkn_07 == "-"){
        $SisaStok_Pustu_Jkn_07 = '0';
    }
	
	$SisaStok_Pusling_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 141));
    if($SisaStok_Pusling_Apbd_07 == "" OR $SisaStok_Pusling_Apbd_07 == "-"){
        $SisaStok_Pusling_Apbd_07 = '0';
    }
	
	$SisaStok_Pusling_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 142));
    if($SisaStok_Pusling_Jkn_07 == "" OR $SisaStok_Pusling_Jkn_07 == "-"){
        $SisaStok_Pusling_Jkn_07 = '0';
    }
	
	$SisaStok_Poli_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 143));
    if($SisaStok_Poli_Apbd_07 == "" OR $SisaStok_Poli_Apbd_07 == "-"){
        $SisaStok_Poli_Apbd_07 = '0';
    }
	
	$SisaStok_Poli_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 144));
    if($SisaStok_Poli_Jkn_07 == "" OR $SisaStok_Poli_Jkn_07 == "-"){
        $SisaStok_Poli_Jkn_07 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_07   = str_replace(array(",","* "), "", $data->val($i, 145));
    if($SisaStok_Lainnya_Apbd_07 == "" OR $SisaStok_Lainnya_Apbd_07 == "-"){
        $SisaStok_Lainnya_Apbd_07 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_07   = str_replace(array(",","* "), "", $data->val($i, 146));
    if($SisaStok_Lainnya_Jkn_07 == "" OR $SisaStok_Lainnya_Jkn_07 == "-"){
        $SisaStok_Lainnya_Jkn_07 = '0';
    }
	
	// Sisa Stok 08
	$SisaStok_Gudang_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 147));
    if($SisaStok_Gudang_Apbd_08 == "" OR $SisaStok_Gudang_Apbd_08 == "-"){
        $SisaStok_Gudang_Apbd_08 = '0';
    }
	
	$SisaStok_Gudang_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 148));
    if($SisaStok_Gudang_Jkn_08 == "" OR $SisaStok_Gudang_Jkn_08 == "-"){
        $SisaStok_Gudang_Jkn_08 = '0';
    }
	
	$SisaStok_Depot_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 149));
    if($SisaStok_Depot_Apbd_08 == "" OR $SisaStok_Depot_Apbd_08 == "-"){
        $SisaStok_Depot_Apbd_08 = '0';
    }
	
	$SisaStok_Depot_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 150));
    if($SisaStok_Depot_Jkn_08 == "" OR $SisaStok_Depot_Jkn_08 == "-"){
        $SisaStok_Depot_Jkn_08 = '0';
    }
	
	$SisaStok_Igd_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 151));
    if($SisaStok_Igd_Apbd_08 == "" OR $SisaStok_Igd_Apbd_08 == "-"){
        $SisaStok_Igd_Apbd_08 = '0';
    }
	
	$SisaStok_Igd_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 152));
    if($SisaStok_Igd_Jkn_08 == "" OR $SisaStok_Igd_Jkn_08 == "-"){
        $SisaStok_Igd_Jkn_08 = '0';
    }
	
	$SisaStok_Ranap_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 153));
    if($SisaStok_Ranap_Apbd_08 == "" OR $SisaStok_Ranap_Apbd_08 == "-"){
        $SisaStok_Ranap_Apbd_08 = '0';
    }
	
	$SisaStok_Ranap_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 154));
    if($SisaStok_Ranap_Jkn_08 == "" OR $SisaStok_Ranap_Jkn_08 == "-"){
        $SisaStok_Ranap_Jkn_08 = '0';
    }
	
	$SisaStok_Poned_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 155));
    if($SisaStok_Poned_Apbd_08 == "" OR $SisaStok_Poned_Apbd_08 == "-"){
        $SisaStok_Poned_Apbd_08 = '0';
    }
	
	$SisaStok_Poned_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 156));
    if($SisaStok_Poned_Jkn_08 == "" OR $SisaStok_Poned_Jkn_08 == "-"){
        $SisaStok_Poned_Jkn_08 = '0';
    }
	
	$SisaStok_Pustu_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 157));
    if($SisaStok_Pustu_Apbd_08 == "" OR $SisaStok_Pustu_Apbd_08 == "-"){
        $SisaStok_Pustu_Apbd_08 = '0';
    }
	
	$SisaStok_Pustu_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 158));
    if($SisaStok_Pustu_Jkn_08 == "" OR $SisaStok_Pustu_Jkn_08 == "-"){
        $SisaStok_Pustu_Jkn_08 = '0';
    }
	
	$SisaStok_Pusling_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 159));
    if($SisaStok_Pusling_Apbd_08 == "" OR $SisaStok_Pusling_Apbd_08 == "-"){
        $SisaStok_Pusling_Apbd_08 = '0';
    }
	
	$SisaStok_Pusling_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 160));
    if($SisaStok_Pusling_Jkn_08 == "" OR $SisaStok_Pusling_Jkn_08 == "-"){
        $SisaStok_Pusling_Jkn_08 = '0';
    }
	
	$SisaStok_Poli_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 161));
    if($SisaStok_Poli_Apbd_08 == "" OR $SisaStok_Poli_Apbd_08 == "-"){
        $SisaStok_Poli_Apbd_08 = '0';
    }
	
	$SisaStok_Poli_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 162));
    if($SisaStok_Poli_Jkn_08 == "" OR $SisaStok_Poli_Jkn_08 == "-"){
        $SisaStok_Poli_Jkn_08 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_08   = str_replace(array(",","* "), "", $data->val($i, 163));
    if($SisaStok_Lainnya_Apbd_08 == "" OR $SisaStok_Lainnya_Apbd_08 == "-"){
        $SisaStok_Lainnya_Apbd_08 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_08   = str_replace(array(",","* "), "", $data->val($i, 164));
    if($SisaStok_Lainnya_Jkn_08 == "" OR $SisaStok_Lainnya_Jkn_08 == "-"){
        $SisaStok_Lainnya_Jkn_08 = '0';
    }
	
	// Sisa Stok 09
	$SisaStok_Gudang_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 165));
    if($SisaStok_Gudang_Apbd_09 == "" OR $SisaStok_Gudang_Apbd_09 == "-"){
        $SisaStok_Gudang_Apbd_09 = '0';
    }
	
	$SisaStok_Gudang_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 166));
    if($SisaStok_Gudang_Jkn_09 == "" OR $SisaStok_Gudang_Jkn_09 == "-"){
        $SisaStok_Gudang_Jkn_09 = '0';
    }
	
	$SisaStok_Depot_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 167));
    if($SisaStok_Depot_Apbd_09 == "" OR $SisaStok_Depot_Apbd_09 == "-"){
        $SisaStok_Depot_Apbd_09 = '0';
    }
	
	$SisaStok_Depot_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 168));
    if($SisaStok_Depot_Jkn_09 == "" OR $SisaStok_Depot_Jkn_09 == "-"){
        $SisaStok_Depot_Jkn_09 = '0';
    }
	
	$SisaStok_Igd_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 169));
    if($SisaStok_Igd_Apbd_09 == "" OR $SisaStok_Igd_Apbd_09 == "-"){
        $SisaStok_Igd_Apbd_09 = '0';
    }
	
	$SisaStok_Igd_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 170));
    if($SisaStok_Igd_Jkn_09 == "" OR $SisaStok_Igd_Jkn_09 == "-"){
        $SisaStok_Igd_Jkn_09 = '0';
    }
	
	$SisaStok_Ranap_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 171));
    if($SisaStok_Ranap_Apbd_09 == "" OR $SisaStok_Ranap_Apbd_09 == "-"){
        $SisaStok_Ranap_Apbd_09 = '0';
    }
	
	$SisaStok_Ranap_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 172));
    if($SisaStok_Ranap_Jkn_09 == "" OR $SisaStok_Ranap_Jkn_09 == "-"){
        $SisaStok_Ranap_Jkn_09 = '0';
    }
	
	$SisaStok_Poned_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 173));
    if($SisaStok_Poned_Apbd_09 == "" OR $SisaStok_Poned_Apbd_09 == "-"){
        $SisaStok_Poned_Apbd_09 = '0';
    }
	
	$SisaStok_Poned_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 174));
    if($SisaStok_Poned_Jkn_09 == "" OR $SisaStok_Poned_Jkn_09 == "-"){
        $SisaStok_Poned_Jkn_09 = '0';
    }
	
	$SisaStok_Pustu_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 175));
    if($SisaStok_Pustu_Apbd_09 == "" OR $SisaStok_Pustu_Apbd_09 == "-"){
        $SisaStok_Pustu_Apbd_09 = '0';
    }
	
	$SisaStok_Pustu_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 176));
    if($SisaStok_Pustu_Jkn_09 == "" OR $SisaStok_Pustu_Jkn_09 == "-"){
        $SisaStok_Pustu_Jkn_09 = '0';
    }
	
	$SisaStok_Pusling_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 177));
    if($SisaStok_Pusling_Apbd_09 == "" OR $SisaStok_Pusling_Apbd_09 == "-"){
        $SisaStok_Pusling_Apbd_09 = '0';
    }
	
	$SisaStok_Pusling_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 178));
    if($SisaStok_Pusling_Jkn_09 == "" OR $SisaStok_Pusling_Jkn_09 == "-"){
        $SisaStok_Pusling_Jkn_09 = '0';
    }
	
	$SisaStok_Poli_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 179));
    if($SisaStok_Poli_Apbd_09 == "" OR $SisaStok_Poli_Apbd_09 == "-"){
        $SisaStok_Poli_Apbd_09 = '0';
    }
	
	$SisaStok_Poli_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 180));
    if($SisaStok_Poli_Jkn_09 == "" OR $SisaStok_Poli_Jkn_09 == "-"){
        $SisaStok_Poli_Jkn_09 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_09   = str_replace(array(",","* "), "", $data->val($i, 181));
    if($SisaStok_Lainnya_Apbd_09 == "" OR $SisaStok_Lainnya_Apbd_09 == "-"){
        $SisaStok_Lainnya_Apbd_09 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_09   = str_replace(array(",","* "), "", $data->val($i, 182));
    if($SisaStok_Lainnya_Jkn_09 == "" OR $SisaStok_Lainnya_Jkn_09 == "-"){
        $SisaStok_Lainnya_Jkn_09 = '0';
	}	
		
	// Sisa Stok 10
	$SisaStok_Gudang_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 183));
    if($SisaStok_Gudang_Apbd_10 == "" OR $SisaStok_Gudang_Apbd_10 == "-"){
        $SisaStok_Gudang_Apbd_10 = '0';
    }
	
	$SisaStok_Gudang_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 184));
    if($SisaStok_Gudang_Jkn_10 == "" OR $SisaStok_Gudang_Jkn_10 == "-"){
        $SisaStok_Gudang_Jkn_10 = '0';
    }
	
	$SisaStok_Depot_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 185));
    if($SisaStok_Depot_Apbd_10 == "" OR $SisaStok_Depot_Apbd_10 == "-"){
        $SisaStok_Depot_Apbd_10 = '0';
    }
	
	$SisaStok_Depot_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 186));
    if($SisaStok_Depot_Jkn_10 == "" OR $SisaStok_Depot_Jkn_10 == "-"){
        $SisaStok_Depot_Jkn_10 = '0';
    }
	
	$SisaStok_Igd_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 187));
    if($SisaStok_Igd_Apbd_10 == "" OR $SisaStok_Igd_Apbd_10 == "-"){
        $SisaStok_Igd_Apbd_10 = '0';
    }
	
	$SisaStok_Igd_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 188));
    if($SisaStok_Igd_Jkn_10 == "" OR $SisaStok_Igd_Jkn_10 == "-"){
        $SisaStok_Igd_Jkn_10 = '0';
    }
	
	$SisaStok_Ranap_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 189));
    if($SisaStok_Ranap_Apbd_10 == "" OR $SisaStok_Ranap_Apbd_10 == "-"){
        $SisaStok_Ranap_Apbd_10 = '0';
    }
	
	$SisaStok_Ranap_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 190));
    if($SisaStok_Ranap_Jkn_10 == "" OR $SisaStok_Ranap_Jkn_10 == "-"){
        $SisaStok_Ranap_Jkn_10 = '0';
    }
	
	$SisaStok_Poned_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 191));
    if($SisaStok_Poned_Apbd_10 == "" OR $SisaStok_Poned_Apbd_10 == "-"){
        $SisaStok_Poned_Apbd_10 = '0';
    }
	
	$SisaStok_Poned_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 192));
    if($SisaStok_Poned_Jkn_10 == "" OR $SisaStok_Poned_Jkn_10 == "-"){
        $SisaStok_Poned_Jkn_10 = '0';
    }
	
	$SisaStok_Pustu_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 193));
    if($SisaStok_Pustu_Apbd_10 == "" OR $SisaStok_Pustu_Apbd_10 == "-"){
        $SisaStok_Pustu_Apbd_10 = '0';
    }
	
	$SisaStok_Pustu_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 194));
    if($SisaStok_Pustu_Jkn_10 == "" OR $SisaStok_Pustu_Jkn_10 == "-"){
        $SisaStok_Pustu_Jkn_10 = '0';
    }
	
	$SisaStok_Pusling_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 195));
    if($SisaStok_Pusling_Apbd_10 == "" OR $SisaStok_Pusling_Apbd_10 == "-"){
        $SisaStok_Pusling_Apbd_10 = '0';
    }
	
	$SisaStok_Pusling_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 196));
    if($SisaStok_Pusling_Jkn_10 == "" OR $SisaStok_Pusling_Jkn_10 == "-"){
        $SisaStok_Pusling_Jkn_10 = '0';
    }
	
	$SisaStok_Poli_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 197));
    if($SisaStok_Poli_Apbd_10 == "" OR $SisaStok_Poli_Apbd_10 == "-"){
        $SisaStok_Poli_Apbd_10 = '0';
    }
	
	$SisaStok_Poli_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 198));
    if($SisaStok_Poli_Jkn_10 == "" OR $SisaStok_Poli_Jkn_10 == "-"){
        $SisaStok_Poli_Jkn_10 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_10   = str_replace(array(",","* "), "", $data->val($i, 199));
    if($SisaStok_Lainnya_Apbd_10 == "" OR $SisaStok_Lainnya_Apbd_10 == "-"){
        $SisaStok_Lainnya_Apbd_10 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_10   = str_replace(array(",","* "), "", $data->val($i, 200));
    if($SisaStok_Lainnya_Jkn_10 == "" OR $SisaStok_Lainnya_Jkn_10 == "-"){
        $SisaStok_Lainnya_Jkn_10 = '0';
    }
	
	// Sisa Stok 11
	$SisaStok_Gudang_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 201));
    if($SisaStok_Gudang_Apbd_11 == "" OR $SisaStok_Gudang_Apbd_11 == "-"){
        $SisaStok_Gudang_Apbd_11 = '0';
    }
	
	$SisaStok_Gudang_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 202));
    if($SisaStok_Gudang_Jkn_11 == "" OR $SisaStok_Gudang_Jkn_11 == "-"){
        $SisaStok_Gudang_Jkn_11 = '0';
    }
	
	$SisaStok_Depot_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 203));
    if($SisaStok_Depot_Apbd_11 == "" OR $SisaStok_Depot_Apbd_11 == "-"){
        $SisaStok_Depot_Apbd_11 = '0';
    }
	
	$SisaStok_Depot_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 204));
    if($SisaStok_Depot_Jkn_11 == "" OR $SisaStok_Depot_Jkn_11 == "-"){
        $SisaStok_Depot_Jkn_11 = '0';
    }
	
	$SisaStok_Igd_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 205));
    if($SisaStok_Igd_Apbd_11 == "" OR $SisaStok_Igd_Apbd_11 == "-"){
        $SisaStok_Igd_Apbd_11 = '0';
    }
	
	$SisaStok_Igd_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 206));
    if($SisaStok_Igd_Jkn_11 == "" OR $SisaStok_Igd_Jkn_11 == "-"){
        $SisaStok_Igd_Jkn_11 = '0';
    }
	
	$SisaStok_Ranap_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 207));
    if($SisaStok_Ranap_Apbd_11 == "" OR $SisaStok_Ranap_Apbd_11 == "-"){
        $SisaStok_Ranap_Apbd_11 = '0';
    }
	
	$SisaStok_Ranap_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 208));
    if($SisaStok_Ranap_Jkn_11 == "" OR $SisaStok_Ranap_Jkn_11 == "-"){
        $SisaStok_Ranap_Jkn_11 = '0';
    }
	
	$SisaStok_Poned_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 209));
    if($SisaStok_Poned_Apbd_11 == "" OR $SisaStok_Poned_Apbd_11 == "-"){
        $SisaStok_Poned_Apbd_11 = '0';
    }
	
	$SisaStok_Poned_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 210));
    if($SisaStok_Poned_Jkn_11 == "" OR $SisaStok_Poned_Jkn_11 == "-"){
        $SisaStok_Poned_Jkn_11 = '0';
    }
	
	$SisaStok_Pustu_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 211));
    if($SisaStok_Pustu_Apbd_11 == "" OR $SisaStok_Pustu_Apbd_11 == "-"){
        $SisaStok_Pustu_Apbd_11 = '0';
    }
	
	$SisaStok_Pustu_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 212));
    if($SisaStok_Pustu_Jkn_11 == "" OR $SisaStok_Pustu_Jkn_11 == "-"){
        $SisaStok_Pustu_Jkn_11 = '0';
    }
	
	$SisaStok_Pusling_Apbd_11  = str_replace(array(",","* "), "", $data->val($i, 213));
    if($SisaStok_Pusling_Apbd_11 == "" OR $SisaStok_Pusling_Apbd_11 == "-"){
        $SisaStok_Pusling_Apbd_11 = '0';
    }
	
	$SisaStok_Pusling_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 214));
    if($SisaStok_Pusling_Jkn_11 == "" OR $SisaStok_Pusling_Jkn_11 == "-"){
        $SisaStok_Pusling_Jkn_11 = '0';
    }
	
	$SisaStok_Poli_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 215));
    if($SisaStok_Poli_Apbd_11 == "" OR $SisaStok_Poli_Apbd_11 == "-"){
        $SisaStok_Poli_Apbd_11 = '0';
    }
	
	$SisaStok_Poli_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 216));
    if($SisaStok_Poli_Jkn_11 == "" OR $SisaStok_Poli_Jkn_11 == "-"){
        $SisaStok_Poli_Jkn_11 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_11   = str_replace(array(",","* "), "", $data->val($i, 217));
    if($SisaStok_Lainnya_Apbd_11 == "" OR $SisaStok_Lainnya_Apbd_11 == "-"){
        $SisaStok_Lainnya_Apbd_11 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_11   = str_replace(array(",","* "), "", $data->val($i, 218));
    if($SisaStok_Lainnya_Jkn_11 == "" OR $SisaStok_Lainnya_Jkn_11 == "-"){
        $SisaStok_Lainnya_Jkn_11 = '0';
    }
	
	// Sisa Stok 12
	$SisaStok_Gudang_Apbd_12  = str_replace(array(",","* "), "", $data->val($i, 219));
    if($SisaStok_Gudang_Apbd_12 == "" OR $SisaStok_Gudang_Apbd_12 == "-"){
        $SisaStok_Gudang_Apbd_12 = '0';
    }
	
	$SisaStok_Gudang_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 220));
    if($SisaStok_Gudang_Jkn_12 == "" OR $SisaStok_Gudang_Jkn_12 == "-"){
        $SisaStok_Gudang_Jkn_12 = '0';
    }
	
	$SisaStok_Depot_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 221));
    if($SisaStok_Depot_Apbd_12 == "" OR $SisaStok_Depot_Apbd_12 == "-"){
        $SisaStok_Depot_Apbd_12 = '0';
    }
	
	$SisaStok_Depot_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 222));
    if($SisaStok_Depot_Jkn_12 == "" OR $SisaStok_Depot_Jkn_12 == "-"){
        $SisaStok_Depot_Jkn_12 = '0';
    }
	
	$SisaStok_Igd_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 223));
    if($SisaStok_Igd_Apbd_12 == "" OR $SisaStok_Igd_Apbd_12 == "-"){
        $SisaStok_Igd_Apbd_12 = '0';
    }
	
	$SisaStok_Igd_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 224));
    if($SisaStok_Igd_Jkn_12 == "" OR $SisaStok_Igd_Jkn_12 == "-"){
        $SisaStok_Igd_Jkn_12 = '0';
    }
	
	$SisaStok_Ranap_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 225));
    if($SisaStok_Ranap_Apbd_12 == "" OR $SisaStok_Ranap_Apbd_12 == "-"){
        $SisaStok_Ranap_Apbd_12 = '0';
    }
	
	$SisaStok_Ranap_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 226));
    if($SisaStok_Ranap_Jkn_12 == "" OR $SisaStok_Ranap_Jkn_12 == "-"){
        $SisaStok_Ranap_Jkn_12 = '0';
    }
	
	$SisaStok_Poned_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 227));
    if($SisaStok_Poned_Apbd_12 == "" OR $SisaStok_Poned_Apbd_12 == "-"){
        $SisaStok_Poned_Apbd_12 = '0';
    }
	
	$SisaStok_Poned_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 228));
    if($SisaStok_Poned_Jkn_12 == "" OR $SisaStok_Poned_Jkn_12 == "-"){
        $SisaStok_Poned_Jkn_12 = '0';
    }
	
	$SisaStok_Pustu_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 229));
    if($SisaStok_Pustu_Apbd_12 == "" OR $SisaStok_Pustu_Apbd_12 == "-"){
        $SisaStok_Pustu_Apbd_12 = '0';
    }
	
	$SisaStok_Pustu_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 230));
    if($SisaStok_Pustu_Jkn_12 == "" OR $SisaStok_Pustu_Jkn_12 == "-"){
        $SisaStok_Pustu_Jkn_12 = '0';
    }
	
	$SisaStok_Pusling_Apbd_12  = str_replace(array(",","* "), "", $data->val($i, 231));
    if($SisaStok_Pusling_Apbd_12 == "" OR $SisaStok_Pusling_Apbd_12 == "-"){
        $SisaStok_Pusling_Apbd_12 = '0';
    }
	
	$SisaStok_Pusling_Jkn_12  = str_replace(array(",","* "), "", $data->val($i, 232));
    if($SisaStok_Pusling_Jkn_12 == "" OR $SisaStok_Pusling_Jkn_12 == "-"){
        $SisaStok_Pusling_Jkn_12 = '0';
    }
	
	$SisaStok_Poli_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 233));
    if($SisaStok_Poli_Apbd_12 == "" OR $SisaStok_Poli_Apbd_12 == "-"){
        $SisaStok_Poli_Apbd_12 = '0';
    }
	
	$SisaStok_Poli_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 234));
    if($SisaStok_Poli_Jkn_12 == "" OR $SisaStok_Poli_Jkn_12 == "-"){
        $SisaStok_Poli_Jkn_12 = '0';
    }
	
	$SisaStok_Lainnya_Apbd_12   = str_replace(array(",","* "), "", $data->val($i, 235));
    if($SisaStok_Lainnya_Apbd_12 == "" OR $SisaStok_Lainnya_Apbd_12 == "-"){
        $SisaStok_Lainnya_Apbd_12 = '0';
    }
	
	$SisaStok_Lainnya_Jkn_12   = str_replace(array(",","* "), "", $data->val($i, 236));
    if($SisaStok_Lainnya_Jkn_12 == "" OR $SisaStok_Lainnya_Jkn_12 == "-"){
        $SisaStok_Lainnya_Jkn_12 = '0';
    }
	
	// update data
	if($kodebarang != ""){
		$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
		$strupdate = "UPDATE `$tbstokopnam` 
		SET `HargaApbd`='$hargaapbd',`HargaJkn` = '$hargajkn',
		`StokAwalApbd`='$stokawalapbd',`StokAwalJkn` = '$stokawaljkn',
		`PenerimaanJkn_01`='$PenerimaanJkn_01',
		`PenerimaanJkn_02`='$PenerimaanJkn_02',
		`PenerimaanJkn_03`='$PenerimaanJkn_03',
		`PenerimaanJkn_04`='$PenerimaanJkn_04',
		`PenerimaanJkn_05`='$PenerimaanJkn_05',
		`PenerimaanJkn_06`='$PenerimaanJkn_06',
		`PenerimaanJkn_07`='$PenerimaanJkn_07',
		`PenerimaanJkn_08`='$PenerimaanJkn_08',
		`PenerimaanJkn_09`='$PenerimaanJkn_09',
		`PenerimaanJkn_10`='$PenerimaanJkn_10',
		`PenerimaanJkn_11`='$PenerimaanJkn_11',
		`PenerimaanJkn_12`='$PenerimaanJkn_12',
		`Sisastok_Gudang_Apbd_01`='$SisaStok_Gudang_Apbd_01',`Sisastok_Gudang_Jkn_01`='$SisaStok_Gudang_Jkn_01',
		`Sisastok_Depot_Apbd_01`='$SisaStok_Depot_Apbd_01',`Sisastok_Depot_Jkn_01`='$SisaStok_Depot_Jkn_01',
		`Sisastok_Igd_Apbd_01`='$SisaStok_Igd_Apbd_01',`Sisastok_Igd_Jkn_01`='$SisaStok_Igd_Jkn_01',
		`Sisastok_Ranap_Apbd_01`='$SisaStok_Ranap_Apbd_01',`Sisastok_Ranap_Jkn_01`='$SisaStok_Ranap_Jkn_01',
		`Sisastok_Poned_Apbd_01`='$SisaStok_Poned_Apbd_01',`Sisastok_Poned_Jkn_01`='$SisaStok_Poned_Jkn_01',
		`Sisastok_Pustu_Apbd_01`='$SisaStok_Pustu_Apbd_01',`Sisastok_Pustu_Jkn_01`='$SisaStok_Pustu_Jkn_01',
		`Sisastok_Pusling_Apbd_01`='$SisaStok_Pusling_Apbd_01',`Sisastok_Pusling_Jkn_01`='$SisaStok_Pusling_Jkn_01',
		`Sisastok_Poli_Apbd_01`='$SisaStok_Poli_Apbd_01',`Sisastok_Poli_Jkn_01`='$SisaStok_Poli_Jkn_01',
		`Sisastok_Lainnya_Apbd_01`='$SisaStok_Lainnya_Apbd_01',`Sisastok_Lainnya_Jkn_01`='$SisaStok_Lainnya_Jkn_01',
		`Sisastok_Gudang_Apbd_02`='$SisaStok_Gudang_Apbd_02',`Sisastok_Gudang_Jkn_02`='$SisaStok_Gudang_Jkn_02',
		`Sisastok_Depot_Apbd_02`='$SisaStok_Depot_Apbd_02',`Sisastok_Depot_Jkn_02`='$SisaStok_Depot_Jkn_02',
		`Sisastok_Igd_Apbd_02`='$SisaStok_Igd_Apbd_02',`Sisastok_Igd_Jkn_02`='$SisaStok_Igd_Jkn_02',
		`Sisastok_Ranap_Apbd_02`='$SisaStok_Ranap_Apbd_02',`Sisastok_Ranap_Jkn_02`='$SisaStok_Ranap_Jkn_02',
		`Sisastok_Poned_Apbd_02`='$SisaStok_Poned_Apbd_02',`Sisastok_Poned_Jkn_02`='$SisaStok_Poned_Jkn_02',
		`Sisastok_Pustu_Apbd_02`='$SisaStok_Pustu_Apbd_02',`Sisastok_Pustu_Jkn_02`='$SisaStok_Pustu_Jkn_02',
		`Sisastok_Pusling_Apbd_02`='$SisaStok_Pusling_Apbd_02',`Sisastok_Pusling_Jkn_02`='$SisaStok_Pusling_Jkn_02',
		`Sisastok_Poli_Apbd_02`='$SisaStok_Poli_Apbd_02',`Sisastok_Poli_Jkn_02`='$SisaStok_Poli_Jkn_02',
		`Sisastok_Lainnya_Apbd_02`='$SisaStok_Lainnya_Apbd_02',`Sisastok_Lainnya_Jkn_02`='$SisaStok_Lainnya_Jkn_02',
		`Sisastok_Gudang_Apbd_03`='$SisaStok_Gudang_Apbd_03',`Sisastok_Gudang_Jkn_03`='$SisaStok_Gudang_Jkn_03',
		`Sisastok_Depot_Apbd_03`='$SisaStok_Depot_Apbd_03',`Sisastok_Depot_Jkn_03`='$SisaStok_Depot_Jkn_03',
		`Sisastok_Igd_Apbd_03`='$SisaStok_Igd_Apbd_03',`Sisastok_Igd_Jkn_03`='$SisaStok_Igd_Jkn_03',
		`Sisastok_Ranap_Apbd_03`='$SisaStok_Ranap_Apbd_03',`Sisastok_Ranap_Jkn_03`='$SisaStok_Ranap_Jkn_03',
		`Sisastok_Poned_Apbd_03`='$SisaStok_Poned_Apbd_03',`Sisastok_Poned_Jkn_03`='$SisaStok_Poned_Jkn_03',
		`Sisastok_Pustu_Apbd_03`='$SisaStok_Pustu_Apbd_03',`Sisastok_Pustu_Jkn_03`='$SisaStok_Pustu_Jkn_03',
		`Sisastok_Pusling_Apbd_03`='$SisaStok_Pusling_Apbd_03',`Sisastok_Pusling_Jkn_03`='$SisaStok_Pusling_Jkn_03',
		`Sisastok_Poli_Apbd_03`='$SisaStok_Poli_Apbd_03',`Sisastok_Poli_Jkn_03`='$SisaStok_Poli_Jkn_03',
		`Sisastok_Lainnya_Apbd_03`='$SisaStok_Lainnya_Apbd_03',`Sisastok_Lainnya_Jkn_03`='$SisaStok_Lainnya_Jkn_03',
		`Sisastok_Gudang_Apbd_04`='$SisaStok_Gudang_Apbd_04',`Sisastok_Gudang_Jkn_04`='$SisaStok_Gudang_Jkn_04',
		`Sisastok_Depot_Apbd_04`='$SisaStok_Depot_Apbd_04',`Sisastok_Depot_Jkn_04`='$SisaStok_Depot_Jkn_04',
		`Sisastok_Igd_Apbd_04`='$SisaStok_Igd_Apbd_04',`Sisastok_Igd_Jkn_04`='$SisaStok_Igd_Jkn_04',
		`Sisastok_Ranap_Apbd_04`='$SisaStok_Ranap_Apbd_04',`Sisastok_Ranap_Jkn_04`='$SisaStok_Ranap_Jkn_04',
		`Sisastok_Poned_Apbd_04`='$SisaStok_Poned_Apbd_04',`Sisastok_Poned_Jkn_04`='$SisaStok_Poned_Jkn_04',
		`Sisastok_Pustu_Apbd_04`='$SisaStok_Pustu_Apbd_04',`Sisastok_Pustu_Jkn_04`='$SisaStok_Pustu_Jkn_04',
		`Sisastok_Pusling_Apbd_04`='$SisaStok_Pusling_Apbd_04',`Sisastok_Pusling_Jkn_04`='$SisaStok_Pusling_Jkn_04',
		`Sisastok_Poli_Apbd_04`='$SisaStok_Poli_Apbd_04',`Sisastok_Poli_Jkn_04`='$SisaStok_Poli_Jkn_04',
		`Sisastok_Lainnya_Apbd_04`='$SisaStok_Lainnya_Apbd_04',`Sisastok_Lainnya_Jkn_04`='$SisaStok_Lainnya_Jkn_04',
		`Sisastok_Gudang_Apbd_05`='$SisaStok_Gudang_Apbd_05',`Sisastok_Gudang_Jkn_05`='$SisaStok_Gudang_Jkn_05',
		`Sisastok_Depot_Apbd_05`='$SisaStok_Depot_Apbd_05',`Sisastok_Depot_Jkn_05`='$SisaStok_Depot_Jkn_05',
		`Sisastok_Igd_Apbd_05`='$SisaStok_Igd_Apbd_05',`Sisastok_Igd_Jkn_05`='$SisaStok_Igd_Jkn_05',
		`Sisastok_Ranap_Apbd_05`='$SisaStok_Ranap_Apbd_05',`Sisastok_Ranap_Jkn_05`='$SisaStok_Ranap_Jkn_05',
		`Sisastok_Poned_Apbd_05`='$SisaStok_Poned_Apbd_05',`Sisastok_Poned_Jkn_05`='$SisaStok_Poned_Jkn_05',
		`Sisastok_Pustu_Apbd_05`='$SisaStok_Pustu_Apbd_05',`Sisastok_Pustu_Jkn_05`='$SisaStok_Pustu_Jkn_05',
		`Sisastok_Pusling_Apbd_05`='$SisaStok_Pusling_Apbd_05',`Sisastok_Pusling_Jkn_05`='$SisaStok_Pusling_Jkn_05',
		`Sisastok_Poli_Apbd_05`='$SisaStok_Poli_Apbd_05',`Sisastok_Poli_Jkn_05`='$SisaStok_Poli_Jkn_05',
		`Sisastok_Lainnya_Apbd_05`='$SisaStok_Lainnya_Apbd_05',`SisaStok_Lainnya_Jkn_05`='$SisaStok_Lainnya_Jkn_05',
		`Sisastok_Gudang_Apbd_06`='$SisaStok_Gudang_Apbd_06',`Sisastok_Gudang_Jkn_06`='$SisaStok_Gudang_Jkn_06',
		`Sisastok_Depot_Apbd_06`='$SisaStok_Depot_Apbd_06',`Sisastok_Depot_Jkn_06`='$SisaStok_Depot_Jkn_06',
		`Sisastok_Igd_Apbd_06`='$SisaStok_Igd_Apbd_06',`Sisastok_Igd_Jkn_06`='$SisaStok_Igd_Jkn_06',
		`Sisastok_Ranap_Apbd_06`='$SisaStok_Ranap_Apbd_06',`Sisastok_Ranap_Jkn_06`='$SisaStok_Ranap_Jkn_06',
		`Sisastok_Poned_Apbd_06`='$SisaStok_Poned_Apbd_06',`Sisastok_Poned_Jkn_06`='$SisaStok_Poned_Jkn_06',
		`Sisastok_Pustu_Apbd_06`='$SisaStok_Pustu_Apbd_06',`Sisastok_Pustu_Jkn_06`='$SisaStok_Pustu_Jkn_06',
		`Sisastok_Pusling_Apbd_06`='$SisaStok_Pusling_Apbd_06',`Sisastok_Pusling_Jkn_06`='$SisaStok_Pusling_Jkn_06',
		`Sisastok_Poli_Apbd_06`='$SisaStok_Poli_Apbd_06',`Sisastok_Poli_Jkn_06`='$SisaStok_Poli_Jkn_06',
		`Sisastok_Lainnya_Apbd_06`='$SisaStok_Lainnya_Apbd_06',`Sisastok_Lainnya_Jkn_06`='$SisaStok_Lainnya_Jkn_06',
		`Sisastok_Gudang_Apbd_07`='$SisaStok_Gudang_Apbd_07',`Sisastok_Gudang_Jkn_07`='$SisaStok_Gudang_Jkn_07',
		`Sisastok_Depot_Apbd_07`='$SisaStok_Depot_Apbd_07',`Sisastok_Depot_Jkn_07`='$SisaStok_Depot_Jkn_07',
		`Sisastok_Igd_Apbd_07`='$SisaStok_Igd_Apbd_07',`Sisastok_Igd_Jkn_07`='$SisaStok_Igd_Jkn_07',
		`Sisastok_Ranap_Apbd_07`='$SisaStok_Ranap_Apbd_07',`Sisastok_Ranap_Jkn_07`='$SisaStok_Ranap_Jkn_07',
		`Sisastok_Poned_Apbd_07`='$SisaStok_Poned_Apbd_07',`Sisastok_Poned_Jkn_07`='$SisaStok_Poned_Jkn_07',
		`Sisastok_Pustu_Apbd_07`='$SisaStok_Pustu_Apbd_07',`Sisastok_Pustu_Jkn_07`='$SisaStok_Pustu_Jkn_07',
		`Sisastok_Pusling_Apbd_07`='$SisaStok_Pusling_Apbd_07',`Sisastok_Pusling_Jkn_07`='$SisaStok_Pusling_Jkn_07',
		`Sisastok_Poli_Apbd_07`='$SisaStok_Poli_Apbd_07',`Sisastok_Poli_Jkn_07`='$SisaStok_Poli_Jkn_07',
		`Sisastok_Lainnya_Apbd_07`='$SisaStok_Lainnya_Apbd_07',`Sisastok_Lainnya_Jkn_07`='$SisaStok_Lainnya_Jkn_07',
		`Sisastok_Gudang_Apbd_08`='$SisaStok_Gudang_Apbd_08',`Sisastok_Gudang_Jkn_08`='$SisaStok_Gudang_Jkn_08',
		`Sisastok_Depot_Apbd_08`='$SisaStok_Depot_Apbd_08',`Sisastok_Depot_Jkn_08`='$SisaStok_Depot_Jkn_08',
		`Sisastok_Igd_Apbd_08`='$SisaStok_Igd_Apbd_08',`Sisastok_Igd_Jkn_08`='$SisaStok_Igd_Jkn_08',
		`Sisastok_Ranap_Apbd_08`='$SisaStok_Ranap_Apbd_08',`Sisastok_Ranap_Jkn_08`='$SisaStok_Ranap_Jkn_08',
		`Sisastok_Poned_Apbd_08`='$SisaStok_Poned_Apbd_08',`Sisastok_Poned_Jkn_08`='$SisaStok_Poned_Jkn_08',
		`Sisastok_Pustu_Apbd_08`='$SisaStok_Pustu_Apbd_08',`Sisastok_Pustu_Jkn_08`='$SisaStok_Pustu_Jkn_08',
		`Sisastok_Pusling_Apbd_08`='$SisaStok_Pusling_Apbd_08',`Sisastok_Pusling_Jkn_08`='$SisaStok_Pusling_Jkn_08',
		`Sisastok_Poli_Apbd_08`='$SisaStok_Poli_Apbd_08',`Sisastok_Poli_Jkn_08`='$SisaStok_Poli_Jkn_08',
		`Sisastok_Lainnya_Apbd_08`='$SisaStok_Lainnya_Apbd_08',`Sisastok_Lainnya_Jkn_08`='$SisaStok_Lainnya_Jkn_08',
		`Sisastok_Gudang_Apbd_09`='$SisaStok_Gudang_Apbd_09',`Sisastok_Gudang_Jkn_09`='$SisaStok_Gudang_Jkn_09',
		`Sisastok_Depot_Apbd_09`='$SisaStok_Depot_Apbd_09',`Sisastok_Depot_Jkn_09`='$SisaStok_Depot_Jkn_09',
		`Sisastok_Igd_Apbd_09`='$SisaStok_Igd_Apbd_09',`Sisastok_Igd_Jkn_09`='$SisaStok_Igd_Jkn_09',
		`Sisastok_Ranap_Apbd_09`='$SisaStok_Ranap_Apbd_09',`Sisastok_Ranap_Jkn_09`='$SisaStok_Ranap_Jkn_09',
		`Sisastok_Poned_Apbd_09`='$SisaStok_Poned_Apbd_09',`Sisastok_Poned_Jkn_09`='$SisaStok_Poned_Jkn_09',
		`Sisastok_Pustu_Apbd_09`='$SisaStok_Pustu_Apbd_09',`Sisastok_Pustu_Jkn_09`='$SisaStok_Pustu_Jkn_09',
		`Sisastok_Pusling_Apbd_09`='$SisaStok_Pusling_Apbd_09',`Sisastok_Pusling_Jkn_09`='$SisaStok_Pusling_Jkn_09',
		`Sisastok_Poli_Apbd_09`='$SisaStok_Poli_Apbd_09',`Sisastok_Poli_Jkn_09`='$SisaStok_Poli_Jkn_09',
		`Sisastok_Lainnya_Apbd_09`='$SisaStok_Lainnya_Apbd_09',`Sisastok_Lainnya_Jkn_09`='$SisaStok_Lainnya_Jkn_09',		
		`Sisastok_Gudang_Apbd_10`='$SisaStok_Gudang_Apbd_10',`Sisastok_Gudang_Jkn_10`='$SisaStok_Gudang_Jkn_10',
		`Sisastok_Depot_Apbd_10`='$SisaStok_Depot_Apbd_10',`Sisastok_Depot_Jkn_10`='$SisaStok_Depot_Jkn_10',
		`Sisastok_Igd_Apbd_10`='$SisaStok_Igd_Apbd_10',`Sisastok_Igd_Jkn_10`='$SisaStok_Igd_Jkn_10',
		`Sisastok_Ranap_Apbd_10`='$SisaStok_Ranap_Apbd_10',`Sisastok_Ranap_Jkn_10`='$SisaStok_Ranap_Jkn_10',
		`Sisastok_Poned_Apbd_10`='$SisaStok_Poned_Apbd_10',`Sisastok_Poned_Jkn_10`='$SisaStok_Poned_Jkn_10',
		`Sisastok_Pustu_Apbd_10`='$SisaStok_Pustu_Apbd_10',`Sisastok_Pustu_Jkn_10`='$SisaStok_Pustu_Jkn_10',
		`Sisastok_Pusling_Apbd_10`='$SisaStok_Pusling_Apbd_10',`Sisastok_Pusling_Jkn_10`='$SisaStok_Pusling_Jkn_10',
		`Sisastok_Poli_Apbd_10`='$SisaStok_Poli_Apbd_10',`Sisastok_Poli_Jkn_10`='$SisaStok_Poli_Jkn_10',
		`Sisastok_Lainnya_Apbd_10`='$SisaStok_Lainnya_Apbd_10',`Sisastok_Lainnya_Jkn_10`='$SisaStok_Lainnya_Jkn_10',		
		`Sisastok_Gudang_Apbd_11`='$SisaStok_Gudang_Apbd_11',`Sisastok_Gudang_Jkn_11`='$SisaStok_Gudang_Jkn_11',
		`Sisastok_Depot_Apbd_11`='$SisaStok_Depot_Apbd_11',`Sisastok_Depot_Jkn_11`='$SisaStok_Depot_Jkn_11',
		`Sisastok_Igd_Apbd_11`='$SisaStok_Igd_Apbd_11',`Sisastok_Igd_Jkn_11`='$SisaStok_Igd_Jkn_11',
		`Sisastok_Ranap_Apbd_11`='$SisaStok_Ranap_Apbd_11',`Sisastok_Ranap_Jkn_11`='$SisaStok_Ranap_Jkn_11',
		`Sisastok_Poned_Apbd_11`='$SisaStok_Poned_Apbd_11',`Sisastok_Poned_Jkn_11`='$SisaStok_Poned_Jkn_11',
		`Sisastok_Pustu_Apbd_11`='$SisaStok_Pustu_Apbd_11',`Sisastok_Pustu_Jkn_11`='$SisaStok_Pustu_Jkn_11',
		`Sisastok_Pusling_Apbd_11`='$SisaStok_Pusling_Apbd_11',`Sisastok_Pusling_Jkn_11`='$SisaStok_Pusling_Jkn_11',
		`Sisastok_Poli_Apbd_11`='$SisaStok_Poli_Apbd_11',`Sisastok_Poli_Jkn_11`='$SisaStok_Poli_Jkn_11',
		`Sisastok_Lainnya_Apbd_11`='$SisaStok_Lainnya_Apbd_11',`Sisastok_Lainnya_Jkn_11`='$SisaStok_Lainnya_Jkn_11',		
		`Sisastok_Gudang_Apbd_12`='$SisaStok_Gudang_Apbd_12',`Sisastok_Gudang_Jkn_12`='$SisaStok_Gudang_Jkn_12',
		`Sisastok_Depot_Apbd_12`='$SisaStok_Depot_Apbd_12',`Sisastok_Depot_Jkn_12`='$SisaStok_Depot_Jkn_12',
		`Sisastok_Igd_Apbd_12`='$SisaStok_Igd_Apbd_12',`Sisastok_Igd_Jkn_12`='$SisaStok_Igd_Jkn_12',
		`Sisastok_Ranap_Apbd_12`='$SisaStok_Ranap_Apbd_12',`Sisastok_Ranap_Jkn_12`='$SisaStok_Ranap_Jkn_12',
		`Sisastok_Poned_Apbd_12`='$SisaStok_Poned_Apbd_12',`Sisastok_Poned_Jkn_12`='$SisaStok_Poned_Jkn_12',
		`Sisastok_Pustu_Apbd_12`='$SisaStok_Pustu_Apbd_12',`Sisastok_Pustu_Jkn_12`='$SisaStok_Pustu_Jkn_12',
		`Sisastok_Pusling_Apbd_12`='$SisaStok_Pusling_Apbd_12',`Sisastok_Pusling_Jkn_12`='$SisaStok_Pusling_Jkn_12',
		`Sisastok_Poli_Apbd_12`='$SisaStok_Poli_Apbd_12',`Sisastok_Poli_Jkn_12`='$SisaStok_Poli_Jkn_12',
		`Sisastok_Lainnya_Apbd_12`='$SisaStok_Lainnya_Apbd_12',`Sisastok_Lainnya_Jkn_12`='$SisaStok_Lainnya_Jkn_12'
        WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'";
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
// echo "alert('Data berhasil diimport');";
// echo "document.location.href='index.php?page=lap_farmasi_importdata';";
// echo "</script>";

echo "sukses";
?>