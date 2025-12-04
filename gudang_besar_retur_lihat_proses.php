<?php		
$idretur = $_POST['idretur'];	
$nofaktur = $_POST['nofaktur'];	
$kodebarang = $_POST['kodebarang'];	
$nobatch = $_POST['nobatch'];
$jumlah = $_POST['jumlah'];

// catatan : Nama barang walau diketik tidak sesuai database tidak mempengaruhi karena yang diinsert adalah kode barang 
// Tahap 1, cek barang yang sama dalam satu faktur
$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM `tbgfkreturdetail` WHERE `IdRetur`='$idretur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
if($cek > 0){
	echo "<script>";
	echo "alert('maaf, Barang sudah diinputkan...');";
	echo "document.location.href='index.php?page=gudang_besar_retur_lihat&nf=$nofaktur&idretur=$idretur';";	
	echo "</script>";
	die();
}	

// Tahap 2, update stok tbgfkstok  (kodebarang dan batch)
	$stok_gb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
	$stok_gb_tambah = $stok_gb['Stok'] + $jumlah;
	$str_gfkstok = "UPDATE `tbgfkstok` SET `Stok`= '$stok_gb_tambah' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	mysqli_query($koneksi,$str_gfkstok);
	
// tbgfkreturdetail
	$strpenerimaan = "INSERT INTO `tbgfkreturdetail`(`IdRetur`,`KodeBarang`,`NoBatch`,`Jumlah`)
	VALUES ('$idretur','$kodebarang','$nobatch','$jumlah')";
	$query = mysqli_query($koneksi,$strpenerimaan);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_retur_lihat&nf=$nofaktur&idretur=$idretur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_retur_lihat&nf=$nofaktur&idretur=$idretur';";
	echo "</script>";
} 
?>