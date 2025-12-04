<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];	
$tanggalso = date('Y-m-d', strtotime($_POST['tanggalso']));	
$bulan= $_POST['bulan'];
$tahun=$_POST['tahun'];	
$keteranganso = $_POST['keteranganso'];	

// nofaktur
$str_nofaktur="SELECT max(NoFaktur)as maxno FROM `tbstokopnam_puskesmas` WHERE substring(NoFaktur,4,4)='$tahun' AND `KodePuskesmas`='$kodepuskesmas'";
$query_nofaktur=mysqli_query($koneksi,$str_nofaktur);
$data_nofaktur=mysqli_fetch_array($query_nofaktur);
$no1=substr($data_nofaktur['maxno'],-5);
$no_next1=$no1+1;
	if(strlen($no_next1)==1)
	{
		$no2="0000".$no_next1;
	}
	elseif(strlen($no_next1)==2)
	{
		$no2="000".$no_next1;
	}
	elseif(strlen($no_next1)==3)
	{
		$no2="00".$no_next1;
	}
	elseif(strlen($no_next1)==4)
	{
		$no2="0".$no_next1;
	}
	else
	{
		$no2=$no_next1;
	}
$nofaktur = "SO/".$tahun."/".$no2;

// cek fatur sama
$cek1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoFaktur`) AS Jml FROM `tbstokopnam_puskesmas` WHERE `NoFaktur`='$nofaktur' AND `KodePuskesmas`='$kodepuskesmas'"));
if ($cek1['Jml'] >=1) {
	echo "<script>";
	echo "document.location.href='?page=lap_farmasi_stok_opname_tambah&stsvalidasi=Data gagal disimpan, No.Faktur sudah pernah diinputkan...'";
	echo "</script>";
	die();
}

// cek faktur dibulan yang sama
$cekfaktur = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoFaktur`) AS Jml FROM `tbstokopnam_puskesmas` WHERE MONTH(TanggalSo)='$bulan' AND YEAR(TanggalSo)='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
if ($cekfaktur['Jml'] > 0) {
	echo "<script>";
	echo "document.location.href='?page=lap_farmasi_stok_opname_tambah&stsvalidasi=Data gagal disimpan, Stok opname sudah pernah dientry bulan ini....'";
	echo "</script>";
	die();
}

// insert
$str = "INSERT INTO `tbstokopnam_puskesmas`(`TanggalSo`,`NoFaktur`,`KodePuskesmas`,`Bulan`,`Tahun`,`Keterangan`) 
VALUES ('$tanggalso','$nofaktur','$kodepuskesmas','$bulan','$tahun','$keteranganso')";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=lap_farmasi_stok_opname';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=lap_farmasi_stok_opname_tambah';";
	echo "</script>";
} 
?>