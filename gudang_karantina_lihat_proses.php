<?php			
$nofaktur = $_POST['nofaktur'];	
$statusgudang = $_POST['statusgudang'];	
$kodebarang = $_POST['kodebarang'];	
$nobatch = $_POST['nobatch'];	
$jumlah = $_POST['jumlahkarantina'];
$hargabeli = $_POST['hargabeli'];

// tahap 1, cek barang
$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfk_karantinadetail` WHERE `NoFaktur`='$nofaktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
if($cek > 0){
	echo "<script>";
	echo "alert('maaf, Barang sudah diinputkan...');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
	die();
}

// tahap 2, cek stok
if($statusgudang == 'Gudang Besar'){
	$datastok = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
}elseif($statusgudang == 'Gudang Vaksin'){
	$datastok = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
}	
$stokgb = $datastok['Stok'];
if ($stokgb < $jumlah){
	echo "<script>";
	echo "alert('maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
	die();
} 

if ($kodebarang != ''){
	$str2 = "INSERT INTO `tbgfk_karantinadetail`(`NoFaktur`,`StatusGudang`,`KodeBarang`,`NoBatch`,`Jumlah`,`Harga`) VALUES ('$nofaktur','$statusgudang','$kodebarang','$nobatch','$jumlah','$hargabeli')";
	$query2=mysqli_query($koneksi,$str2);
	
	// pengurangan stok gudang besar
	$stoks = $stokgb - $jumlah;
	if($statusgudang == 'Gudang Besar'){
		$str4 = "UPDATE `tbgfkstok` SET `Stok`= '$stoks' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	}elseif($statusgudang == 'Gudang Vaksin'){	
		$str4 = "UPDATE `tbgfk_vaksin_stok` SET `Stok`= '$stoks' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	}
	mysqli_query($koneksi,$str4);    
}

if($query2){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>