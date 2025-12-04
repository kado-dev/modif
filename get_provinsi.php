<?php
	session_start();
	include "config/koneksi.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_propinsi` WHERE CPropDescr LIKE'%$keyword%'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
			'value'=> $data['CPropDescr'],
			'kodeprovinsi'=> $data['CPropID']
		);	
		}
		echo json_encode($arr);
	}	
?>		