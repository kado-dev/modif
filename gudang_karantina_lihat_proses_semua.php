<?php			
$nofaktur = $_POST['nofaktur'];	
$statusgudang = $_POST['statusgudang'];

// cek obat ED
$hariiini = date('Y-m-d');
$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `Expire` < '$hariiini' AND `NamaProgram` != 'VAKSIN' AND `SumberAnggaran` != 'BLUD' ORDER BY NamaBarang ASC";
$query = mysqli_query($koneksi,$str);
while($data = mysqli_fetch_assoc($query)){
	$idbarang = $data['IdBarang'];
	$kodebarang = $data['KodeBarang'];
	$nobatch = $data['NoBatch'];
	$jumlah = $data['Stok'];
	$hargabeli = $data['HargaBeli'];
	
	// insert
	$str2 = "INSERT INTO `tbgfk_karantinadetail`(`NoFaktur`,`StatusGudang`,`KodeBarang`,`NoBatch`,`Jumlah`,`Harga`) VALUES ('$nofaktur','Gudang Besar','$kodebarang','$nobatch','$jumlah','$hargabeli')";
	$query2=mysqli_query($koneksi,$str2);
	
	// pengurangan stok gudang besar
	$str4 = "UPDATE `tbgfkstok` SET `Stok`= '0' WHERE `IdBarang`='$idbarang'";
	mysqli_query($koneksi,$str4);
}	

if($query2){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>