
<?php
	//variabel tbgfkstok
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$dat = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbpuskesmas` where KodePuskesmas = '$kodepuskesmas'"));
	$puskesmas = $dat['NamaPuskesmas'];

	$kodebarang = $_POST['kodebarang'];
	$namabarang = $_POST['namabarang'];
	$id_generik = $_POST['kodebaranginn'];
	$produsen = $_POST['produsen'];
	$isikemasan = $_POST['isikemasan'];
	$kemasan = $_POST['kemasan'];
	$satuan = $_POST['satuan'];
	$kelastherapy = $_POST['kelastherapy'];
	$golonganfungsi = $_POST['golonganfungsi'];
	$namaprogram = $_POST['namaprogram'];	
	$jenisbarang = $_POST['jenisbarang'];
	$ruangan = $_POST['ruangan'];
	$rak = $_POST['rak'];
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$barcode = $_POST['barcode'];
	$nobatch = $_POST['nobatch'];
	$expire = date('Y-m-d', strtotime($_POST['expire']));
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];	
	$stok = $_POST['stok'];	
	$namapegawaisimpan = $_SESSION['username'];
	
	
	//cek gfkstok, nama obat dan tgl expire, ditambhakan no batch agar membedakan obat yg sama
	// $strexp = "SELECT `KodeBarang` FROM `tbgfkstok` 
	// WHERE MONTH(Expire) = '$expire1[1]' AND YEAR(Expire) = '$expire1[2]' AND NamaBarang = '$namabarang' and NoBatch = '$nobatch'";
	// $cekexp = mysqli_query($koneksi, $strexp);
	// $cek_expire = mysqli_num_rows($cekexp);
	// echo $strexp;
	// die();
		
	// if($cek_expire > '0'){
		// $kdb = mysqli_fetch_assoc($cekexp);
		// $kodebarangs = $kdb['KodeBarang'];
	// }else{
		// $kodebarangs = $kodebarang;
	// }
	
	// if($cek_expire == '0'){
		$str_gop = "INSERT INTO `tbgudangpkmstok`(`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`) 
		VALUES ('$kodepuskesmas','$kodebarang','$namabarang','$satuan','$nobatch','$expire','$hargabeli','$sumberanggaran','$tahunanggaran','$stok')";
		$query2=mysqli_query($koneksi,$str_gop);
		
		// $str = "INSERT INTO `tbgfkstok`(`KodeBarang`,`NamaBarang`,`IsiKemasan`,`Kemasan`,`Satuan`,`KelasTherapy`,`GolonganFungsi`,`NamaProgram`,`JenisBarang`,
		// `Ruangan`,`Rak`,`Stok`,`MinimalStok`, `HargaBeli`,`Barcode`,`NoBatch`, `Expire`, `SumberAnggaran`,`TahunAnggaran`,`Produsen`,`Keterangan`,`NamaPegawaiSimpan`)
		// VALUES('$kodebarang','$namabarang','$isikemasan','$kemasan','$satuan','$kelastherapy',
		// '$golonganfungsi','$namaprogram','$jenisbarang','$ruangan','$rak',0,'$minimalstok','$hargabeli','$barcode','$nobatch','$expire','$sumberanggaran',
		// '$tahunanggaran','$produsen','Dinas','$namapegawaisimpan')";
		// mysqli_query($koneksi,$str);
	// }else{
		// echo "<script>";
		// echo "alert('Obat ini sudah masuk tanggal expire, silahkan pilih data obat yg lain...');";
		// echo "document.location.href='index.php?page=apotik_gudang_stok';";
		// echo "</script>";
	// }
	
	//cek kodebarang di gudang puskesmas jika sudah ada, tidak masuk
	// $cekkodebarang = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang from tbgudangpkmstok where KodeBarang = '$kodebarang'"));
	// if($cekkodebarang > 0){
		// echo "<script>";
		// echo "alert('Barang sudah ada di gudang puskesmas');";
		// echo "document.location.href='index.php?page=apotik_gudang_stok';";
		// echo "</script>";
		// die();
	// }
	
	if($query2){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=apotik_gudang_stok';";
		echo "</script>";
	}else{
		// echo $str_gop;
		// echo $str;
		// die();
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=apotik_gudang_stok_tambah';";
		echo "</script>";
	} 	
?>