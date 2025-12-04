<?php
$sql_cek='SELECT max(KodeBarang)as maxno from `tbgfkstok` WHERE substring(KodeBarang,4,4)';
$query_cek=mysqli_query($koneksi,$sql_cek);
$data=mysqli_fetch_array($query_cek);
$no=substr($data['maxno'],-4);
$no_next=$no+1;

	if(strlen($no_next)==1)
	{
		$no="000".$no_next;
	}
	elseif(strlen($no_next)==2)
	{
		$no="00".$no_next;
	}
	elseif(strlen($no_next)==3)
	{
		$no="0".$no_next;
	}
	else
	{
		$no=$no_next;
	}
$kdbarang="GFK".$no;
?>

<?php
	//variabel tbgfkstok
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$dat = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbpuskesmas` where KodePuskesmas = '$kodepuskesmas'"));
	$puskesmas = $dat['NamaPuskesmas'];

	//$kodebarang =  $_POST['kodebarang'];
	$barcode = $_POST['barcode'];
	$namabarang = $_POST['namabarang'];
	$id_generik = $_POST['kodebaranginn'];
	$nama_generik = $_POST['namabaranginn'];
	$kekuatan = $_POST['kekuatan'];
	$Sediaan = $_POST['sediaan'];
	$golongan = $_POST['golongan'];
	$detailkemasan = $_POST['detailkemasan'];
	$namalengkap = $_POST['namalengkap'];
	$kemasan = $_POST['kemasan'];
	$isikemasan = $_POST['isikemasan'];
	$satuan = $_POST['satuan'];
	$kelastherapy = $_POST['kelastherapy'];
	$golonganfungsi = $_POST['golonganfungsi'];
	$jenisbarang = $_POST['jenisbarang'];
	$ruangan = $_POST['ruangan'];
	$rak = $_POST['rak'];
	$stok = '0';
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$nobatch = $_POST['nobatch'];
	//tanggal explode
	$expire = $_POST['expire'];
	$expire1=explode("-",$expire);
	$tglexpire=$expire1[2]."-".$expire1[1]."-".$expire1[0];
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];
	$kodeprodusen = $_POST['kodeprodusen'];
	$namapegawaisimpan = $_SESSION['username'];
	
	//elogistik
	$tipe_sediaan = '-';
	$satuan_jual_unit = '-';
	$satuan_klinis = '-';
	$satuan_klinis_unit = '-';
	$org_pembuat = $_POST['produsen'];
	$tgl_out = '';
	$statusapproveelog = $_POST['statusapproveelog'];
	$JenisBarangElog = $_POST['jenisbarangelog'];
	$kategori_objek = $_POST['kelastherapy'];

	//cek barcode sama
	// $cek_barcode = mysqli_num_rows(mysqli_query($koneksi,"SELECT barcode from `tbgfkstok` where `barcode` = '$barcode'"));
	// if($cek_barcode > 0){
		// echo "<script>";
		// echo "alert('Barcode sudah pernah diinputkan');";
		// echo "document.location.href='index.php?page=apotik_gudang_stok_tambah';";
		// echo "</script>";
		// die();
	// }

	//cek gfkstok, nama obat dan tgl expire
	$qexpcek = mysqli_query($koneksi,"SELECT KodeBarang from `tbgfkstok` where MONTH(Expire) = '$expire1[1]' AND YEAR(Expire) = '$expire1[2]' AND NamaBarang = '$namabarang' AND Barcode='$barcode'");
	$cek_expire = mysqli_num_rows($qexpcek);
	
	if($cek_expire > 0){
		$kdb = mysqli_fetch_assoc($qexpcek);
		$kodebarangs = $kdb['KodeBarang'];
	}else{
		$kodebarangs = $kdbarang;
	}
	
	//cek kodebarang di gudang puskesmas jika sudah ada, tidak masuk
	// $cekkodebarang = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang from tbgudanguptdstok where KodeBarang = '$kodebarang'"));
	// if($cekkodebarang > 0){
		// echo "<script>";
		// echo "alert('Barang sudah ada di gudang puskesmas');";
		// echo "document.location.href='index.php?page=apotik_gudang_stok';";
		// echo "</script>";
		// die();
	// }
	
	$str_gop = "INSERT INTO `tbgudanguptdstok`(`KodePuskesmas`,`KodeBarang`,`NoBatch`,`Expire`,`Stok`) 
	VALUES ('$kodepuskesmas','$kodebarangs','$nobatch','$tglexpire','0')";
	$query2=mysqli_query($koneksi,$str_gop);
	
	if($cek_expire == 0){
		$str = "INSERT INTO `tbgfkstok`(`KodeBarang`, `Barcode`, `NamaBarang`, `KodeBarangInn`,`NamaBarangInn`, `Kekuatan`, `Sediaan`, `Golongan`, `DetailKemasan`, 
		`NamaLengkap`, `Kemasan`, `IsiKemasan`, `Satuan`, `JenisBarangElog`, `StatusApproveElog`,`KelasTherapy`, `GolonganFungsi`, `JenisBarang`, `Ruangan`, `Rak`, 
		`Stok`, `MinimalStok`, `HargaBeli`, `NoBatch`, `Expire`, `SumberAnggaran`, `TahunAnggaran`, `KodeSupplier`, `Keterangan`, `NamaPegawaiSimpan`, `TanggalSimpan`)
		VALUES('$kdbarang','$barcode','$namabarang','$id_generik','$nama_generik','$kekuatan','$Sediaan','$golongan','$detailkemasan','$namalengkap','$kemasan',
		'$isikemasan','$satuan','$JenisBarangElog','$statusapproveelog','$kelastherapy','$golonganfungsi','$jenisbarang','$ruangan','$rak','$stok','$minimalstok',
		'$hargabeli','$nobatch','$tglexpire','$sumberanggaran','$tahunanggaran','$kodeprodusen','$kodepuskesmas','$namapegawaisimpan','0000-00-00')";
		$query=mysqli_query($koneksi,$str);
	}
	
	if($query2){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_stok_tambah';";
		echo "</script>";
	} 	
?>