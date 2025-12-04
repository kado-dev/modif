<?php		
include "config/helper_pasienrj.php";
$nofaktur = $_POST['nofaktur'];	
$kodebarang = $_POST['kodebarang'];
$namabarang = $_POST['namabarang'];
$satuan = $_POST['satuanbrg'];
$jumlah = $_POST['jumlah'];
$nobatch = $_POST['nobatch'];
$expire = date('Y-m-d', strtotime($_POST['expire']));	
$expire_tahun = date('Y', strtotime($_POST['expire']));	
$expire_bulan = date('m', strtotime($_POST['expire']));	
$hargasatuan = $_POST['hargasatuan'];	
$tahunanggaran = $_POST['tahunanggaran'];	
$sumberanggaran = $_POST['sumberanggaran'];		

// tahap1, cek jika nama obat tidak ada dalam database (ref_obat_jkn)
$cek_nm_obat = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_jkn` WHERE `NamaObatJkn`='$namabarang'"));
if($cek_nm_obat == 0){
	echo "<script>";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur&sts=1'";
	echo "</script>";
	die();
}

// tahap2, cek obat sama dalam 1 faktur
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `tbgudangpkmpengadaandetail` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch' AND NoFaktur = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur&sts=2';";
	echo "</script>";
	die();
}

// tahap3, walaupun kode barang dan batch sama dibedakan dengan expire (bulan dan tahun), sumberanggaran, harga
$cek_jenis = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok`
WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'AND YEAR(Expire) = '$expire_tahun' AND 
MONTH(Expire)='$expire_bulan' AND `SumberAnggaran`='$sumberanggaran' AND `HargaSatuan`='$hargasatuan'"));

if ($cek_jenis == 0){
	$cekprogram = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obatprogram` WHERE `nama_program`='$sumberanggaran'")); 
	$str1 = "INSERT INTO `$tbgudangpkmstok`(`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`IdProgram`,`NamaProgram`,`NoFakturPengadaan`)
	VALUES ('$kodebarang','$namabarang','$satuan','$nobatch','$expire','$hargasatuan','$sumberanggaran','$tahunanggaran','$jumlah','$cekprogram[id_program]','$cekprogram[nama_program]','$nofaktur')";
	// echo $str1;
	// die();
	mysqli_query($koneksi,$str1);
}else{
	$stok_gudangpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch' AND KodePuskesmas = '$kodepuskesmas' and YEAR(Expire) = '$expire_tahun' AND MONTH(Expire)='$expire_bulan' AND `SumberAnggaran`='$sumberanggaran' AND `HargaSatuan`='$hargasatuan'"));
	$stok_gudangpuskesmas_tambah = $stok_gudangpuskesmas['Stok'] + $jumlah;
	$str_gudangpuskesmasstok = "UPDATE `$tbgudangpkmstok` SET `Stok`='$stok_gudangpuskesmas_tambah', `NoBatch`='$nobatch', `HargaSatuan`='$hargasatuan' 
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND KodePuskesmas = '$kodepuskesmas' AND MONTH(Expire)='$expire_bulan' AND `SumberAnggaran`='$sumberanggaran' AND `HargaSatuan`='$hargasatuan'";
	mysqli_query($koneksi,$str_gudangpuskesmasstok);
}

// tahap4, insert tbgudangpkmpengadaandetail
$str = "INSERT INTO `tbgudangpkmpengadaandetail`(`NoFaktur`,`KodePuskesmas`,`KodeBarang`,`Jumlah`,`NoBatch`,`Expire`,`HargaBeli`)
		VALUES ('$nofaktur','$kodepuskesmas','$kodebarang','$jumlah','$nobatch','$expire','$hargasatuan')";
$query = mysqli_query($koneksi,$str);
	
if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>