<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tanggalso = date('Y-m-d', strtotime($_POST['tanggalso']));	
$bulan= date('m', strtotime($_POST['tanggalso']));
$tahun= date('Y', strtotime($_POST['tanggalso']));		
$nofakturso = $_POST['nofakturso'];	
$keteranganso = $_POST['keteranganso'];	
$sumberanggaran = $_POST['sumberanggaran'];	

// cek fatur sama
$cek1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoFaktur`) AS Jml FROM `tbgudangpkmstok_opnam` WHERE `NoFaktur`='$nofakturso'"));
if ($cek1['Jml'] >=1) {
	echo "<script>";
	echo "document.location.href='?page=gudang_puskesmas_opnam_tambah&stsvalidasi=Data gagal disimpan, No.Faktur sudah pernah diinputkan...'";
	echo "</script>";
	die();
}

// cek faktur dibulan yang sama
$cek2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoFaktur`) AS Jml FROM `tbgudangpkmstok_opnam` WHERE MONTH(TanggalSo)='$bulan' AND YEAR(TanggalSo)='$tahun'"));
if ($cek2['Jml'] >=1) {
	echo "<script>";
	echo "document.location.href='?page=gudang_puskesmas_opnam_tambah&stsvalidasi=Data gagal disimpan, Stok opname sudah pernah dientry bulan ini....'";
	echo "</script>";
	die();
}

// insert
$str = "INSERT INTO `tbgudangpkmstok_opnam`(`TanggalSo`,`NoFaktur`,`SumberAnggaran`,`Keterangan`,`GrandTotal`,`KodePuskesmas`) 
VALUES ('$tanggalso','$nofakturso','$sumberanggaran','$keteranganso','0','$kodepuskesmas')";

// masuk ke tbstokbulananpuskesmas
$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoFaktur) AS Jml FROM `tbstokbulananpuskesmas` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
if ($cek['Jml'] == 0){				
	$query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok`");
	while($data = mysqli_fetch_assoc($query1)){
		$str1 = "INSERT INTO `tbstokbulananpuskesmas`(`NoFaktur`,`Bulan`,`Tahun`,`KodeBarang`,`NoBatch`,`StokLalu`,`KodePuskesmas`) 
		VALUES ('$nofakturso','$bulan','$tahun','$data[KodeBarang]','$data[NoBatch]','$data[Stok]','$kodepuskesmas')";
		mysqli_query($koneksi, $str1);
	}
}

$query1=mysqli_query($koneksi,$str);
	if($query1){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_puskesmas_opnam';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_puskesmas_opnam_tambah';";
		echo "</script>";
	} 
?>