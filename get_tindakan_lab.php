<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config/koneksi.php";

$asuransi = $_GET['asuransi'];
$keyword = $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE `KelompokTindakan` Like '%Laboratorium%' AND `JenisTindakan` like '%$keyword%'");	
	while($dttindakan = mysqli_fetch_assoc($query))	{
		$arr['suggestions'][] = array(
			'kodetindakanbpjs'	=> $dttindakan['KodeTindakan'],
			'namatindakanbpjs'	=> $dttindakan['JenisTindakan'],
			'tariftindakanbpjs'	=> $dttindakan['Tarif'],
			'value'	=> $dttindakan['KodeTindakan']." | ".$dttindakan['Status']." | ".$dttindakan['JenisTindakan']
		);	
	}
	echo json_encode($arr);
}	
?>		