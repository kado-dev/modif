<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config/koneksi.php";

$asuransi = $_GET['asuransi'];
$keyword = $_GET['keyword'];
if($keyword != ''){
	if($asuransi == "UMUM" or $asuransi == "GRATIS" or $asuransi == "PROGRAM"){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE `Status`='Perda' AND `Tindakan` Like '%$keyword%'");
	}else{
		$query = mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE `Tindakan` Like '%$keyword%'");
	}	
	
	while($dttindakan = mysqli_fetch_assoc($query))	{
		$arr['suggestions'][] = array(
			'idtindakanbpjs'	=> $dttindakan['IdTindakan'],
			'namatindakanbpjs'	=> $dttindakan['Tindakan'],
			'kelompoktindakanbpjs'	=> $dttindakan['KelompokTindakan'],
			'tariftindakanbpjs'	=> $dttindakan['Tarif'],
			'value'	=> $dttindakan['IdTindakan']." | ".$dttindakan['Status']." | ".$dttindakan['Tindakan']
		);	
	}
	echo json_encode($arr);
}	
?>		