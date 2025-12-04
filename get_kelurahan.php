<?php
	session_start();
	include "config/koneksi.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	// if($keyword != ''){
	// 	$query = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE Kelurahan LIKE'%$keyword%'");
	// 	while($data = mysqli_fetch_assoc($query))
	// 	{
	// 		$arr['suggestions'][] = array(
	// 			'value'	=> $data['Kelurahan'],
	// 			'kode' => $data['Kode'],
	// 			'koderm' => $data['KodeRM'],
	// 			'kelurahan'	=> $data['Kelurahan']
	// 		);	
	// 	}
	// 	echo json_encode($arr);
	// }	

	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ec_subdistricts` WHERE `subdis_name` LIKE'%$keyword%'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['subdis_name'],
				'kode' => $data['subdis_id'],
				'kelurahan'	=> $data['subdis_name']
			);	
		}
		echo json_encode($arr);
	}	
?>		