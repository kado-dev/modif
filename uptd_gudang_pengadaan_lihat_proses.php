<?php		
//--variabel tbgfkpenerimaandetail--//
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$nofaktur = $_POST['nofaktur'];	
$kodebarang = $_POST['kodebarang'];
$jumlah = $_POST['jumlah'];
$nobatch = $_POST['nobatch'];
$expire = $_POST['expire'];
$hargabeli = $_POST['hargabeli'];	
$total = $jumlah * $hargabeli;	
$totallama = $_POST['totallama'];	

$sts = $_GET['sts'];
if ($sts == 1){
	$grandtotal = $_GET['grand'];	
	$nofaktur = $_GET['nofaktur'];	
}else{
	$grandtotal = $total + $totallama;	
	$nofaktur = $_POST['nofaktur'];	
}

// tbgudanguptdpengadaan
$str_update = mysqli_query($koneksi,"UPDATE `tbgudanguptdpengadaan` SET GrandTotal=$grandtotal WHERE NoFaktur='$nofaktur'");

//cekobat
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` from `tbgudanguptdpengadaandetail` where `KodeBarang` = '$kodebarang' AND NoFaktur = '$nofaktur' AND KodePuskesmas = '$kodepuskesmas'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
	die();
}

//insert tbgudanguptdpengadaandetail
if ($kodebarang != ''){
$str = "INSERT INTO `tbgudanguptdpengadaandetail`(`NoFaktur`,`KodePuskesmas`,`KodeBarang`,`Jumlah`)
		VALUES ('$nofaktur','$kodepuskesmas','$kodebarang','$jumlah')";
$query=mysqli_query($koneksi,$str);
}

//tambah stok tbgudanguptdstok puskesmas
$cek_stok = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from `tbgudanguptdstok` where `KodeBarang` = '$kodebarang' AND KodePuskesmas = '$kodepuskesmas'"));
if ($cek_stok == 0){
	$str1 = "INSERT INTO `tbgudanguptdstok`(`KodePuskesmas`,`KodeBarang`,`NoBatch`,`Expire`,`Stok`)
	VALUES ('$kodepuskesmas','$kodebarang','$nobatch','$expire','$jumlah')";
	$query = mysqli_query($koneksi,$str1);
	// echo $str11;
	// die();
}else{
	$stok_gudangpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `tbgudanguptdstok` WHERE`KodeBarang` = '$kodebarang' AND KodePuskesmas = '$kodepuskesmas'"));
	$stok_gudangpuskesmas_tambah = $stok_gudangpuskesmas['Stok'] + $jumlah;
	$str_gudangpuskesmasstok = "UPDATE `tbgudanguptdstok` SET `Stok`= '$stok_gudangpuskesmas_tambah' WHERE `KodeBarang`='$kodebarang' AND KodePuskesmas = '$kodepuskesmas'";
	mysqli_query($koneksi,$str_gudangpuskesmasstok);
}

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>