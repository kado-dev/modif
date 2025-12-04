<?php	
// ini_set('max_input_vars','5000');
$kota = $_SESSION['kota'];		
$tanggalpengeluaran = $_POST['tanggalpengeluaran'];
$kodebarang = $_POST['kodebarang'];
$nf = $_POST['nofaktur'];	
$idds = $_POST['iddistribusi'];	
$penerimapost = $_POST['penerima'];	
$nobatch = $_POST['nobatch'];
$expire = $_POST['expire'];	
$jumlah = $_POST['jumlah'];	
$hargabeli = $_POST['hargabeli'];	
$namaprogram = $_POST['program'];
$sumberanggaran = $_POST['sumberanggaran'];
$nofakturterima = $_POST['nofakturterima'];

$dataterima = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `TanggalPenerimaan` FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan =  b.NomorPembukuan
WHERE b.`KodeBarang`='$kodebarang' AND b.`NoBatch`='$nobatch' AND `Expire`='$expire' AND `Harga`='$hargabeli'"));
$tanggalterima = $dataterima['TanggalPenerimaan']; 

if($jumlah != null){
	// tahap1, cek apakah obat expire
	if($expire < date('Y-m-d')){
		echo "<script>";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost&sts=1'";
		echo "</script>";
		die();
	}	
	
	// tahap2, cek barang yang sama dalam satu faktur (jika status validasi belum, tp jika sudah mau ditambahkan lagi itu bisa)
	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgfkpengeluarandetail` WHERE `IdDistribusi`='$idds' AND `NoFaktur`='$nf' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `StatusValidasi`='Belum'"));
	if($cek > 0){
		echo "<script>";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost&sts=2'";	
		echo "</script>";
		die();
	}

	// tahap3, cek stok
	$stokgfk = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
	$sisastok = $stokgfk['Stok'];
	if ($sisastok < $jumlah){
		echo "<script>";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost&sts=3'";
		echo "</script>";
		die();
	}
	
	// tahap4, cek tanggal terima (jika tanggal distribusi lebih besar dari tanggal terima tampil notofikasi)
	if($tanggalpengeluaran < $tanggalterima){
		echo "<script>";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost&sts=4'";
		echo "</script>";
		die();
	}
	
	// tahap5, insert ke tbgfkpengeluarandetail
	if ($kodebarang != ''){	
		$str2 = "INSERT INTO `tbgfkpengeluarandetail`(`IdDistribusi`,`NoFaktur`,`KodeBarang`,`NoBatch`,`Jumlah`,`Harga`,`StatusValidasi`,`NamaProgram`,`SumberAnggaran`,`NofakturTerima`)
		VALUES ('$idds','$nf','$kodebarang','$nobatch','$jumlah','$hargabeli','Belum','$namaprogram','$sumberanggaran','$nofakturterima')";        
		// echo $str2;
		// die();
		$query2 = mysqli_query($koneksi,$str2);
		
		// kurangi stok
		$hasil = $sisastok - $jumlah;
		$str3 = "UPDATE `tbgfkstok` SET `Stok`= '$hasil' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
		mysqli_query($koneksi,$str3);
	}
}

if($query2){
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerimapost';";
	echo "</script>";
} 
?>