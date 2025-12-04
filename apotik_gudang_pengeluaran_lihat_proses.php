<?php
include "config/helper_pasienrj.php";
$nofaktur = $_POST['nofaktur'];
$idbrggudangpkm = $_POST['idbrggudangpkm'];		
$kodebarang = $_POST['kodebarang'];		
$namabarang = $_POST['namabarang'];		
$satuan = $_POST['satuan'];		
$nobatch = $_POST['nobatch'];		
$expire = $_POST['expire'];		
$harga = $_POST['hargasatuan'];		
$jumlah = $_POST['jumlah'];
$penerima = $_POST['penerima'];			
$sumberanggaran = $_POST['sumberanggaran'];			
$tahunanggaran = $_POST['tahunanggaran'];

// tahap 1, cek barang
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgudangpkmpengeluarandetail` WHERE `IdBarangGdgPkm` = '$idbrggudangpkm' AND `NoFaktur` = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama...');";
	echo "document.location.href='index.php?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
	die();
}

// tahap 2, ngecek stok gudang puskesmas
$datastok_gop = mysqli_fetch_assoc( mysqli_query($koneksi, "SELECT `IdBarangGdgPkm`,`Stok` FROM `$tbgudangpkmstok` WHERE `IdBarangGdgPkm` = '$idbrggudangpkm'"));
$stok_gop = $datastok_gop['Stok'];

if ($stok_gop < $jumlah){
	echo "<script>";
	echo "alert('Maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
	die();
}

// tahap 3, insert ke tbgudangpkmpengeluarandetail
$str1 = "INSERT INTO `tbgudangpkmpengeluarandetail`(`NoFaktur`,`IdBarangGdgPkm`,`KodeBarang`,`NoBatch`,`Jumlah`,`StatusBarang`)
VALUES ('$nofaktur','$idbrggudangpkm','$kodebarang','$nobatch','$jumlah','$penerima')";
// echo $str1;
// die();
$query1=mysqli_query($koneksi,$str1);

// tahap 4, ngurangin stok gudang puskesmas (IdBarangGdgPkm)
$stok_gop = $datastok_gop['Stok'] - $jumlah;
$str4 = "UPDATE `$tbgudangpkmstok` SET `Stok`= '$stok_gop' WHERE `IdBarangGdgPkm`='$datastok_gop[IdBarangGdgPkm]'";
mysqli_query($koneksi,$str4);

// tahap 5, cek barang diloket obat ingat berdasarkan Status Barang (LOKET OBAT, PUSTU..dll)
if($kota == "KOTA TARAKAN"){
	$cek_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT `IdBarang` FROM `$tbapotikstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'"));
	$cek_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `IdBarang`,`Stok` FROM `$tbapotikstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'"));
	if($cek_barang > 0){
		$stok_apotik = $cek_stok['Stok'] + $jumlah;
		$str_input_brg = "UPDATE `$tbapotikstok` SET `Stok`= '$stok_apotik' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'";
	}else{
		$str_input_brg = "INSERT INTO `$tbapotikstok`(`IdBarangGdgPkm`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`SumberAnggaran`,`TahunAnggaran`,`HargaSatuan`,`Stok`,`StatusBarang`) 
		VALUES ('$idbrggudangpkm','$kodebarang','$namabarang','$satuan','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$harga','$jumlah','$penerima')";
	}
	// echo $str_input_brg;
	// die();
}else{
	// kabupaten bandung
	$cek_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT `IdBarang` FROM `$tbapotikstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'"));
	$cek_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `IdBarang`,`Stok` FROM `$tbapotikstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'"));
	if($cek_barang > 0){
		if($cek_stok['Stok'] <= 0){
			$stok_apotik = $jumlah;
		}else{
			$stok_apotik = $cek_stok['Stok'] + $jumlah;
		}
		$str_input_brg = "UPDATE `$tbapotikstok` SET `Stok`= '$stok_apotik' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusBarang`='$penerima'";
	}else{
		$str_input_brg = "INSERT INTO `$tbapotikstok`(`IdBarangGdgPkm`,`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`SumberAnggaran`,`TahunAnggaran`,`HargaSatuan`,`Stok`,`StatusBarang`) 
		VALUES ('$idbrggudangpkm','$kodepuskesmas','$kodebarang','$namabarang','$satuan','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$harga','$jumlah','$penerima')";
	}
}
// echo $str_input_brg;
// die();
mysqli_query($koneksi,$str_input_brg);

if($query1){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
} 
?>