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
    $kodeobat     = $data->val($i, 2);
	
	// stokawal 
	$stokawal   = $data->val($i, 5);
    if($stokawal == "-"){
        $stokawal = 0;
    }
	$stokawal = preg_replace('/\D/', '', $stokawal);
	
	// penerimaan
	$penerimaan   = $data->val($i, 6);
    if($penerimaan == "-"){
        $penerimaan = 0;
    }
	$penerimaan = preg_replace('/\D/', '', $penerimaan);

	// persediaan
	$persediaan   = $data->val($i, 7);
    if($persediaan == "-"){
        $persediaan = 0;
    }
	$persediaan = preg_replace('/\D/', '', $persediaan);

	// pemakaian
	$pemakaian   = $data->val($i, 8);
    if($pemakaian == "-"){
        $pemakaian = 0;
    }
	$pemakaian = preg_replace('/\D/', '', $pemakaian);

	// sisaakhir
	$sisaakhir   = $data->val($i, 9);
    if($sisaakhir == "-"){
        $sisaakhir = 0;
    }
	$sisaakhir = preg_replace('/\D/', '', $sisaakhir);

	// stokoptimum
	$stokoptimum   = $data->val($i, 10);
    if($stokoptimum == "-"){
        $stokoptimum = 0;
    }
	$stokoptimum = preg_replace('/\D/', '', $stokoptimum);

	// permintaan
	$permintaan   = $data->val($i, 11);
    if($permintaan == "-"){
        $permintaan = 0;
    }
	$permintaan = preg_replace('/\D/', '', $permintaan);	
	
	// pemberian
	$pemberian   = $data->val($i, 12);
    if($pemberian == "-"){
        $pemberian = 0;
    }
	$pemberian = preg_replace('/\D/', '', $pemberian);

	// keterangan
	$keterangan   = $data->val($i, 13);
    if($keterangan == "-"){
        $keterangan = 0;
    }
	$keterangan = preg_replace('/\D/', '', $keterangan);
	
	// update data
	echo "UPDATE `$tblplpomanual_bogorkab` SET 
		`StokAwal`= '$stokawal',
		`Penerimaan`='$penerimaan',
		`Persediaan`='$persediaan',
		`Pemakaian`='$pemakaian',
		`SisaAkhir`='$sisaakhir',
		`StokOptimum`='$stokoptimum',
		`Permintaan`='$permintaan',
		`Pemberian`='$pemberian',
		`Keterangan`='$keterangan'
        WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan'";
		die();
		

	if($kodeobat != ""){
		
        mysqli_query($koneksi, "UPDATE `$tblplpomanual_bogorkab` SET 
		`StokAwal`= '$stokawal',
		`Penerimaan`='$penerimaan',
		`Persediaan`='$persediaan',
		`Pemakaian`='$pemakaian',
		`SisaAkhir`='$sisaakhir',
		`StokOptimum`='$stokoptimum',
		`Permintaan`='$permintaan',
		`Pemberian`='$pemberian',
		`Keterangan`='$keterangan'
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
echo "alert('Data berhasil diimport');";
// echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual';".$links;
echo "document.location.href='index.php?page=lap_farmasi_lplpo_manual&bulan=$bulan&tahun=$tahun&sumberanggaran=$sumberanggaran';";
echo "</script>";
?>