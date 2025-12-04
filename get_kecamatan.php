<?php
	session_start();
	include "config/koneksi.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	// if($keyword != ''){
	// 	$query = mysqli_query($koneksi,"SELECT * FROM `ref_kecamatan` WHERE KECDESC LIKE'%$keyword%'");
	// 	while($data = mysqli_fetch_assoc($query))
	// 	{
	// 		$arr['suggestions'][] = array(
	// 			'value'	=> $data['KECDESC'],
	// 			'kodekecamatan' => $data['KDKEC']
	// 		);	
	// 	}
	// 	echo json_encode($arr);
	// }	

	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ec_districts` WHERE `dis_name` LIKE'%$keyword%'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['dis_name'],
				'kodekecamatan' => $data['dis_id']
			);	
		}
		echo json_encode($arr);
	}	
?>		