<?php		
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
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
$tbgudangpkmpenerimaandetail = "tbgudangpkmpenerimaandetail_".str_replace(' ', '', $namapuskesmas);
$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);

// cekobat
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `$tbgudangpkmpenerimaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFaktur`='$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
	die();
}

// tambah jenis/stok tbgudangpkmstok puskesmas, berdasarkan expire dan batch
$cekbarang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND Expire='$expire'"));

if ($cekbarang == 0){
	$str = "INSERT INTO `$tbgudangpkmstok`(`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`StatusPenerimaan`)
	VALUES ('$kodebarang','$namabarang','$satuan','$nobatch','$expire','$hargasatuan','$sumberanggaran','$tahunanggaran','$jumlah','Mandiri')";	
}else{
	// cek stok
	$stok_gudangpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch` = '$nobatch' AND Expire = '$expire'"));
	$stok_gudangpuskesmas_tambah = $stok_gudangpuskesmas['Stok'] + $jumlah;
	
	// update $tbgudangpkmstok
	$str = "UPDATE `$tbgudangpkmstok` SET `Stok`='$stok_gudangpuskesmas_tambah' WHERE `KodeBarang`='$kodebarang' AND `NoBatch` = '$nobatch' AND Expire = '$expire'";	
}
// echo $str;
// die();
$query = mysqli_query($koneksi,$str);

// insert tbgudangpkmpengadaandetail
$str = "INSERT INTO `$tbgudangpkmpenerimaandetail`(`NoFaktur`,`KodeBarang`,`NoBatch`,`Expire`,`SumberAnggaran`,`TahunAnggaran`,`HargaBeli`,`JumlahPenerimaan`,`Keterangan`)
VALUES ('$nofaktur','$kodebarang','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$hargasatuan','$jumlah','Mandiri')";
// echo $str;
// die();
mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat_tarakan&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat_tarakan&id=$nofaktur';";
	echo "</script>";
} 
?>