<?php
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);

include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tanggal = date('Y-m-d');

$statusdilayani = $_GET['statusdilayani'];

if($statusdilayani == ''){
	if($kota == 'KABUPATEN BOGOR'){
		$statusdilayani = 'SUDAH';
	}else{
		$statusdilayani = 'BELUM';
	}								
}

$statusloket = $_GET['statusloket'];
$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$hariini = date('Y-m-d');
$key = $_GET['key'];

if($tgl1 == null){
	$tglresep = " AND DATE(TanggalResep) = '$hariini'";
}else{								
	$tglresep = " AND DATE(TanggalResep) BETWEEN '$tgl1' AND '$tgl2'";
}

if($key !=''){
	$strcari = " AND (`NamaPasien` Like '%$key%' OR `NoResep` Like '%$key%') AND";
}else{
	$strcari = " ";
}

if($statusdilayani != 'SEMUA'){
	$statusdilayanis = " AND `Status`='$statusdilayani'";
}else{
	$statusdilayanis = " ";
}

// if($loketobat == 'semua'){
// 	$loketobats = "";
// }elseif($loketobat == 'LOKET OBAT'){
// 	$loketobats = " AND Pelayanan <> 'POLI LANSIA'";
// }elseif($loketobat == 'POLI LANSIA'){
// 	$loketobats = " AND Pelayanan = 'POLI LANSIA'";
// }

$str = "SELECT * FROM `$tbresep` WHERE `OpsiResep` = 'diberikan resep' AND `StatusLoket`='$statusloket'".$tglresep.$strcari.$statusdilayanis." GROUP BY NamaPasien, Pelayanan";
$str2 = $str." order by TanggalResep ASC";

$jml = mysqli_num_rows(mysqli_query($koneksi,$str2));

echo "data: ".$jml."\n\n";
flush();
?>