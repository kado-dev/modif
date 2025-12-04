<?php
$tanggalkarantina = date('Y-m-d', strtotime($_POST['tanggalkarantina']))." ".date('G:i:s');
$statuskarantina = $_POST['statuskarantina'];
$statuskarantinalainnya = $_POST['statuskarantinalainnya'];
$idbarang = $_POST['idbarang'];	
$statusgudang = $_POST['statusgudang'];	
$key = $_POST['key'];	
$jmltersedia = $_POST['jmltersedia'];	
$kodebarang = $_POST['kodebarang'];
$namabarang = $_POST['namabarang'];	
$nobatch = $_POST['nobatch'];
$nofakturterima = $_POST['nofakturterima'];
$stok = $_POST['stok'];
$jumlah = $_POST['jumlahkarantina'];
$hargabeli = $_POST['hargabeli'];
$expire = $_POST['expire'];
$sisastok = $_POST['sisastok'];

// tahap 1, cek barang
// $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfk_karantinadetail` WHERE `NoFaktur`='$nofaktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
// if($cek > 0){
// 	echo "<script>";
// 	echo "alert('maaf, Barang sudah diinputkan...');";
// 	echo "document.location.href='index.php?page=gudang_besar_karantina&kd=$kodebarang&batch=$nobatch&faktur=$nofakturterima&stsgudang=GUDANG BESAR';";
// 	echo "</script>";
// 	die();
// }

// tahap 2, cek stok
if ($stok < $jumlah){
	echo "<script>";
	echo "alert('maaf, stok kurang dari jumlah Karantina...');";
	echo "document.location.href='index.php?page=gudang_besar_karantina&kd=$kodebarang&batch=$nobatch&faktur=$nofakturterima&stsgudang=GUDANG BESAR';";
	echo "</script>";
	die();
} 

// tahap 3, cek sisa stok
if ($sisastok < $jumlah){
	echo "<script>";
	echo "alert('maaf, stok kurang dari jumlah Karantina...');";
	echo "document.location.href='index.php?page=gudang_besar_karantina&kd=$kodebarang&batch=$nobatch&faktur=$nofakturterima&stsgudang=GUDANG BESAR';";
	echo "</script>";
	die();
} 

// tahap 4, insert
if ($kodebarang != ''){
	$str2 = "INSERT INTO `tbgfk_karantinadetail`(`IdBarang`,`TanggalKarantina`,`StatusKarantina`,`StatusKarantinaLainnya`,`StatusGudang`,`KodeBarang`,`NamaBarang`,`NoBatch`,`Jumlah`,`Harga`,`Expire`,`NoFakturTerima`) 
	VALUES ('$idbarang','$tanggalkarantina','$statuskarantina','$statuskarantinalainnya','$statusgudang','$kodebarang','$namabarang','$nobatch','$jumlah','$hargabeli','$expire','$nofakturterima')";
	$query2=mysqli_query($koneksi,$str2); 
}

// tahap 5, update status karantina
$strupdate = "UPDATE `tbgfkstok` SET `StatusKarantina` = 'Y' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NofakturTerima`='$nofakturterima'";
mysqli_query($koneksi, $strupdate);

if($query2){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_stok&key=$key&jmltersedia=$jmltersedia';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_karantina&kd=$kodebarang&batch=$nobatch&faktur=$nofakturterima&stsgudang=$statusgudang&key=$key&jmltersedia=$jmltersedia';";
	echo "</script>";
} 
?>