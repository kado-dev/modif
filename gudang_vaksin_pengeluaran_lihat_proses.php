<?php				
$namapegawaisimpan = $_SESSION['nama_petugas'];							
$jampengeluaran = date('G:i:s');					
$tanggalpengeluaran = $_POST['tanggalpengeluaran'];	//
$kodepuskesmas = $_POST['kodepenerima'];	
$statuspengeluaran = $_POST['statuspengeluaran']; // 
$kodebarang = $_POST['kodebarang'];		
$nobatch = $_POST['nobatch'];		
$expire = $_POST['expire'];		
$jumlah = $_POST['jumlah'];	
$hargabeli = $_POST['hargabeli'];	
$total = $jumlah * $hargabeli;	
$totallama = $_POST['totallama'];
$sts = $_GET['sts'];
$nf = $_POST['nofaktur'];	
$idds = $_POST['iddistribusi'];	
$penerima = $_GET['penerima'];	
$penerimapost = $_POST['penerima'];	
$id = $_GET['id'];
$freeze = $_POST['freeze'];	
$vvm = $_POST['vvm'];	
$vccm = $_POST['vccm'];	
$nofakturterima = $_POST['nofakturterima'];	
$stokgfk = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' ORDER BY Stok Desc"));
$sisastok = $stokgfk['Stok'];	
// $sisastok = str_replace(".","",$_POST['sisastok']);	

if ($sts == 1){
	$grandtotal = $_GET['grand'];	
	$nf = $_GET['nofaktur'];	
	mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_pengeluaran` SET `GrandTotal`='$grandtotal' WHERE `NoFaktur`='$nf'");
	mysqli_query($koneksi,"UPDATE `tbgudangpkmpenerimaan` SET `GrandTotal`='$grandtotal' WHERE `NoFaktur`='$nf'");
	echo "<script>";
	echo "alert('Data berhasil di Update...');";
	echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$id&nf=$nf&penerima=$penerima';";
	echo "</script>";
}else{
	$grandtotal = $total + $totallama;	
	// update grand total tbgfk_vaksin_pengeluaran
	mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_pengeluaran` SET `GrandTotal`='$grandtotal' WHERE `NoFaktur`='$nf'");
	// update grand total penerimaan di puskesmas
	mysqli_query($koneksi,"UPDATE `tbgudangpkmpenerimaan` SET `GrandTotal`='$grandtotal' WHERE `NoFaktur`='$nf'");
}

// tahap1, cek barang yang sama dalam satu faktur
$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM `tbgfk_vaksin_pengeluarandetail` WHERE `IdDistribusi`='$idds' AND `NoFaktur`='$nf' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
if($cek > 0){
	echo "<script>";
	echo "alert('maaf, Barang sudah diinputkan...');";
	echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
	die();
}

// tahap2, cek stok
if ($sisastok < $jumlah){
	echo "<script>";
	echo "alert('maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
	die();
}

// tahap3, cek expire yang lebih muda dan Stoknya tidak 0
$cekexp = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Expire` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `Stok` > '0' ORDER BY Expire ASC"));
$thnexp = substr($expire,0,4);
$thnexpcek = substr($cekexp['Expire'],0,4);

// if ($thnexp > $thnexpcek){
	// echo "<script>";
	// echo "alert('Data gagal disimpan, Tahun Expire masih ada yang lebih muda...');";
	// echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
	// echo "</script>";
	// die();
// }elseif(thnexp == $thnexpcek){
	// if($blnexp > $blnexpcek){
		// echo "<script>";
		// echo "alert('Data gagal disimpan, Bulan Expire masih ada yang lebih muda...');";
		// echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
		// echo "</script>";
		// die();
	// }	
// }	

// insert ke tbgfk_vaksin_pengeluarandetail
if ($kodebarang != ''){	
	$str2 = "INSERT INTO `tbgfk_vaksin_pengeluarandetail`(`IdDistribusi`,`NoFaktur`,`KodeBarang`,`NoBatch`,`Jumlah`,`Harga`,`StatusValidasi`,`Freeze`,`Vvm`,`Vccm`,`NoFakturTerima`)
	VALUES ('$idds','$nf','$kodebarang','$nobatch','$jumlah','$hargabeli','Belum','$freeze','$vvm','$vccm','$nofakturterima')";           
	$query2=mysqli_query($koneksi,$str2);
	
	// kurangi stok
	$hasil = $sisastok - $jumlah;
	$str4 = "UPDATE `tbgfk_vaksin_stok` SET `Stok`= '$hasil' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
	mysqli_query($koneksi,$str4);
	
	// update grand total
	mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_pengeluaran` SET `GrandTotal`='$grandtotal' WHERE `NoFaktur`='$nf'");

	// obat dikirim ke gudang obat puskesmas
	if($statuspengeluaran == 'PUSKESMAS'){
		$str6 = "INSERT INTO `tbgudangpkmpenerimaandetail`(`IdDistribusi`,`NoFaktur`,`KodePuskesmas`,`KodeBarang`,`Jumlah`,`NoBatch`,`Expire`,`HargaBeli`,`StatusValidasi`)
		VALUES ('$idds','$nf','$kodepuskesmas','$kodebarang','$jumlah','$nobatch','$expire','$hargabeli','Belum')";
		$query6 = mysqli_query($koneksi,$str6);
	}
}

if($query2){
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
} 
?>