<?php
include "config/helper_pasienrj.php";
$nofaktur = $_POST['nofaktur'];	
$kodebarang = $_POST['kodebarang'];
$namabarang = $_POST['namabarang'];
$satuan = $_POST['satuan'];
$jumlah = $_POST['jumlah'];
$nobatch = $_POST['nobatch'];
$expire = date('Y-m-d', strtotime($_POST['expire']));	
$hargasatuan = $_POST['hargasatuan'];	
$sumberanggaran = $_POST['sumberanggaran'];	
$tahunanggaran = $_POST['tahunanggaran'];

// tahap1, cek jika nama obat tidak ada dalam database (ref_obat_jkn)
$cek_nm_obat = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_jkn` WHERE `NamaObatJkn`='$namabarang'"));
if($cek_nm_obat == 0){
	echo "<script>";
	echo "alert('Nama Obat tidak terdaftar di database, silahkan buat master data terlebih dahulu...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur'";
	echo "</script>";
	die();
}

// tahap2, cekobat
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `$tbgudangpkmpenerimaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFaktur`='$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
	die();
}

// tambah jenis/stok tbgudangpkmstok puskesmas, berdasarkan expire dan batch
$cek_jenis = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok`
WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' and YEAR(Expire)='$expire'"));

if ($cek_jenis == 0){
	$str1 = "INSERT INTO `$tbgudangpkmstok`(`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`StatusPenerimaan`)
	VALUES ('$kodebarang','$namabarang','$satuan','$nobatch','$expire','$hargasatuan','$sumberanggaran','$tahunanggaran','$jumlah','Mandiri')";
	// echo $str1;
	// die();
	$query = mysqli_query($koneksi,$str1);
}else{
	// cek stok
	$stok_gudangpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `$tbgudangpkmstok` 
	WHERE `KodeBarang` = '$kodebarang' AND `NoBatch` = '$nobatch' AND KodePuskesmas = '$kodepuskesmas' and YEAR(Expire) = '$expire'"));
	$stok_gudangpuskesmas_tambah = $stok_gudangpuskesmas['Stok'] + $jumlah;
	// update tbgudangpkmstok
	$str_gudangpuskesmasstok = "UPDATE `$tbgudangpkmstok` SET `Stok`='$stok_gudangpuskesmas_tambah', `NoBatch`='$nobatch', `HargaSatuan`='$hargasatuan' 
	WHERE `KodeBarang`='$kodebarang' AND KodePuskesmas = '$kodepuskesmas' and YEAR(Expire) = '$expire' AND `NoBatch` = '$nobatch'";
	mysqli_query($koneksi,$str_gudangpuskesmasstok);
}

// insert tbgudangpkmpengadaandetail
$str = "INSERT INTO `$tbgudangpkmpenerimaandetail`(`NoFaktur`,`KodeBarang`,`NoBatch`,`Expire`,`HargaBeli`,`JumlahPenerimaan`,`Keterangan`)
		VALUES ('$nofaktur','$kodebarang','$nobatch','$expire','$hargasatuan','$jumlah','Mandiri')";
		// echo $str;
		// die();
mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>